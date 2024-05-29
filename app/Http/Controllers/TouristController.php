<?php
namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;
use App\Models\Properties;
use App\Models\Tourists;
use App\Models\Bookings;
use App\Models\BookingsTourists;
use App\Models\BookingsStatistics;
use App\Models\Messages;
use App\Models\AccountPlans;
use App\Models\Favourites;
use App\Models\Ratings;
use App\Models\SearchHistory;
use Carbon\Carbon;
use Response;
use File;
use Log;
use Auth;
use DD;

class TouristController extends BaseController
{   private $currentDateTime;

    public function __construct() {
        $this->currentDateTime = Carbon::now()->toDateTimeString();
    }
    public function dashboard(){
        return view('pages.tourist.dashboard.dashboard', [
            'activePage' => 'dashboard'
        ]);
    }
    public function bookings(){
        return view('pages.tourist.bookings.bookings', [
            'activePage' => 'bookings'
        ]);
    }
    public function favourites(){
        return view('pages.tourist.favourites.favourites', [
            'activePage' => 'favourites'
        ]);
    }
    public function searches(){
        return view('pages.tourist.searches.searches', [
            'activePage' => 'searches'
        ]);
    }
    public function reviews(){
        return view('pages.tourist.reviews.reviews', [
            'activePage' => 'reviews'
        ]);
    }
    public function profile(){
        return view('pages.tourist.profile.profile', [
            'activePage' => 'profile'
        ]);
    }
    public function getPageData(Request $request){
        $loggedInUserType = (Auth::guard('tourist')->check()) ? 'tourist' : 'host';
        $user = Auth::guard($loggedInUserType)->user();

        switch ($request->view) {
            case 'dashboard':
                $statisticsData = [
                    'totalRequest'      => [
                        'label' => "Cereri prenotări existente",
                        'description' => 'numărul de cereri efectuate care așteaptă un răspuns din partea gazdelor',
                        'total' => 0
                    ],
                    'totalRequestToPay' => [
                        'label' => "Prenotări de achitat",
                        'description' => 'numărul cererilor de prenotari care au fost acceptate de gazde și trebuie achitate',
                        'total' => 0
                    ],
                    'totalRequestPaid'  => [
                        'label' => "Prenotari achitate",
                        'description' => 'numărul cererilor de prenotari care au fost acceptate de gazde și au fost achitate',
                        'total' => 0
                    ]
                ];

                $now = Carbon::now();

                $bookings = Bookings::where('touristId', $user->id)->with('tourists')->with('property')->get();

                foreach ($bookings as $key => $booking) {
                    if($booking->status == 'request'){
                        $statisticsData['totalRequest']['total']++;
                    }
                    if($booking->status == 'pay'){
                        $statisticsData['totalRequestToPay']['total']++;
                    }
                    if($booking->status == 'paid'){
                        $statisticsData['totalRequestPaid']['total']++;
                    }
                }

                $nextBooking = Bookings::where('touristId', $user->id)->where('status', 'paid')->with('tourists')->with('property')->orderBy('startDate', 'asc')->first();

                if($nextBooking){
                    $propertyImages = json_decode($nextBooking->property->images, true);
                    $nextBooking->property->images = $propertyImages;
                    $nextBooking->property->firstImage = $propertyImages[0];
                }

                return View::make('pages.tourist.dashboard.dashboardItems', ['statisticsData' => $statisticsData, 'nextBooking' => $nextBooking]);

            break;

            case 'bookings':
                $bookings = Bookings::where('touristId', $user->id)->with('tourists')->with('property')->with('messages')->orderByRaw("case status when 'request' then 1 when 'pay' then 2 when 'paid' then 3 when 'ongoing' then 4 when 'rejected' then 5 when 'complete' then 6 end")->paginate(10);

                if(!count($bookings)){
                    return Response::json(['errors' => false], 404);
                }

                return View::make('pages.tourist.bookings.bookingsItems', ['items' => $bookings, 'page' => 'bookings']);
            break;

            case 'favourites':
                $favourites = Favourites::where('touristId', $user->id)->with('property')->with('host')->paginate(10);
                foreach ($favourites as $key => $favourite) {
                    $propertyImages = json_decode($favourite->property->images, true);
                    $favourite->property->images = $propertyImages;
                    $favourites[$key]['property']['firstImage'] = $propertyImages[0];
                }

                if(!count($favourites)){
                    return Response::json(['errors' => false], 404);
                }

                return View::make('pages.tourist.favourites.favouritesItems', ['items' => $favourites, 'page' => 'bookings']);
            break;

            case 'searches':
                $searches = SearchHistory::where('touristId', $user->id)->paginate(15);

                if(!count($searches)){
                    return Response::json(['errors' => false], 404);
                }

                return View::make('pages.tourist.searches.searchesItems', ['items' => $searches, 'page' => 'searches']);
            break;

            case 'reviews':
                $bookings = Bookings::where('touristId', $user->id)->where('status', 'complete')->with('tourists')->with('property')->with('ratings')->orderBy('endDate', 'DESC')->paginate(10);

                if(!count($bookings)){
                    return Response::json(['errors' => false], 404);
                }

                return View::make('pages.tourist.reviews.reviewsItems', ['items' => $bookings, 'page' => 'reviews']);
            break;

            case 'profile':
               $user = Auth::guard('tourist')->user();
               return View::make('pages.tourist.profile.profileItems', ['user' => $user]);
            break;
        }
    }

    public function sendMessage(Request $request){
        $user = Auth::guard('tourist')->user();

        $message = new Messages;
        $message->bookingId = $request->bookingId;
        $message->message = $request->message;
        $message->hostId = $user->id;
        $message->added = $this->currentDateTime;
        $message->updated = $this->currentDateTime;
        $message->save();

        return Response::json(['success' => true], 200);
    }

    public function removeFavourite(Request $request){
        Favourites::where('id', $request->id)->delete();
    }
    public function saveReview(Request $request){
        $user = Auth::guard('tourist')->user();
        $starsRating = json_decode($request->starsObject, true);
        $rating = new Ratings;
        $rating->bookingId = $request->bookingId;
        $rating->touristId = $user->id;
        $rating->hostId = $request->hostId;
        $rating->propertyId = $request->propertyId;
        $rating->overall = ($starsRating['confort'] + $starsRating['cleanlines'] + $starsRating['location'] + $starsRating['communication']) / 4;
        $rating->description = $request->reviewDescription;
        $rating->confort = $starsRating['confort'];
        $rating->cleanlines = $starsRating['cleanlines'];
        $rating->location = $starsRating['location'];
        $rating->comunication = $starsRating['communication'];
        $rating->starsHtml = $request->starsHTML;
        $rating->added = $this->currentDateTime;
        $rating->updated = $this->currentDateTime;
        $rating->save();

        return Response::json(['success' => true], 200);

    }
    public function pay(Request $request){
        $booking = Bookings::find($request->bookingId);
        $booking->status = 'paid';
        $booking->save();

        return Response::json(['success' => true], 200);
    }

    public function saveProfile(Request $request){
        $user = Auth::guard('tourist')->user();

        $validatedData = $request->validate([
            'alias' => 'required',
            'firstName' => 'required',
            'lastName' => 'required',
            'email' =>'required|email'
        ], [
            'alias.required' => 'Modificați alias-ul de utilizator',
            'firstName.required' => 'Modificați numele',
            'lastName.required' => 'Modificați prenumele',
            'email.required' => 'Modificați adresa de email',
            'email.email' => 'Introduceți o adresă de email corectă'
        ]);
        
        $tourist = Tourists::find($user->id);
        $tourist->alias = $validatedData['alias'];
        $tourist->firstName = $validatedData['firstName'];
        $tourist->lastName = $validatedData['lastName'];
        $tourist->email = $validatedData['email'];
        $tourist->save();

        return response()->json(['message' => 'Profilul turistului a fost actualizat cu succes'], 200);
    
    }
}
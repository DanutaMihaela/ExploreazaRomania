<?php namespace App\Http\Controllers;
    use Illuminate\Routing\Controller as BaseController;
    use Illuminate\Support\Facades\DB;
    use App\Models\Tourists;
    use Illuminate\Http\Request;
    use Illuminate\Mail\Message;
    use Illuminate\Support\Facades\Mail;
    use App\Models\Hosts;
    use App\Models\Properties;
    use App\Models\Bookings;
    use App\Models\BookingsTourists;
    use App\Models\Messages;
    use App\Models\BookingsStatistics;
    use App\Models\Favourites;
    use App\Models\SearchHistory;
    use Carbon\Carbon;
    use Response;
    use Log;
    use Auth;
    use View;
   
    class HomeController extends BaseController
    {
       
        private $currentDateTime;

        public function __construct() {
            
            $this->currentDateTime = Carbon::now()->toDateTimeString();
        }

        public function index(){
            
            return view('main', []);
        }

        
        public function search(Request $request){
            $loggedInUserType = (Auth::guard('tourist')->check()) ? 'tourist' : 'host';
            $user = Auth::guard($loggedInUserType)->user();
            $validatedData = $request->validate([
                'fromDate' => 'required',
                'toDate' => 'required',
                'rooms' => 'required',
                'guestsNumber' => 'required'
            ]);
            $startDate = Carbon::createFromFormat('d/m/Y', $request->fromDate)->format('Y-m-d 00:00:00');
            $endDate = Carbon::createFromFormat('d/m/Y', $request->toDate)->format('Y-m-d 23:59:59');
            $properties = DB::table('Properties')
            ->select('properties.*', 'hosts.trial')
            ->where('rooms', '>=', $request->rooms)
            ->where('guests', '>=', $request->guestsNumber)
            ->where('properties.siteVizibility', 1)
            ->join('hosts', function($query){ 
                $query->on('properties.hostId', '=', 'hosts.id')->where('hosts.planEndDate', '>=', 
                Carbon::now())->where('hosts.siteVizibility', '=', 1); 
            })
            ->whereNotIn('properties.id', function($query) use ($startDate, $endDate){ 
                $query->select('propertyId')->from('Bookings')
                    ->where('status', '!=', 'ongoing')
                    ->where(function($query) use ($startDate, $endDate){
                        $query->where('startDate', '<=', $startDate);
                        $query->where('endDate', '>=', $startDate);
                    })
                    ->orWhere(function($query) use ($startDate, $endDate){
                        $query->where('startDate', '<=', $endDate);
                        $query->where('endDate', '>=', $endDate);
                    })
                    ->orWhere(function($query) use ($startDate, $endDate){
                        $query->where('startDate', '>=', $startDate);
                        $query->where('endDate', '<=', $endDate);
                    });
            })->paginate(6); 
            if($user && $loggedInUserType == 'tourist'){
                $userBookings = DB::table('Bookings')->where('touristId', $user->id)->whereIn('status', ['request', 'ongoing'])->get();
                $userFavourites = DB::table('Favourites')->where('touristId', $user->id)->get();
                if(count($properties)){
                    $searchHistory = new SearchHistory;
                    $searchHistory->touristId = $user->id;
                    $searchHistory->startDate = $startDate;
                    $searchHistory->endDate = $endDate;
                    $searchHistory->rooms = $request->rooms;
                    $searchHistory->tourists = $request->guestsNumber;
                    $searchHistory->added = $this->currentDateTime;
                    $searchHistory->updated = $this->currentDateTime;
                    $searchHistory->save();
                }
            }
            foreach ($properties as $key => $property) {
                $property->userOngoingBooking = false;
                $property->userFavourite = false;
                if($user && isset($userBookings) && $loggedInUserType == 'tourist'){
                    foreach ($userBookings as $userBooking) {
                        if($property->id == $userBooking->propertyId){
                            $property->userOngoingBooking = true;
                        }
                    }
                    foreach ($userFavourites as $userFavourite) {
                        if($property->id == $userFavourite->propertyId){
                            $property->userFavourite = true;
                        }
                    }
                }
                $propertyImages = json_decode($property->images, true);
                $property->images = $propertyImages;
                $property->firstImage = $propertyImages[0];
            }
            if(count($properties)){
                return View::make('pages.host.properties.property', ['items' => $properties,
                'page' => 'searchPage', 'search' => true, 'user' => $user, 'userType' => $loggedInUserType]);
            }
            else{
                return false;
            }

        }
        
        public function book(Request $request){
            
            $loggedInUserType = (Auth::guard('tourist')->check()) ? 'tourist' : 'host';
            $user = Auth::guard($loggedInUserType)->user();
            $decodedTourists = json_decode($request->tourists, true);

            $booking = new Bookings;
            $booking->propertyId = $request->propertyId;
            $booking->hostId = $request->hostId;
            $booking->touristId = $request->touristId;
            $booking->startDate = Carbon::createFromFormat('d/m/Y', $request->fromDate)->format('Y-m-d');
            $booking->endDate = Carbon::createFromFormat('d/m/Y', $request->toDate)->format('Y-m-d');
            $booking->status = 'request';
            $booking->totalPrice = Carbon::parse(Carbon::createFromFormat('d/m/Y', $request->fromDate)->format('Y-m-d'))->diffInDays(Carbon::parse(Carbon::createFromFormat('d/m/Y', $request->toDate)->format('Y-m-d'))) * $request->pricePerNight;
            $booking->added = $this->currentDateTime;
            $booking->updated = $this->currentDateTime;
            $booking->save();

            if($request->message){
                $messages = new Messages;
                $messages->bookingId = $booking->id;
                $messages->touristId = $user->id;
                $messages->message = $request->message;
                $messages->added = $this->currentDateTime;
                $messages->updated = $this->currentDateTime;
                $messages->save();
            }
            if(count($decodedTourists)){
                foreach ($decodedTourists as $key => $touristItem) {
                
                    $tourist = new BookingsTourists;
                    $tourist->bookingId = $booking->id;
                    $tourist->firstName = $touristItem['firstName'];
                    $tourist->lastName = $touristItem['lastName'];
                    $tourist->added = $this->currentDateTime;
                    $tourist->updated = $this->currentDateTime;
                    $tourist->save();
                }
            }

            $bookingStatistics = new BookingsStatistics;
            $bookingStatistics->hostId = $request->hostId;
            $bookingStatistics->statisticType = 'request';
            $bookingStatistics->bookingId = $booking->id;
            $bookingStatistics->month = Carbon::createFromFormat('Y-m-d H:i:s', $this->currentDateTime)->month;
            $bookingStatistics->year = Carbon::createFromFormat('Y-m-d H:i:s', $this->currentDateTime)->year;
            $bookingStatistics->totalTourists = count($decodedTourists);
            $bookingStatistics->totalPrice = Carbon::parse(Carbon::createFromFormat('d/m/Y', $request->fromDate)->format('Y-m-d'))->diffInDays(Carbon::parse(Carbon::createFromFormat('d/m/Y', $request->toDate)->format('Y-m-d'))) * $request->pricePerNight;
            $bookingStatistics->totalDaysBooked = Carbon::parse(Carbon::createFromFormat('d/m/Y', $request->fromDate)->format('Y-m-d'))->diffInDays(Carbon::parse(Carbon::createFromFormat('d/m/Y', $request->toDate)->format('Y-m-d')));
            $bookingStatistics->added = $this->currentDateTime;
            $bookingStatistics->updated = $this->currentDateTime;
            $bookingStatistics->save();
            return Response::json(['success' => true, 'successMessage' => 'Cererea de prenotare a fost trimisa cu success'], 200);

        }
        public function favourite(Request $request){
            $loggedInUserType = (Auth::guard('tourist')->check()) ? 'tourist' : 'host';
            $user = Auth::guard($loggedInUserType)->user();
            if($loggedInUserType == 'tourist'){
                
                $alreadyFavourite = Favourites::where('propertyId', $request->propertyId)->where('touristId', $user->id)->first();
                if($alreadyFavourite){
                    Favourites::where('id', $alreadyFavourite->id)->delete();
                }
                else{
                    $favourites = new Favourites;
                    $favourites->touristId = $user->id;
                    $favourites->propertyId = $request->propertyId;
                    $favourites->hostId = $request->hostId;
                    $favourites->added = $this->currentDateTime;
                    $favourites->updated = $this->currentDateTime;
                    $favourites->save();
                }
            }
        }

    }
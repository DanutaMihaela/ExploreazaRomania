<?php
namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;
use App\Models\Hosts;
use App\Models\Properties;
use App\Models\Bookings;
use App\Models\BookingsTourists;
use App\Models\BookingsStatistics;
use App\Models\Messages;
use App\Models\AccountPlans;
use Carbon\Carbon;
use Response;
use File;
use Log;
use Auth;
use DD;


class HostController extends BaseController
{
    private $currentDateTime;

    public function __construct() {
        $this->currentDateTime = Carbon::now()->toDateTimeString();
    }
    public function dashboard(){
        return view('pages.host.dashboard.dashboard', [
            'activePage' => 'dashboard'
        ]);
    }
    
    public function properties(){
        return view('pages.host.properties.properties', [
            'activePage' => 'properties'
        ]);
    }
    public function bookings(){
        return view('pages.host.bookings.bookings', [
            'activePage' => 'bookings'
        ]);
    }
    public function profile(){
        return view('pages.host.profile.profile', [
            'activePage' => 'profile'
        ]);
    }
    public function account(){
        return view('pages.host.account.account', [
            'activePage' => 'account'
        ]);
    }

    public function getPageData(Request $request){
        $loggedInUserType = (Auth::guard('tourist')->check()) ? 'tourist' : 'host';
        $user = Auth::guard($loggedInUserType)->user();
        switch ($request->view) {
            case 'dashboard':
                $statisticsData = [
                    'totalRequestsThisMonth'         => [
                        'label' => "Cereri prenotări luna curenta",
                        'description' => 'suma tuturor cererilor de prenotare făcute de turiști în decursul lunii curente',
                        'total' => 0
                    ],
                    'totalRequestsThisYear'          => [
                        'label' => "Total cereri prenotări anul curent",
                        'description' => 'suma tuturor cererilor de prenotare făcute de turiști în decursul anului curent',
                        'total' => 0
                    ],
                    'totalRequestsRejectedThisMonth' => [
                        'label' => "Total prenotari respinse în luna curenta",
                        'description' => 'suma tuturor cererilor de prenotare făcute de turiști în decursul lunii curente, care au fost respinse de dvs.',
                        'total' => 0
                    ],
                    'totalRequestsRejectedThisYear'  => [
                        'label' => "Total prenotări respinse anul curent",
                        'description' => 'suma tuturor cererilor de prenotare făcute de turiști în decursul anului curent, care au fost respinse de dvs.',
                        'total' => 0
                    ],
                    'totalCompleteRequestsThisMonth' => [
                        'label' => "Total prenotari acceptate luna curenta",
                        'description' => 'suma tuturor prenotărilor în decursul lunii curente (în desfășurare sau care urmează să fie în desfășurare)',
                        'total' => 0
                    ],
                    'totalCompleteRequestsThisYear'  => [
                        'label' => "Total prenotări acceptate anul curent",
                        'description' => 'suma tuturor prenotărilor în decursul anului curent (în desfășurare sau care urmeaza să fie în desfășurare)',
                        'total' => 0
                    ],
                    'totalEarningsThisMonth'         => [
                        'label' => "Total încasări luna curenta",
                        'description' => 'suma tuturor încasarilor în urma prenotarilor (în desfășurare sau care urmeaza să fie în desfășurare) în decursul lunii curente',
                        'total' => 0
                    ],
                    'totalEarningsThisYear'          => [
                        'label' => "Total încasări anul curent",
                        'description' => 'suma tuturor încasărilor în urma prenotărilor (în desfășurare sau care urmează să fie în desfășurare) în decursul anului curent',
                        'total' => 0
                    ],
                    'totalTouristsThisMonth'         => [
                        'label' => "Total turiști luna curenta",
                        'description' => 'total turiști ale prenotărilor care sunt în desfășare sau urmează să se desfășoare în această lună',
                        'total' => 0
                    ],
                    'totalTouristsThisYear'          => [
                        'label' => "Total turiști anul curent",
                        'description' => 'total turiști ale prenotărilor care sunt în desfășurare sau urmeaza să se desfășoare în aceast an',
                        'total' => 0
                    ],
                    'totalTouristsLastMonth'         => [
                        'label' => "Total turiști luna trecută",
                        'description' => 'total turiști prenotați luna trecută',
                        'total' => 0
                    ],
                    'totalTouristsLastYear'          => [
                        'label' => "Total turiști anul trecut",
                        'description' => 'total turiști prenotați anul trecut',
                        'total' => 0
                    ],
                    'totalEarningsLastMonth'         => [
                        'label' => "Total încasări luna trecută",
                        'description' => 'total încasări în urma prenotărilor acceptate luna trecută',
                        'total' => 0
                    ],
                    'totalEarningsLastYear'          => [
                        'label' => "Total încasări anul trecut",
                        'description' => 'total încasări în urma prenotărilor acceptate anul trecut',
                        'total' => 0
                    ]
                ];

                $now = Carbon::now();
                $hostStatisticsData = BookingsStatistics::where(['hostId' => $user->id])->get();
                foreach ($hostStatisticsData as $key => $statisticsRecord) {

                    if($statisticsRecord->statisticType == 'request' && $statisticsRecord->month == $now->month){
                        $statisticsData['totalRequestsThisMonth']['total']++;
                    }
                    
                    if($statisticsRecord->statisticType == 'request' && $statisticsRecord->year == $now->year){
                        $statisticsData['totalRequestsThisYear']['total']++;
                    }
                   
                    if($statisticsRecord->statisticType == 'rejected' && $statisticsRecord->month == $now->month){
                        $statisticsData['totalRequestsRejectedThisMonth']['total']++;
                    }
                    
                    if($statisticsRecord->statisticType == 'rejected' && $statisticsRecord->year == $now->year){
                        $statisticsData['totalRequestsRejectedThisYear']['total']++;
                    }
                    
                    if($statisticsRecord->statisticType == 'ongoing' && $statisticsRecord->month == $now->month){
                        $statisticsData['totalCompleteRequestsThisMonth']['total']++;
                    }
                   
                    if($statisticsRecord->statisticType == 'ongoing' && $statisticsRecord->year == $now->year){
                        $statisticsData['totalCompleteRequestsThisYear']['total']++;
                    }
                   
                    if($statisticsRecord->statisticType == 'ongoing' && $statisticsRecord->month == $now->month){
                        $statisticsData['totalEarningsThisMonth']['total'] += $statisticsRecord->totalPrice;
                    }
                    
                    if($statisticsRecord->statisticType == 'ongoing' && $statisticsRecord->year == $now->year){
                        $statisticsData['totalEarningsThisYear']['total'] += $statisticsRecord->totalPrice;
                    }
                   
                    if($statisticsRecord->statisticType == 'ongoing' && $statisticsRecord->month == $now->month){
                        $statisticsData['totalTouristsThisMonth']['total'] += $statisticsRecord->totalTourists;
                    }
                    
                    if($statisticsRecord->statisticType == 'ongoing' && $statisticsRecord->year == $now->year){
                        $statisticsData['totalTouristsThisYear']['total'] += $statisticsRecord->totalTourists;
                    }
                    
                    if($statisticsRecord->statisticType == 'ongoing' && $statisticsRecord->month == $now->month - 1){
                        $statisticsData['totalTouristsLastMonth']['total'] += $statisticsRecord->totalTourists;
                    }
                    
                    if($statisticsRecord->statisticType == 'ongoing' && $statisticsRecord->month == $now->month - 1){
                        $statisticsData['totalEarningsLastMonth']['total'] += $statisticsRecord->totalPrice;
                    }
                    
                    if($statisticsRecord->statisticType == 'ongoing' && $statisticsRecord->year == $now->year - 1){
                        $statisticsData['totalTouristsLastYear']['total'] += $statisticsRecord->totalTourists;
                    }
                    
                    if($statisticsRecord->statisticType == 'ongoing' && $statisticsRecord->year == $now->year - 1){
                        $statisticsData['totalEarningsLastYear']['total'] += $statisticsRecord->totalPrice;
                    }
                }
               
                return View::make('pages.host.dashboard.dashboardItems', ['statisticsData' => $statisticsData]);
            break;

            case 'properties':
                
                $properties = Properties::where(['hostId' => $user->id])->paginate(3);
                foreach ($properties as $key => $property) {
                    $propertyImages = json_decode($property->images, true);
                    $property->images = $propertyImages;
                    $properties[$key]['firstImage'] = $propertyImages[0];
                }

                if(!count($properties)){
                    return Response::json(['errors' => false], 404);
                }
                return View::make('pages.host.properties.property', ['items' => $properties, 'page' => 'properties', 'search' => false, 'user' => $user, 'userType' => $loggedInUserType]);
            break;

            case 'bookings':
               
                $bookings = Bookings::where(['hostId' => $user->id])->with('tourists')->with('property')->with('messages')->orderByRaw("case status when 'request' then 1 when 'pay' then 2 when 'paid' then 3 when 'ongoing' then 4 when 'rejected' then 5 when 'complete' then 6 end")->paginate(10);

                if(!count($bookings)){
                    return Response::json(['errors' => false], 404);
                }
                
                return View::make('pages.host.bookings.bookingsItems', ['items' => $bookings, 'page' => 'bookings']);
            break;

            case 'profile':
                $user = Auth::guard('host')->user();
                return View::make('pages.host.profile.profileItems', ['user' => $user]);
            break;

            case 'account':
                
                $accountPlans = AccountPlans::get();

                return View::make('pages.host.account.accountItems', ['accountPlans' => $accountPlans, 'user' => $user]);
            break;

        }
    }

   
    public function saveProperty(Request $request){
       
        $loggedInUserType = (Auth::guard('tourist')->check()) ? 'tourist' : 'host';
        $loggedInUser = Auth::guard($loggedInUserType)->user();
        $user = Hosts::with('plan')->find($loggedInUser->id);
        $validatedData = $request->validate([
            'name' => 'required|min:5|max:255|regex:/(^[A-Za-z0-9 ]+$)+/',
            'description' => 'required|min:50',
            'rooms' => 'required|numeric|between:1,100',
            'guests' => 'required|numeric|between:1,100',
            'price' => 'required|numeric|between:1.00,10000.99',
            'files' => 'required|array'
        ], [
            'name.required' => 'Introduceți numele proprietății dvs.',
            'name.min' => 'Numele trebuie să conțină cel puțin 5 caractere',
            'name.max' => 'Numele trebuie să conțină cel mult 255 caractere',
            'name.regex' => 'Numele nu poate să conțină caractere speciale',
            'description.required' => 'Introduceți o descriere reprezentativă a proprietății',
            'description.min' => 'Descrierea proprietății trebuie să contina cel puțin 50 de caractere',
            'rooms.required' => 'Introduceți numărul de camere disponibile la proprietate',
            'rooms.numeric' => 'Sunt acceptate doar numere pentru acest câmp',
            'rooms.between' => 'Numărul de camere între 0 și 100',
            'guests.required' => 'Selectați numărul maxim de turiști care se pot caza la proprietate',
            'guests.numeric' => 'Sunt acceptate doar numere pentru acest câmp',
            'guests.between' => 'Numărul de turiști trebuie să fie între 0 și 100',
            'files.required' => 'Adăugați cel puțin o poză pentru anunțul dvs.',
            'files.mimes' => 'Sunt acceptate doar fișiere de tipul: JPG, JPEG, PNG'
        ]);

       
        if($request->siteVizibility && $user->plan->propertiesVizibilityNumber != 'unlimited'){
            $liveHostProperties = Properties::where('siteVizibility', 1)->where('hostId', $user->id)->count();
            $remaining = $user->plan->propertiesVizibilityNumber - $liveHostProperties;

            $currentPropertySiteVizibility = false;
            if($request->id){
                $property = Properties::find($request->id);
                $currentPropertySiteVizibility = $property->siteVizibility;
            }

            if($remaining <= 0 && !$currentPropertySiteVizibility){
                if($liveHostProperties == $user->plan->propertiesVizibilityNumber){
                    return Response::json(['errors' => ['vizibility' => ['errors' => 'Eroare salvare. Planul dumneavoastra va permite sa aveti vizibile pe site doar ' . $user->plan->propertiesVizibilityNumber . (($user->plan->propertiesVizibilityNumber == 1) ? ' proprietate.' : ' proprietati.') . '<br>Face-ti upgrade la planul dvs, sau alegeti un plan pentru contrul dvs. pentru a activa vizibilitatea acestei propritati']]], 404);
                }
            }
        }

        
        if($request->id){
            $property = Properties::find($request->id);
        }
        else{
            $property = new Properties;
        }

        $imagesNames = [];
        foreach ($request->files as $key => $fileArray) {
            foreach ($fileArray as $key => $fileItem) {
                array_push($imagesNames, $fileItem->getClientOriginalName());
            }
        }
        $property->name = $validatedData['name'];
        $property->hostId = $user->id;
        $property->description = $validatedData['description'];
        $property->rooms = $validatedData['rooms'];
        $property->guests = $validatedData['guests'];
        $property->price_per_night = $validatedData['price'];
        $property->images = json_encode($imagesNames);
        $property->siteVizibility = $request->siteVizibility;
        $property->added = $this->currentDateTime;
        $property->updated = $this->currentDateTime;
        $property->save();

        if($request->id && $request->imagesToDelete != ''){
            $imagesToDelete = explode(",", $request->imagesToDelete);
            foreach ($imagesToDelete as $key => $fileToDelete) {
                Storage::disk('hosts')->delete($user->id . '/propertiesImages/' . $property->id . '/' . $fileToDelete);
            }
        }
        if(!Storage::disk('hosts')->exists('/' . $user->id . '/propertiesImages')) {
            Storage::disk('hosts')->makeDirectory($user->id . '/propertiesImages', 0775, true);
        }

        foreach ($request->files as $key => $fileArray) {
            foreach ($fileArray as $key => $fileItem) {
                if(!Storage::disk('hosts')->exists($user->id . '/propertiesImages/' . $property->id . '/' . $fileItem->getClientOriginalName())){
                    Storage::disk('hosts')->put($user->id . '/propertiesImages/' . $property->id . '/' . $fileItem->getClientOriginalName(), file_get_contents($fileItem));
                }
            }
        }
        return Response::json(['success' => true], 200);
    }

    public function getProperty(Request $request){
        $user = Auth::guard('host')->user();

        $property = Properties::where(['id' => $request->id])->first();
        $property->images = json_decode($property->images);

        $filesArray = [];
        foreach ($property->images as $key => $file) {
            $extensions = explode('.', basename($file));
            array_push($filesArray, [
                'name' => basename($file),
                'mimeType' => 'image/' . $extensions[1],
                'mime' => 'image/' . $extensions[1]
            ]);
        }

        $property->images = $filesArray;
        return $property;
    }

    public function removeProperty(Request $request){
        $property = Properties::find($request->id);
        if($property){
            $property->delete();
        }
    }
    public function updateBookingStatus(Request $request){

        $booking = Bookings::with('tourists')->with('property')->find($request->bookingId);
        $booking->status = $request->newStatus;
        $booking->updated = $this->currentDateTime;
        Log::info($booking);
        $booking->save();

        $bookingStatistics = new BookingsStatistics;
        $bookingStatistics->hostId = $booking->hostId;
        $bookingStatistics->statisticType = $request->newStatus;
        $bookingStatistics->bookingId = $booking->id;
        $bookingStatistics->month = Carbon::createFromFormat('Y-m-d H:i:s', $this->currentDateTime)->month;
        $bookingStatistics->year = Carbon::createFromFormat('Y-m-d H:i:s', $this->currentDateTime)->year;
        $bookingStatistics->totalTourists = count($booking->tourists);
        $bookingStatistics->totalPrice = Carbon::parse(Carbon::createFromFormat('Y-m-d', $booking->startDate)->format('Y-m-d'))->diffInDays(Carbon::parse(Carbon::createFromFormat('Y-m-d', $booking->endDate)->format('Y-m-d'))) * $booking->property->price_per_night;
        $bookingStatistics->totalDaysBooked = Carbon::parse(Carbon::createFromFormat('Y-m-d', $booking->startDate)->format('Y-m-d'))->diffInDays(Carbon::parse(Carbon::createFromFormat('Y-m-d', $booking->endDate)->format('Y-m-d')));
        $bookingStatistics->added = $this->currentDateTime;
        $bookingStatistics->updated = $this->currentDateTime;
        $bookingStatistics->save();

        return Response::json(['success' => true], 200);
    }

    
    public function sendMessage(Request $request){
        $user = Auth::guard('host')->user();
        $message = new Messages;
        $message->bookingId = $request->bookingId;
        $message->message = $request->message;
        $message->hostId = $user->id;
        $message->added = $this->currentDateTime;
        $message->updated = $this->currentDateTime;
        $message->save();

        return Response::json(['success' => true], 200);
    }


    public function saveProfile(Request $request){
        $user = Auth::guard('host')->user();

        $validatedData = $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'telephone' =>'required',
            'website' =>'nullable|url',
            'email' =>'required|email'
        ], [
            'firstName.required' => 'Modificați numele',
            'lastName.required' => 'Modificați prenumele',
            'telephone.required' => 'Modificați numărul de telefon',
            'website.required' => 'Modificați website-ul',
            'email.required' => 'Modificați adresa de email',
            'email.email' => 'Introduceți o adresă de email corectă'
        ]);

        $host = Hosts::find($user->id);

        $host->firstName = $validatedData['firstName'];
        $host->lastName = $validatedData['lastName'];
        $host->telephone = $validatedData['telephone'];
        $host->website = $validatedData['website'];
        $host->email = $validatedData['email'];

        $host->save();

        return response()->json(['message' => 'Profilul gazdei a fost actualizat cu succes'], 200);
        

    }
}

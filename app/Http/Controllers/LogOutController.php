<?php
namespace App\Http\Controllers;
use Auth;
use Session;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Tourists;
use App\Models\Hosts;
use Carbon\Carbon;
use Log;

    class LogOutController extends BaseController
    {
        private $currentDateTime;

        public function __construct() {
            $this->currentDateTime = Carbon::now()->toDateTimeString();
        }
       
        public function logout(){
            $loggedInUserType = (Auth::guard('tourist')->check()) ? 'tourist' : 'host';
            Auth::guard($loggedInUserType)->logout();
            Session::flush();
            return redirect('/');
        }
    }
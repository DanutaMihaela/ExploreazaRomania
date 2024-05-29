    <?php

    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Redirect;
    use Illuminate\Support\Facades\Auth;
    use App\Http\Controllers\HomeController;
    use App\Http\Controllers\RegisterController;
    use App\Http\Controllers\LoginController;
    use App\Http\Controllers\LogOutController;
    use App\Http\Controllers\TouristController;
    use App\Http\Controllers\HostController;
    use App\Http\Controllers\ContactController;


    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | contains the "web" middleware group. Now create something great!
    |
    */

    Route::controller(HomeController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('search', 'search');
        Route::post('book', 'book');
        Route::post('favourite', 'favourite');
    });

    Route::controller(RegisterController::class)->group(function () {
        Route::post('/register', 'register');
        Route::post('/checkTouristUniqueData', 'checkTouristUniqueData');
    });


    Route::controller(LoginController::class)->group(function () {
        Route::post('login', 'login');
    });

    Route::middleware(['TouristIsAuthenticated'])->group(function () {

        Route::controller(TouristController::class)->group(function () {
            Route::get('tourist', 'dashboard');
            Route::get('tourist/dashboard', 'dashboard');
            Route::get('tourist/bookings', 'bookings');
            Route::get('tourist/favourites', 'favourites');
            Route::get('tourist/searches', 'searches');
            Route::get('tourist/reviews', 'reviews');
            Route::get('tourist/profile', 'profile');

            Route::post('tourist/getPageData', 'getPageData');
            Route::post('tourist/sendMessage', 'sendMessage');
            Route::post('tourist/removeFavourite', 'removeFavourite');
            Route::post('tourist/saveReview', 'saveReview');
            Route::post('tourist/pay', 'pay');
        });
    });

    Route::middleware(['HostIsAuthenticated'])->group(function () {
        
        Route::controller(HostController::class)->group(function () {
            Route::get('host', 'dashboard');
            Route::get('host/dashboard', 'dashboard');
            Route::get('host/properties', 'properties');
            Route::get('host/bookings', 'bookings');
            Route::get('host/profile', 'profile');
            Route::get('host/account', 'account');

            Route::post('host/getPageData', 'getPageData');
            Route::post('host/saveProperty', 'saveProperty');
            Route::post('host/getProperty', 'getProperty');
            Route::post('host/removeProperty', 'removeProperty');
            Route::post('host/updateBookingStatus', 'updateBookingStatus');
            Route::post('host/sendMessage', 'sendMessage');
        });
    });

    
    Route::controller(LogOutController::class)->group(function () {
        Route::get('logout', 'logout');
    });

   
    Route::get ('/contact', [ContactController::class, 'contact']);
    Route::post ('/contacteaza', [ContactController::class, 'contacteaza']);

  
    Route::post ('/saveHostProfile', [HostController::class, 'saveProfile']);
    Route::post ('/saveTouristProfile', [TouristController::class, 'saveProfile']);
<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\PropertiesController;
use App\Http\Controllers\Admin\Amenities\AmenitiesController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ReservationsController;
use App\Http\Controllers\Admin\Reservations\ReservationsController as AdminReservationsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Transactions\TransactionsController;
use App\Http\Controllers\Admin\SortableController;
use App\Http\Controllers\Admin\Reports\ReportsController;
use App\Http\Controllers\Admin\Properties\PropertiesController as AdminPropertiesController;
use App\Http\Controllers\Admin\Features\FeaturesController;
use App\Http\Controllers\Admin\Services\ServicesController;
use App\Http\Controllers\Admin\LineItems\LineItemsController;
use App\Http\Controllers\Admin\Seasons\SeasonsController;
use App\Http\Controllers\Admin\PropertyTypes\PropertyTypesController;
use App\Http\Controllers\Admin\PropertyClasses\PropertyClassesController;
use App\Http\Controllers\Admin\Locations\LocationsController;
use App\Http\Controllers\Admin\Facilitators\FacilitatorsController;
use App\Http\Controllers\Admin\Owners\OwnersController;
use App\Http\Controllers\Admin\Sliders\SlidersController;
use App\Http\Controllers\Admin\Pages\PagesController as AdminPagesController;
use App\Http\Controllers\Admin\EmailTemplates\EmailTemplatesController;
// use App\Http\Controllers\Admin\Users\UserController;
// use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\Navigation\NavigationController;
use App\Http\Controllers\Admin\Settings\SettingsController;
use App\Http\Controllers\Admin\Users\UserController;

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

Route::get('/',[PagesController::class, 'home'])->name('home'); 

Auth::routes();
Auth::routes(['verify' => true]);

Route::get('logout', function (){ Auth::logout(); return redirect()->route('login');});

Route::get('admin',
function ()
  { //Redirect the admin default page to dashboard.
    return redirect('/admin/dashboard');
  });

//Laravel's default Auth/Password controllers.
// Route::controllers(['auth' => 'Auth\AuthController', 'password' => 'Auth\PasswordController', ]);


Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth']],
function ()
  {
    Route::get('/dashboard', [AdminController::class, 'dashboard']); // Dashboard
    Route::get('/sortable/update', [SortableController::class, 'update']); // Updates the display order of entries.
    Route::get('/sortable', [SortableController::class, 'index']); // Loads the view of display order.
    Route::group(['prefix' => 'reservations', 'namespace' => 'Reservations'],
    function ()
      {
        Route::get('/', [AdminReservationsController::class, 'index']); // show list of Reservations
        Route::get('/search/{date_start?}/{date_end?}', [AdminReservationsController::class, 'search']); // show new Reservations form
        Route::get('/create/{property?}/{date_start?}/{date_end?}', [AdminReservationsController::class, 'create']); // save new Reservations
        Route::post('/store/{slug}', [AdminReservationsController::class, 'store']); // save new Reservations
        Route::get('/show/{id}', [AdminReservationsController::class, 'show']); // show list of Reservations
        Route::post('/approve', [AdminReservationsController::class, 'approve']); // approve Reservations
        Route::get('/edit/{slug}', [AdminReservationsController::class, 'edit']); // edit Reservations form
        Route::post('/update', [AdminReservationsController::class, 'updater']); // update Reservations
        Route::get('/delete/{id}', [AdminReservationsController::class, 'destroy']); // delete Reservations
      });
    Route::get('/calendar-view/{year?}/{month?}', [AdminReservationsController::class, 'calendarView']); //Shows all reservations in a month
    Route::group(['prefix' => 'transactions', 'namespace' => 'Transactions'],
    function ()
      {
        Route::get('/', [TransactionsController::class, 'index']); // show list of Transactions
        Route::get('/create', [TransactionsController::class, 'create']); // show new Transactions form
        Route::post('/create', [TransactionsController::class, 'store']); // save new Transactions
        Route::get('/edit/{slug}', [TransactionsController::class, 'edit']); // edit Transactions form
        Route::post('/update', [TransactionsController::class, 'update']); // update Transactions
        Route::get('/delete/{id}', [TransactionsController::class, 'destroy']); // delete Transactions
      });
    Route::group(['prefix' => 'maintenance-jobs', 'namespace' => 'MaintenanceJobs'],
    function ()
      {
        Route::get('/', [MaintenanceJobsController::class, 'index']); // show list of MaintenanceJobs
        Route::get('/create', [MaintenanceJobsController::class, 'create']); // show new MaintenanceJobs form
        Route::post('/create', [MaintenanceJobsController::class, 'store']); // save new MaintenanceJobs
        Route::get('/edit/{slug}', [MaintenanceJobsController::class, 'edit']); // edit MaintenanceJobs form
        Route::post('/update', [MaintenanceJobsController::class, 'update']); // update MaintenanceJobs
        Route::get('/delete/{id}', [MaintenanceJobsController::class, 'destroy']); // delete MaintenanceJobs
      });
    Route::group(['prefix' => 'reports', 'namespace' => 'Reports'],
    function ()
      {
        Route::get('/', [ReportsController::class, 'index']); // run Reports
        Route::get('/owners/{date_start?}/{date_end?}/{owner_id?}', [ReportsController::class, 'owners']); // run Reports
        Route::get('/housekeepers/{date_start?}/{date_end?}/{housekeeper_id?}', [ReportsController::class, 'housekeepers']); // run Reports
        Route::get('/vendors/{date_start?}/{date_end?}/{vendor_id?}', [ReportsController::class, 'vendors']); // run Reports
      });
    Route::group(['prefix' => 'properties', 'namespace' => 'Properties'],
    function ()
      {
        Route::get('/create', [AdminPropertiesController::class, 'create']); // show new Properties form
        Route::post('/create', [AdminPropertiesController::class, 'store']); // save new Properties
        Route::get('/edit/{slug}', [AdminPropertiesController::class, 'edit']); // edit Properties form
        Route::post('/update', [AdminPropertiesController::class, 'update']); // update Properties
        Route::get('/delete/{id}', [AdminPropertiesController::class, 'destroy']); // delete Properties
        Route::get('/{scope?}', [AdminPropertiesController::class, 'index']); // show list of Properties
      });
    Route::group(['prefix' => 'amenities', 'namespace' => 'Amenities'],
    function ()
      {
        Route::get('/', [AmenitiesController::class, 'index']); // show list of Amenities
        Route::get('/create', [AmenitiesController::class, 'create']); // show new Amenities form
        Route::post('/create', [AmenitiesController::class, 'store']); // save new Amenities
        Route::get('/edit/{slug}', [AmenitiesController::class, 'edit']); // edit Amenities form
        Route::post('/update', [AmenitiesController::class, 'update']); // update Amenities
        Route::get('/delete/{id}', [AmenitiesController::class, 'destroy']); // delete Amenities
      });
    Route::group(['prefix' => 'features', 'namespace' => 'Features'],
    function ()
      {
        Route::get('/', [FeaturesController::class, 'index']); // show list of Features
        Route::get('/create', [FeaturesController::class, 'create']); // show new Features form
        Route::post('/create', [FeaturesController::class, 'store']); // save new Features
        Route::get('/edit/{slug}', [FeaturesController::class, 'edit']); // edit Features form
        Route::post('/update', [FeaturesController::class, 'update']); // update Features
        Route::get('/delete/{id}', [FeaturesController::class, 'destroy']); // delete Features
      });    
    Route::group(['prefix' => 'services', 'namespace' => 'Services'],
    function ()
      {
        Route::get('/', [ServicesController::class, 'index']); // show list of Services
        Route::get('/create', [ServicesController::class, 'create']); // show new Services form
        Route::post('/create', [ServicesController::class, 'store']); // save new Services
        Route::get('/edit/{slug}', [ServicesController::class, 'edit']); // edit Services form
        Route::post('/update', [ServicesController::class, 'update']); // update Services
        Route::get('/delete/{id}', [ServicesController::class, 'destroy']); // delete Services
      });
    Route::group(['prefix' => 'line-items', 'namespace' => 'LineItems'],
    function ()
      {
        Route::get('/', [LineItemsController::class, 'index']); // show list of LineItems
        Route::get('/create', [LineItemsController::class, 'create']); // show new LineItems form
        Route::post('/create', [LineItemsController::class, 'store']); // save new LineItems
        Route::get('/edit/{slug}', [LineItemsController::class, 'edit']); // edit LineItems form
        Route::post('/update', [LineItemsController::class, 'update']); // update LineItems
        Route::get('/delete/{id}', [LineItemsController::class, 'destroy']); // delete LineItems
      });
    Route::group(['prefix' => 'seasons', 'namespace' => 'Seasons'],
    function ()
      {
        Route::get('/', [SeasonsController::class, 'index']); // show list of Seasons
        Route::get('/create', [SeasonsController::class, 'create']); // show new Seasons form
        Route::post('/create', [SeasonsController::class, 'store']); // save new Seasons
        Route::get('/edit/{slug}', [SeasonsController::class, 'edit']); // edit Seasons form
        Route::post('/update', [SeasonsController::class, 'update']); // update Seasons
        Route::get('/delete/{id}', [SeasonsController::class, 'destroy']); // delete Seasons
      });
    Route::group(['prefix' => 'property-types', 'namespace' => 'PropertyTypes'],
    function ()
      {
        Route::get('/', [PropertyTypesController::class, 'index']); // show list of PropertyTypes
        Route::get('/create', [PropertyTypesController::class, 'create']); // show new PropertyTypes form
        Route::post('/create', [PropertyTypesController::class, 'store']); // save new PropertyTypes
        Route::get('/edit/{slug}', [PropertyTypesController::class, 'edit']); // edit PropertyTypes form
        Route::post('/update', [PropertyTypesController::class, 'update']); // update PropertyTypes
        Route::get('/delete/{id}', [PropertyTypesController::class, 'destroy']); // delete PropertyTypes
      });
    Route::group(['prefix' => 'property-classes', 'namespace' => 'PropertyClasses'],
    function ()
      {
        Route::get('/', [PropertyClassesController::class, 'index']); // show list of PropertyClasses
        Route::get('/create', [PropertyClassesController::class, 'create']); // show new PropertyClasses form
        Route::post('/create', [PropertyClassesController::class, 'store']); // save new PropertyClasses
        Route::get('/edit/{slug}', [PropertyClassesController::class, 'edit']); // edit PropertyClasses form
        Route::post('/update', [PropertyClassesController::class, 'update']); // update PropertyClasses
        Route::get('/delete/{id}', [PropertyClassesController::class, 'destroy']); // delete PropertyClasses
      });
    Route::group(['prefix' => 'facilitators', 'namespace' => 'Facilitators'],
    function ()
      {
        Route::get('/', [FacilitatorsController::class, 'index']); // show list of Facilitators
        Route::get('/create', [FacilitatorsController::class, 'create']); // show new Facilitators form
        Route::post('/create', [FacilitatorsController::class, 'store']); // save new Facilitators
        Route::get('/edit/{slug}', [FacilitatorsController::class, 'edit']); // edit Facilitators form
        Route::post('/update', [FacilitatorsController::class, 'update']); // update Facilitators
        Route::get('/delete/{id}', [FacilitatorsController::class, 'destroy']); // delete Facilitators
      });
    Route::group(['prefix' => 'owners', 'namespace' => 'Owners'],
    function ()
      {
        Route::get('/', [OwnersController::class, 'index']); // show list of Owners
        Route::get('/create', [OwnersController::class, 'create']); // show new Owners form
        Route::post('/create', [OwnersController::class, 'store']); // save new Owners
        Route::get('/edit/{slug}', [OwnersController::class, 'edit']); // edit Owners form
        Route::post('/update', [OwnersController::class, 'update']); // update Owners
        Route::get('/delete/{id}', [OwnersController::class, 'destroy']); // delete Owners
      });
    Route::group(['prefix' => 'sliders', 'namespace' => 'Sliders'],
    function ()
      {
        Route::get('/', [SlidersController::class, 'index']); // show list of Sliders
        Route::get('/create', [SlidersController::class, 'create']); // show new Sliders form
        Route::post('/create', [SlidersController::class, 'store']); // save new Sliders
        Route::get('/edit/{slug}', [SlidersController::class, 'edit']); // edit Sliders form
        Route::post('/update', [SlidersController::class, 'update']); // update Sliders
        Route::get('/delete/{id}', [SlidersController::class, 'destroy']); // delete Sliders
      });
    Route::group(['prefix' => 'pages', 'namespace' => 'Pages'],
    function ()
      {
        Route::get('/index', [AdminPagesController::class, 'index']); // show list of Pages
        Route::get('/create/', [AdminPagesController::class, 'create']); // show new Page form
        Route::post('/create', [AdminPagesController::class, 'store']); // save new Page
        Route::get('/edit/{slug}', [AdminPagesController::class, 'edit']); // edit Page form
        Route::post('/update', [AdminPagesController::class, 'update']); // update Page
        Route::get('/delete/{id}', [AdminPagesController::class, 'destroy']); // delete Page
      });
    Route::group(['prefix' => 'news', 'namespace' => 'News'],
    function ()
      {
        Route::get('/', [NewsController::class, 'index']); // show list of News
        Route::get('/create', [NewsController::class, 'create']); // show new News form
        Route::post('/create', [NewsController::class, 'store']); // save new News
        Route::get('/edit/{slug}', [NewsController::class, 'edit']); // edit News form
        Route::post('/update', [NewsController::class, 'update']); // update News
        Route::get('/delete/{id}', [NewsController::class, 'destroy']); // delete News
      });
    Route::group(['prefix' => 'events', 'namespace' => 'Events'],
    function ()
      {
        Route::get('/', [EventsController::class, 'index']); // show list of Events
        Route::get('/create', [EventsController::class, 'create']); // show new Event form
        Route::post('/create', [EventsController::class, 'store']); // save new Event
        Route::get('/edit/{slug}', [EventsController::class, 'edit']); // edit Event form
        Route::post('/update', [EventsController::class, 'update']); // update Event
        Route::get('/delete/{id}', [EventsController::class, 'destroy']); // delete Event
      });
    Route::group(['prefix' => 'email-templates', 'namespace' => 'EmailTemplates'],
    function ()
      {
        Route::get('/', [EmailTemplatesController::class, 'index']); // show list of EmailTemplates
        Route::get('/edit/{slug}', [EmailTemplatesController::class, 'edit']); // edit EmailTemplates form
        Route::post('/update', [EmailTemplatesController::class, 'update']); // update EmailTemplates
        Route::get('/delete/{id}', [EmailTemplatesController::class, 'destroy']); // delete EmailTemplates
      });
    Route::group(['prefix' => 'users', 'namespace' => 'Users'],
    function ()
      {
        Route::get('/', [UserController::class, 'edit']); // show list of Users
        Route::post('/update', [UserController::class, 'update']); // update Users
      });
    Route::group(['prefix' => 'settings', 'namespace' => 'Settings'],
    function ()
      {
        Route::get('/', [SettingsController::class, 'edit']); // show form for Settings
        Route::post('/update', [SettingsController::class, 'update']); // update Settings
      });
    Route::group(['prefix' => 'navigation', 'namespace' => 'Navigation'],
    function ()
      {
        Route::get('/{group_name?}', [NavigationController::class, 'index']); // show list of Navigation
        Route::get('/create/{group_name?}', [NavigationController::class, 'create']); // show new Navigation form
        Route::post('/create', [NavigationController::class, 'store']); // save new Navigation
        Route::get('/edit/{slug}', [NavigationController::class, 'edit']); // edit Navigation form
        Route::post('/update', [NavigationController::class, 'update']); // update Navigation
        Route::post('/updatenavigationstatus', [NavigationController::class], 'updatenavigationstatus'); // update Navigation
        Route::post('/updatenavigationnesting', [NavigationController::class, 'updatenavigationnesting']); // update Navigation
        Route::get('/delete/{id}', [NavigationController::class, 'destroy']); // delete Navigation
      });
    Route::group(['prefix' => 'locations', 'namespace' => 'Locations'],
    function ()
      {
        Route::get('/', [LocationsController::class, 'index']); // show list of Locations
        Route::get('/create', [LocationsController::class, 'create']); // show new Locations form
        Route::post('/create', [LocationsController::class, 'store']); // save new Locations
        Route::get('/edit/{slug}', [LocationsController::class, 'edit']); // edit Locations form
        Route::post('/update', [LocationsController::class, 'update']); // update Locations
        Route::get('/delete/{id}', [LocationsController::class, 'destroy']); // delete Locations
      });
  });
// End of admin area
// Owner area


Route::get('owner',
function ()
  { //Redirect the admin default page to dashboard.
    return redirect('/owner/dashboard');
  });
Route::group(['prefix' => 'owner', 'namespace' => 'Owner', 'middleware' => ['auth', 'owner']],
function ()
  {
    Route::get('/dashboard', [OwnerController::class, 'dashboard']); // Dashboard

    Route::group(['prefix' => 'reservations', 'namespace' => 'Reservations'],
    function ()
      {
        Route::get('/', [AdminReservationsController::class, 'index']); // show list of Reservations
        Route::get('/search/{date_start?}/{date_end?}', [AdminReservationsController::class, 'search']); // show new Reservations form
        Route::get('/create/{property?}/{date_start?}/{date_end?}', [AdminReservationsController::class, 'create']); // save new Reservations
        Route::post('/store/{slug}', [AdminReservationsController::class, 'store']); // save new Reservations
        Route::get('/show/{id}', [AdminReservationsController::class, 'show']); // show list of Reservations
        Route::post('/approve', [AdminReservationsController::class, 'approve']); // approve Reservations
        Route::get('/edit/{slug}', [AdminReservationsController::class, 'edit']); // edit Reservations form
        Route::post('/update', [AdminReservationsController::class, 'update']); // update Reservations
        Route::get('/delete/{id}', [AdminReservationsController::class, 'destroy']); // delete Reservations
      });
    Route::get('/calendar-view/{year?}/{month?}', [AdminReservationsController::class, 'calendarView']); //Shows all reservations in a month
    Route::group(['prefix' => 'transactions', 'namespace' => 'Transactions'],
    function ()
      {
        Route::get('/', [TransactionsController::class, 'index']); // show list of Transactions
        Route::get('/create', [TransactionsController::class, 'create']); // show new Transactions form
        Route::post('/create', [TransactionsController::class, 'store']); // save new Transactions
        Route::get('/edit/{slug}', [TransactionsController::class, 'edit']); // edit Transactions form
        Route::post('/update', [TransactionsController::class, 'update']); // update Transactions
        Route::get('/delete/{id}', [TransactionsController::class, 'destroy']); // delete Transactions
      });

    Route::group(['prefix' => 'reports', 'namespace' => 'Reports'],
    function ()
      {
        Route::get('/', [ReportsController::class, 'index']); // run Reports
        Route::get('/owners/{date_start?}/{date_end?}/{owner_id?}', [ReportsController::class, 'owners']); // run Reports
        Route::get('/housekeepers/{date_start?}/{date_end?}/{housekeeper_id?}', [ReportsController::class, 'housekeepers']); // run Reports
        Route::get('/vendors/{date_start?}/{date_end?}/{vendor_id?}', [ReportsController::class, 'vendors']); // run Reports
      });
    Route::group(['prefix' => 'properties', 'namespace' => 'Properties'],
    function ()
      {
        Route::get('/create', [PropertiesController::class, 'create']); // show new Properties form
        Route::post('/create', [PropertiesController::class, 'store']); // save new Properties
        Route::get('/edit/{slug}', [PropertiesController::class, 'edit']); // edit Properties form
        Route::post('/update', [PropertiesController::class, 'update']); // update Properties
        Route::get('/delete/{id}', [PropertiesController::class, 'destroy']); // delete Properties
        Route::get('/{scope?}', [PropertiesController::class, 'index']); // show list of Properties
      });


    Route::group(['prefix' => 'users', 'namespace' => 'Users'],
    function ()
      {
        Route::get('/', [UserController::class, 'edit']); // show list of Users
        Route::post('/update', [UserController::class, 'update']); // update Users
      });
    Route::group(['prefix' => 'settings', 'namespace' => 'Settings'],
    function ()
      {
        Route::get('/', [SettingsController::class, 'edit']); // show form for Settings
        Route::post('/update', [SettingsController::class, 'update']); // update Settings
      });
    Route::group(['prefix' => 'navigation', 'namespace' => 'Navigation'],
    function ()
      {
        Route::get('/{group_name?}', [NavigationController::class, 'index']); // show list of Navigation
        Route::get('/create/{group_name?}', [NavigationController::class, 'create']); // show new Navigation form
        Route::post('/create', [NavigationController::class, 'store']); // save new Navigation
        Route::get('/edit/{slug}', [NavigationController::class, 'edit']); // edit Navigation form
        Route::post('/update', [NavigationController::class, 'update']); // update Navigation
        Route::post('/updatenavigationstatus', [NavigationController::class, 'updatenavigationstatus']); // update Navigation
        Route::post('/updatenavigationnesting', [NavigationController::class, 'updatenavigationnesting']); // update Navigation
        Route::get('/delete/{id}', [NavigationController::class, 'destroy']); // delete Navigation
      });
    
  });

// End of owner area


//FRONTEND
Route::get('/',[PagesController::class, 'home'])->name('home'); 
Route::get('/home',[PagesController::class, 'home'])->name('home'); 
Route::get('/home/{version?}',[PagesController::class, 'homeVersion'])->name('home'); 
Route::get('/welcome',[PagesController::class, 'home'])->name('welcome'); 


// AJAX
Route::get('/select-dates/{property}/{year?}/{month?}/{pre_select_date_start?}/{pre_select_date_end?}/{reservation_id?}',[SelectDatesController::class, 'selectDates']); 
Route::get('/booking-availability-message/{property}/{date1}/{date2}/{reservation_id?}',[SelectDatesController::class, 'bookingAvailabilityMessage']); 
Route::get('/calculate-lodging-price/{property}/{date1}/{date2}/{reservation_id?}/{add_days?}',[SelectDatesController::class, 'calculateLodgingPrice']); 
Route::get('/save-dates-searched-to-session/{date1}/{date2}',[SelectDatesController::class, 'saveDatesSearchedToSession']); 

Route::get('/cropper/{width?}/{height?}',[CommonFunctionsController::class, 'cropper']); 

Route::get('/load-cropper-object/{db_id}/{deletable}/{number?}/{width}/{height}/{preview_image?}/{tmp_img_path?}',
function ($number = '1', $deletable = 'Y', $db_id = 'NA', $width = '800', $height = '600', $preview_image = 'NA', $tmp_img_path = 'NA')
  {
    $preview_image = str_replace('/', '|', $preview_image);
    $tmp_img_path = str_replace('/', '|', $tmp_img_path);
    return view('admin.layouts.objects.cropper')->with('number', $number)
    ->with('deletable', $deletable)->with('db_id', $db_id)
    ->with('width', $width)->with('height', $height)
    ->with('preview_image', $preview_image)->with('tmp_img_path', $tmp_img_path);
  });

// End of AJAX

Route::get('sale/search/redirect', [PropertiesController::class, 'saleSearchRedirect']);
Route::get('sale/search/{type}/{location}/{sleeps}', [PropertiesController::class, 'saleSearch']);

//Search properties for booking by dates.
Route::get('rental/search/redirect', [PropertiesController::class, 'rentalSearchRedirect']);
Route::get('rental/search/{type}/{date_start}/{date_end}/{sleeps}', [PropertiesController::class, 'rentalSearch']);
//Categories of properties
Route::get('/types', [PropertiesController::class, 'types']);
//List of properties under a specific category
Route::get('type/{slug}', [PropertiesController::class, 'indexByType'])->where('slug', '[A-Za-z0-9-_]+');
//Shows detail of a single property
Route::get('show/{slug}', [PropertiesController::class, 'show'])->where('slug', '[A-Za-z0-9-_]+');
Route::get('sale/{slug}', [PropertiesController::class, 'showSale'])->where('slug', '[A-Za-z0-9-_]+');
Route::get('reserve/{slug}', [PropertiesController::class, 'showReserve'])->where('slug', '[A-Za-z0-9-_]+');

//Send a Buying offer
Route::get('send-buying-offer/{slug}/redirect', [AdminReservationsController::class, 'saveBuyingOffer']);
//Reserve a property Step-1
Route::get('reserve/{slug}/redirect', [AdminReservationsController::class, 'createRedirect']);
Route::get('reserve/{slug}/{date_start}/{date_end}', [AdminReservationsController::class, 'create']);
//Reserve a property Step-2
Route::post('reserve/{slug}/{date_start}/{date_end}/store', [AdminReservationsController::class, 'store']);
//Shows booking total and checkout.
Route::get('reservation/{uniqid}/payment', [AdminReservationsController::class, 'payment']);
//Submits the checkout and creates record of payment transaction
Route::post('reservation/{uniqid}/payment', [TransactionsController::class, 'update']);
//Success message of reservation and payment.
Route::get('reservation/{uniqid}/payment/success', [AdminReservationsController::class, 'success']);


//Website's contact page
Route::get('/contact',[PagesController::class, 'contact'])->name('contact'); 
Route::get('/posts',[PagesController::class, 'posts'])->name('posts'); 

// //Shows single page of Website contents
Route::get('/{category}/{page}',[PagesController::class, 'show'])->name('category.page'); 
Route::get('/{category}',[PagesController::class, 'category'])->name('category'); 

            // Route::get('/contact', [PagesController@contact']);
            // Route::get('/posts', [PagesController@posts'])->where('page', '[A-Za-z0-9-_]+');

            // //Shows single page of Website contents
            // Route::get('/{category}/{page}', [PagesController@show'])->where('page', '[A-Za-z0-9-_]+');
            // //Shows list of pages of a specific category of website contents
            // Route::get('/{category}', [PagesController@category'])->where('page', '[A-Za-z0-9-_]+');

//End of routes

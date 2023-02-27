<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\PropertiesController;
use App\Http\Controllers\Admin\Amenities;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
Route::get('send-buying-offer/{slug}/redirect', [ReservationsController::class, 'saveBuyingOffer']);
//Reserve a property Step-1
Route::get('reserve/{slug}/redirect', [ReservationsController::class, 'createRedirect']);
Route::get('reserve/{slug}/{date_start}/{date_end}', [ReservationsController::class, 'create']);
//Reserve a property Step-2
Route::post('reserve/{slug}/{date_start}/{date_end}/store', [ReservationsController::class, 'store']);
//Shows booking total and checkout.
Route::get('reservation/{uniqid}/payment', [ReservationsController::class, 'payment']);
//Submits the checkout and creates record of payment transaction
Route::post('reservation/{uniqid}/payment', [TransactionsController::class, 'update']);
//Success message of reservation and payment.
Route::get('reservation/{uniqid}/payment/success', [ReservationsController::class, 'success']);


//Website's contact page
Route::get('/contact',[PagesController::class, 'contact'])->name('contact'); 
Route::get('/posts',[PagesController::class, 'posts'])->name('posts'); 

// //Shows single page of Website contents
Route::get('/{category}/{page}',[PagesController::class, 'show'])->name('category.page'); 
Route::get('/{category}',[PagesController::class, 'category'])->name('category'); 

            // Route::get('/contact', ['uses' => 'PagesController@contact']);
            // Route::get('/posts', ['uses' => 'PagesController@posts'])->where('page', '[A-Za-z0-9-_]+');

            // //Shows single page of Website contents
            // Route::get('/{category}/{page}', ['uses' => 'PagesController@show'])->where('page', '[A-Za-z0-9-_]+');
            // //Shows list of pages of a specific category of website contents
            // Route::get('/{category}', ['uses' => 'PagesController@category'])->where('page', '[A-Za-z0-9-_]+');

//End of routes

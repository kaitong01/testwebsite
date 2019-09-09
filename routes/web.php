<?php

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
// use App\Http\Controllers\CompanyController;
// use App\Http\Middleware\CheckCompany;

use Illuminate\Http\Request;
use App\Library\Fn;

Auth::routes([
    'register' => false,
    'verify' => true,
    'reset' => false
]);

// Route::get('/home', 'HomeController@index')->name('pages.home');

Route::group(['middleware' => ['auth', 'company']], function () {

    # Home
    Route::get('/', function () {
        return redirect('/products');
    });

    # Booking
    Route::resource('/booking', 'BookingController');


    # Products
    Route::get('/products/create', 'ProductsController@create');
    Route::get('/products/{param?}', 'ProductsController@index');

    Route::get('/products/show/{param?}', 'ProductsController@set_data');

    # tours -> series
    Route::resource('/tours/series', 'ToursSeriesController');
    // ->only(['store', 'update', 'destroy']);


    # Business
    Route::get('/business', 'BusinessController@index');
    Route::get('/business/{param}', 'BusinessController@index');

    Route::put('/business/update/{param}', 'BusinessController@update');


    # Store
    Route::get('/store', 'StoreController@index');
    Route::get('/store/find', 'StoreController@find');
    Route::get('/store/tours/{id}', 'StoreController@detail');



    Route::get('/store/wholesale/find', 'StoreController@find');
    Route::get('/store/wholesale/{id}', 'StoreController@find');
    // Route::get('/store/wholesale/{id}/country', 'StoreController@wholesaleCountry');
    Route::get('/store/wholesale/{id}/country/{country_id}', 'StoreController@find');
      Route::get('/store/addtocart', 'StoreController@addtoCart')->name('addtocart.store');


    // Route::get('/store/sele/', 'StoreController@index');

    # cart
    Route::get('/cart', 'CartController@index');
    Route::get('/cart/{param}', 'CartController@index');
    Route::get('/cart/datatable/{param}', 'CartController@datatable');
    Route::get('/cart/status/{param}/published', 'CartController@published');





    # Settings
    Route::get('/settings', function () {

        return view('pages.settings');
    })->name('pages.settings');

    // /settings/tours/
    Route::get('/settings/tours/{param?}', 'SettingsToursController@index')->name('pages.settings.tours');


    // /settings/blogs/
    Route::get('/settings/blogs/{param?}', 'SettingsBlogsController@index')->name('pages.settings.blogs');



    // Route::get('/blogs/category', 'BlogsCategoryController@index');
    // Route::get('/blogs/category/create', 'BlogsCategoryController@create');
    // Route::post('/blogs/category', 'BlogsCategoryController@store');
    // Route::get('/blogs/category/{id}/edit', 'BlogsCategoryController@edit');
    // Route::put('/blogs/category/{id}', 'BlogsCategoryController@update');
    // Route::delete('/blogs/category/{id}', 'BlogsCategoryController@destroy');
    # Settings
    Route::get('/blogs', function () {

        return view('pages.blogs');
    })->name('pages.blogs');

    //blogs
    Route::get('/blogs/post/{param?}', 'BlogsPostController@index')->name('pages.blogs.post');
    Route::resource('/blogs/add', 'BlogsAddController');
    Route::get('/blogs/add/{id}/delete', 'BlogsAddController@delete');


    Route::resource('/blogs/category', 'BlogsCategoryController');
    Route::get('/blogs/category/{id}/delete', 'BlogsCategoryController@delete');


    Route::resource('/tours/route', 'ToursRouteController');
    Route::get('/tours/route/{id}/delete', 'ToursRouteController@delete');

    Route::get('install/country','SetupDbController@install_country');
    // Route::get('install/con','SetupDbController@install_con');

    Route::resource('/tours/country', 'TourCountryController');

    Route::resource('/tours/wholesale', 'TourWholesaleController');

    Route::resource('/tours/category', 'TourCategoryController');
    Route::get('/tours/category/{id}/delete', 'TourCategoryController@delete');

    # update back-end
    Route::post('/account/change_company', 'AccountController@changeCompany');
    Route::get('/createPrimaryLink', function ( Request $request ) {
        $Fn = new Fn;

        return response([
            'code' => 200,
            'message' => 'Ok',
            'data' => $Fn->q('text')->createPrimaryLink( $request->text )
        ]);
    });
    // Route::get('/site/menu', 'SiteController@menu');
    Route::get('/site', function () {
        return view('errors.404');
    });
    Route::post('/site', 'SiteController@store');
});

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
use App\Http\Controllers\CompanyController;
use App\Http\Middleware\CheckCompany;

use Illuminate\Http\Request;
use App\Library\Fn;

Auth::routes([
    'register' => false,
    'verify' => true,
    'reset' => false
]);

// Route::get('/home', 'HomeController@index')->name('pages.home');

Route::group(['middleware' => ['auth', 'company']], function () {


    Route::get('/', function () {

        return view('pages.home');

    })->name('pages.home');

    Route::get('/site/menu', 'SiteController@menu');
    Route::post('/site/menu', 'SiteController@menu');

    Route::get('/home', function () {

        return view('pages.home');

    })->name('pages.home');

    Route::get('/about', function () {

        return view('pages.about');
    })->name('pages.about');


    Route::get('/settings', function () {

        return view('pages.settings');
    })->name('pages.settings');




    // /settings/tours/
    Route::get('/settings/tours/{param?}', 'SettingsToursController@index')->name('pages.settings.tours');

    // /settings/blogs/
    Route::get('/settings/blogs/{param?}', 'SettingsBlogsController@index')->name('pages.settings.blogs');



    Route::get('/blogs/category', 'BlogsCategoryController@index');
    Route::get('/blogs/category/add', 'BlogsCategoryController@add');



    Route::get('/createPrimaryLink', function ( Request $request ) {

        $Fn = new Fn;
        // return response('Hello World', 200)
        //           ->header('Content-Type', 'text/plain');

        return response([
            'code' => 200,
            'message' => 'Ok',
            'data' => $Fn->q('text')->createPrimaryLink( $request->value )
        ]);
    });






    // Route::get('/settings/tours/country', function () {

    //     return view('pages.settings');
    // })->name('pages.settings');

    // Route::get('/settings/tours/wholesale', function () {

    //     return view('pages.settings');
    // })->name('pages.settings');

    // Route::get('/settings/tours/category', function () {
    //     return view('pages.settings');
    // })->name('pages.settings');

    
    


    // CompanyController::check( Auth::user()->company_id, 'pages.settings' );

    // Route::get('/company', 'CompanyController@index')->name('pages.company');
    // Route::get('/wholesale', 'ProductController@index')->name('pages.wholesale');

});

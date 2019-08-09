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

Auth::routes([
    'register' => false,
    'verify' => true,
    'reset' => false
]);

// Route::get('/home', 'HomeController@index')->name('pages.home');

Route::group(['middleware' => ['auth']], function () {

    Route::get('/', function () {
        return view('pages.home');
    })->name('pages.home');

    Route::get('/home', function () {
        return view('pages.home');
    })->name('pages.home');

    Route::get('/about', function () {
        return view('pages.about');
    })->name('pages.about');

    // Route::get('/company', 'CompanyController@index')->name('pages.company');
    // Route::get('/wholesale', 'ProductController@index')->name('pages.wholesale');

});

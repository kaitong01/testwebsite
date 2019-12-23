<?php

use Illuminate\Http\Request;
use App\Library\Fn;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes([
    'register' => false,
    'verify' => true,
    'reset' => false
]);

// Route::get('/home', 'HomeController@index')->name('pages.home');

Route::group(['middleware' => ['auth', 'user.role']], function () {


    # Home
    Route::get('/', function (Request $request) {
        return redirect('/products');
    });


    # Settings
    Route::get('/settings', function () {
        return redirect('/settings/tours/countries');
    });

    ## Settings: set routes : /settings/tours
    Route::prefix('/settings/tours')->group(function () {
        Route::get('/countries', 'SettingTourController@index');
        Route::get('/routes', 'SettingTourController@index');
        Route::get('/wholesales', 'SettingTourController@index');
        Route::get('/categories', 'SettingTourController@index');
    });

    ### Settings: tours -> countries
    Route::resource('/tours/countries', 'TourCountryController')->only([
        'index', 'edit', 'store'
    ]);
    Route::post('/tours/countries/switch', 'TourCountryController@switch');
    Route::get('/tours/countries/{param}', function ()
    {
        return abort(404);
    });


    ### Settings: tours -> Routes
    Route::resource('/tours/routes', 'TourRouteController')->only([
        'index', 'create', 'store', 'edit', 'update'
    ]);
    Route::post('/tours/routes/switch', 'TourRouteController@switch');
    Route::get('/tours/routes/{param}', function ()
    {
        return abort(404);
    });


    ### Settings: tours -> Category
    Route::resource('/tours/categories', 'TourCategoryController')->only([
        'index', 'create','store', 'edit', 'update'
    ]);
    Route::post('/tours/categories/switch', 'TourCategoryController@switch');
    Route::get('/tours/categories/{param}', function ()
    {
        return abort(404);
    });


    ### Settings: tours -> Wholesales
    Route::resource('/tours/wholesales', 'TourWholesaleController')->only([
        'index'
    ]);
    Route::post('/tours/wholesales/switch', 'TourWholesaleController@switch');
    Route::get('/tours/wholesales/{param}', function ()
    {
        return abort(404);
    });


    ## Settings: set routes : /settings/blogs
    Route::prefix('/settings/blogs')->group(function () {
        Route::get('/categories', 'SettingBlogController@index');
    });

    ### Settings: blogs -> categories
    Route::resource('/blogs/categories', 'blogCategoryController')->only([
        'index', 'create', 'edit', 'store', 'update'
    ]);
    Route::post('/blogs/categories/switch', 'blogCategoryController@switch');
    Route::get('/blogs/categories/{param}', function ()
    {
        return abort(404);
    });



    // --------------------------------------------------------------------------------
    # Business
    Route::get('/business', 'BusinessController@index');
    Route::get('/business/{param}', 'BusinessController@index');
    Route::put('/business/update/{param}', 'BusinessController@update');



    // --------------------------------------------------------------------------------
    # site
    Route::get('/site', 'SiteController@index');
    Route::get('/site/{param}', 'SiteController@index');

    ### site: Menus
    Route::resource('/site/menu', 'SiteMenuController')->only([
        'index', 'create', 'store', 'edit' , 'update'
    ]);
    Route::post('/site/menu/sort', 'SiteMenuController@sort');
    Route::get('/site/menu/{param}', function ()
    {
        return abort(404);
    });

    ### site: Font
    Route::resource('/site/fonts', 'SiteFontController')->only([
        'store'
    ]);
    Route::get('/site/fonts/{param}', function ()
    {
        return abort(404);
    });

    ### site: slides
    Route::resource('/site/slides', 'SiteSlideController')->only([
        'store'
    ]);
    Route::get('/site/slides/{param}', function ()
    {
        return abort(404);
    });

    ### site: banners
    Route::resource('/site/banners', 'SiteBannerController')->only([
        'store'
    ]);
    Route::get('/site/banners/{param}', function ()
    {
        return abort(404);
    });




    // --------------------------------------------------------------------------------
    # products
    Route::get('/products', function () {
        return redirect('/products/publish');
    });

    ## products: set routes
    Route::prefix('/products')->group(function () {
        Route::get('/publish', 'ProductController@index');
        Route::get('/draft', 'ProductController@index');
        Route::get('/disable', 'ProductController@index');


        Route::get('/yourself', 'ProductController@index');
        Route::get('/wholesale', 'ProductController@index');
    });

    Route::resource('/tours/series', 'TourSerieController')->only([
        'index', 'store', 'create', 'edit', 'update'
    ]);
    Route::post('/tours/series/switch', 'TourSerieController@switch');
    Route::get('/tours/series/{param}', function ()
    {
        return abort(404);
    });



    // --------------------------------------------------------------------------------
    # store
    Route::get('/store', function () {
        return redirect('/store/tours');
    });
    ## store: set routes
    Route::prefix('/store/tours')->group(function () {
        Route::get('/', 'StoreTourController@index');
        Route::get('/new', 'StoreTourController@index');
        Route::get('/upcoming', 'StoreTourController@index');
        Route::get('/discount', 'StoreTourController@index');
        Route::get('/popular', 'StoreTourController@index');
        Route::get('/selected', 'StoreTourController@index');

    });


    // --------------------------------------------------------------------------------
    # cart
    Route::resource('/carts', 'CartController')->only([
        'index', 'edit', 'update', 'destroy'
    ]);

    Route::get('/carts/find', 'CartController@find');
    Route::get('/carts/find/{param}', 'CartController@find');

    Route::prefix('/carts')->group(function () {
        Route::get('/', 'CartController@index');
        Route::get('/confirm', 'CartController@index');
        Route::get('/verify', 'CartController@index');
        Route::get('/cancel', 'CartController@index');

    });

    Route::post('/carts/switch', 'CartController@switch');
    Route::get('/carts/{param}/delete', 'CartController@delete');

    Route::get('/carts/{param}', function ()
    {
        return abort(404);
    });

     // --------------------------------------------------------------------------------
    # blogs
    Route::resource('/blogs', 'BlogController')->only([
        'index', 'edit', 'update', 'destroy'
    ]);

    Route::get('/blogs/find', 'BlogController@find');
    Route::get('/blogs/find/{param}', 'BlogController@find');

    Route::prefix('/blogs')->group(function () {
        Route::get('/', 'BlogController@index');
        Route::get('/confirm', 'BlogController@index');
        Route::get('/verify', 'BlogController@index');
        Route::get('/cancel', 'BlogController@index');

    });

    Route::post('/blogs/switch', 'BlogController@switch');
    Route::get('/blogs/{param}/delete', 'BlogController@delete');

    Route::get('/blogs/{param}', function ()
    {
        return abort(404);
    });


    // --------------------------------------------------------------------------------
    # datacenter
    Route::get('/datacenter/series/{param}', 'DatacenterController@series');


    // --------------------------------------------------------------------------------
    # update back-end
    Route::get('/companies', 'CompanyController@index');

    ## check Permalink
    Route::get('/createPrimaryLink', function ( Request $request ) {
        $Fn = new Fn;

        return response([
            'code' => 200,
            'message' => 'Ok',
            'data' => $Fn->q('text')->createPrimaryLink( $request->text )
        ]);
    });

    ## switch menu
    Route::get('/switch/menu', function (Request $request)
    {

        session(['show_menu' =>$request->status]);
        return response(['code'=>200], 200);
    });

    ## switch company
    Route::get('/switch/company', function (Request $request)
    {
        session(['cid' =>$request->id]);
        // $request->session()->pull('cid', $request->id);

        return response(['code'=>200], 200);
    });


});

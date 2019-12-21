<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TourSerie;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Route;

class ProductController extends Controller
{
    public function index()
    {
        $tab = basename(Route::getFacadeRoot()->current()->uri);

        $tabs = [
            'publish'   => ['status'=>1],
            'draft'     => ['status'=>2],
            'disable'   => ['status'=>0],
            'yourself'  => ['status'=>'', 'state'=>1],
            'wholesale' => ['status'=>'', 'state'=>2],
        ];


        if( in_array($tab, array_keys($tabs)) ){
            return view('pages.product.index')->with( TourSerie::_init( $tabs[$tab] ) );
        }
        else{
            throw new AuthorizationException('You do not have permission to view this page');
        }
    }

}

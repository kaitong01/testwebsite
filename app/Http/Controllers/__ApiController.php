<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;


class ApiController extends Controller
{
    public function   get_countries()
    {
      $data = DB::table('countries')->get();
      echo json_encode($data);
    }
    public function   get_airline()
    {
      $data = DB::table('airline')->get();
      echo json_encode($data);
    }
    public function   get_tourroute()
    {

      $data = DB::table('tour_route')->where('cid',Session::get('cid'))->get();
      
      echo json_encode($data);
    }


}

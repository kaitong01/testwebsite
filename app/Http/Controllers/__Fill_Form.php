<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Wholesale;
use App\Models\ToursSeries;
use App\Models\ToursPeriod;
use App\Models\TourWholesale;
use App\Models\TourCountry;
use App\Models\ToursRoute;
use App\Models\TourCategory;

class Fill_Form extends Controller
{
  public static function wholesale_packages($cid){
    $filters ="";
    $db_wholesales = TourWholesale::select('wholesale')
    ->where('cid','=',$cid)
    ->first();
    $arr = json_decode($db_wholesales->wholesale);
    $db_wholesales = DB::table('wholesales')
    ->select('name','id')
    ->whereIn('id',$arr)
    ->get();
    if(count($db_wholesales)>0){
      $output = '';

      foreach ($db_wholesales as $row) {
          $output .= '<div class="dropdown-item">
          <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" name="wholesales[]" value="'.$row->id.'">
                    <label class="form-check-label">'.$row->name.'</label>
                    </div>
          </div>';
      }
    }else{
          $output = '<a class="dropdown-item" href="#">ไม่พบข้อมูล</a>';
    }
    $filters .='<div class="dropdown" style="margin:10px;">
      <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        โฮลเซลล์
      </button>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          '.$output.'
        </div>
      </div>';
    return   $filters;

  }

  public static function country_packages($cid){
    $filters ="";
    $db = TourCountry::select('country')
    ->where('cid','=',$cid)
    ->first();
    $arr = json_decode($db->country);
    $db = DB::table('country_route')
    ->select('name','id')
    ->whereIn('id',$arr)
    ->get();
    if(count($db)>0){
      $output = '';

      foreach ($db as $row) {
          $output .= '<div class="dropdown-item">
          <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" name="country[]" value="'.$row->id.'">
                    <label class="form-check-label">'.$row->name.'</label>
                    </div>
          </div>';
      }
    }else{
          $output = '<a class="dropdown-item" href="#">ไม่พบข้อมูล</a>';
    }
    $filters .='<div class="dropdown" style="margin:10px;">
      <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        ประเทศ
      </button>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          '.$output.'
        </div>
      </div>';
    return   $filters;

  }

  public static function route_packages($cid){
    $filters ="";
    $db = ToursRoute::where('cid','=',$cid)
    ->get();
    if(count($db)>0){
      $output = '';

      foreach ($db as $row) {
          $output .= '<div class="dropdown-item">
          <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" name="route[]" value="'.$row->id.'">
                    <label class="form-check-label">'.$row->name.'</label>
                    </div>
          </div>';
      }
    }else{
          $output = '<a class="dropdown-item" href="#">ไม่พบข้อมูล</a>';
    }
    $filters .='<div class="dropdown" style="margin:10px;">
      <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        เส้นทาง
      </button>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          '.$output.'
        </div>
      </div>';
    return   $filters;

  }

  public static function category_packages($cid){
    $filters ="";
    $db = TourCategory::where('cid','=',$cid)
    ->get();
    if(count($db)>0){
      $output = '';

      foreach ($db as $row) {
          $output .= '<div class="dropdown-item">
          <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" name="category[]" value="'.$row->id.'" data-action="checkited">
                    <label class="form-check-label">'.$row->name.'</label>
                    </div>
          </div>';
      }
    }else{
          $output = '<a class="dropdown-item" href="#">ไม่พบข้อมูล</a>';
    }
    $filters .='<div class="dropdown" style="margin:10px;">
      <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        ประเภททัวร์
      </button>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          '.$output.'
        </div>
      </div>';
    return   $filters;

  }

  public static function period(){

          $output = '<div class="dropdown-item" style="width:250px;">
                  <input name="date" class="form-control" type="text" data-plugin="flatpickr" data-options="'.htmlentities(json_encode(["dateFormat"=> "d/m/Y","mode"=> "range"])).'">
          </div>';


    $filters ='<div class="dropdown" style="margin:10px;">
      <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        พีเรียดเดินทาง
      </button>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          '.$output.'
        </div>
      </div>';
    return   $filters;

  }

}

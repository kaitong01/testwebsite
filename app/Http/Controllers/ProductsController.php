<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use App\Models\Wholesale;
use App\Models\ToursSeries;
use App\Models\ToursPeriod;

class ProductsController extends Controller
{
    public function index($tab='publish')
    {
        $filters = '';

        // $filters .= '<div class="filter-item"><label class="filter-item-label" for="status">โฮลเซลล์:</label><select class="filter-item-input form-control" id="status" name="status" data-action="change">'.
        //     '<option value="">ทั้งหมด</option>'.
        //     '<option value="0">แบบร่าง</option>'.
        //     '<option value="1">ใช้งาน</option>'.
        //     '<option value="2">ระงับ</option>'.
        // '</select></div>';

        // $filters .= '<div class="filter-item"><label class="filter-item-label" for="status">ประเทศ:</label><select class="filter-item-input form-control" id="status" name="status" data-action="change">'.
        //     '<option value="">ทั้งหมด</option>'.
        //     '<option value="0">แบบร่าง</option>'.
        //     '<option value="1">ใช้งาน</option>'.
        //     '<option value="2">ระงับ</option>'.
        // '</select></div>';

        // $filters .= '<div class="filter-item"><label class="filter-item-label" for="status">เส้นทาง:</label><select class="filter-item-input form-control" id="status" name="status" data-action="change">'.
        //     '<option value="">ทั้งหมด</option>'.
        //     '<option value="0">แบบร่าง</option>'.
        //     '<option value="1">ใช้งาน</option>'.
        //     '<option value="2">ระงับ</option>'.
        // '</select></div>';

        // $filters .= '<div class="filter-item"><label class="filter-item-label" for="status">ประเภททัวร์:</label><select class="filter-item-input form-control" id="status" name="status" data-action="change">'.
        //     '<option value="">ทั้งหมด</option>'.
        //     '<option value="0">แบบร่าง</option>'.
        //     '<option value="1">ใช้งาน</option>'.
        //     '<option value="2">ระงับ</option>'.
        // '</select></div>';

        // $filters .= '<div class="filter-item"><label class="filter-item-label" for="status">พีเรียดเดินทาง:</label><select class="filter-item-input form-control" id="status" name="status" data-action="change">'.
        //     '<option value="">ทั้งหมด</option>'.
        //     '<option value="0">แบบร่าง</option>'.
        //     '<option value="1">ใช้งาน</option>'.
        //     '<option value="2">ระงับ</option>'.
        // '</select></div>';

        $filters .= '<div class="filter-item search textbox-wrap">
            <input type="text" class="filter-item-input form-control form-textbox form-icon-left" id="search-input" autocomplete="off" role="combobox" name="q" value="" required="" data-action="search">
            <svg class="textbox-icon" viewBox="0 0 52.966 52.966" xmlns="http://www.w3.org/2000/svg"><path d="m51.704 51.273-14.859-15.453c3.79-3.801 6.138-9.041 6.138-14.82 0-11.58-9.42-21-21-21s-21 9.42-21 21 9.42 21 21 21c5.083 0 9.748-1.817 13.384-4.832l14.895 15.491c0.196 0.205 0.458 0.307 0.721 0.307 0.25 0 0.499-0.093 0.693-0.279 0.398-0.383 0.41-1.016 0.028-1.414zm-29.721-11.273c-10.477 0-19-8.523-19-19s8.523-19 19-19 19 8.523 19 19-8.524 19-19 19z"></path></svg>
            <button class="textbox-clear" type="button"><svg width="19" height="19" viewBox="0 0 19 19" xmlns="http://www.w3.org/2000/svg"><path d="M18.253,5.8A9.494,9.494,0,0,0,9.5,0,9.5,9.5,0,0,0,.747,5.8a9.472,9.472,0,0,0,2.035,10.41A9.526,9.526,0,0,0,5.8,18.254a9.531,9.531,0,0,0,7.394,0,9.526,9.526,0,0,0,3.022-2.043A9.5,9.5,0,0,0,18.253,5.8Zm-5.095,6.392-0.967.967L9.45,10.426,6.708,13.159l-0.967-.967L8.483,9.45,5.741,6.717l0.967-.976L9.45,8.483l2.742-2.742,0.967,0.976L10.417,9.45Z"></path></svg></button>
        </div>';

        $pageTitle = 'แพ็คเกจทัวร์ออนไลน์';

        return view('pages.products.index')->with([
            'datatable' => [
                'title' => $pageTitle,

                'options' => [
                    // 'page' => 1,
                    'limit' => 24
                ],
                "url" => '/api/v1/tours/series',

                'filter' => $filters,
                'actions_right' => '<a class="btn btn-primary ml-2" href="/products/create"><svg class="svg-icon o__tiny o__by-text" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"><path d="M2 5v2h3v3h2V7h3V5H7V2H5v3H2z"></path></svg> <span>เพิ่มแพ็คเกจทัวร์เอง</span></a>'
            ],
            'page_current_tab' => '/products/'.$tab
        ]);
    }

    public function create()
    {
        // $wholesales = DB::table('wholesales')
        //     ->where('status', 1)
        //     ->get();

        return view('pages.products.create')->with([

            // 'wholesaleLists' => json_decode($wholesales, 1),
            'statusList' => ToursSeries::status()
        ]);
    }
}

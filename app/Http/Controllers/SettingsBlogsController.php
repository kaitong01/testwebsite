<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Library\Business;

class SettingsBlogsController extends Controller
{
    private $_tabs = array('category');

    public function index( $tab=null )
    {

        if( !in_array($tab, $this->_tabs) ){

            return view('pages.error');
        };


        $filters = '';


        $filters .= '<div class="filter-item"><label class="filter-item-label" for="status">สถานะ:</label><select class="filter-item-input form-control" id="status" name="status" data-action="change">'.
            '<option value="">ทั้งหมด</option>'.
            '<option value="1">ใช้งาน</option>'.
            '<option value="2">ระงับ</option>'.
        '</select></div>';


        $filters .= '<div class="filter-item search textbox-wrap">
                <input type="text" class="filter-item-input form-control form-textbox form-icon-left" id="search-input" autocomplete="off" role="combobox" name="q" value="" required="" data-action="search">

                <svg class="textbox-icon" viewBox="0 0 52.966 52.966" xmlns="http://www.w3.org/2000/svg"><path d="m51.704 51.273-14.859-15.453c3.79-3.801 6.138-9.041 6.138-14.82 0-11.58-9.42-21-21-21s-21 9.42-21 21 9.42 21 21 21c5.083 0 9.748-1.817 13.384-4.832l14.895 15.491c0.196 0.205 0.458 0.307 0.721 0.307 0.25 0 0.499-0.093 0.693-0.279 0.398-0.383 0.41-1.016 0.028-1.414zm-29.721-11.273c-10.477 0-19-8.523-19-19s8.523-19 19-19 19 8.523 19 19-8.524 19-19 19z"></path></svg>

                <button class="textbox-clear" type="button"><svg width="19" height="19" viewBox="0 0 19 19" xmlns="http://www.w3.org/2000/svg"><path d="M18.253,5.8A9.494,9.494,0,0,0,9.5,0,9.5,9.5,0,0,0,.747,5.8a9.472,9.472,0,0,0,2.035,10.41A9.526,9.526,0,0,0,5.8,18.254a9.531,9.531,0,0,0,7.394,0,9.526,9.526,0,0,0,3.022-2.043A9.5,9.5,0,0,0,18.253,5.8Zm-5.095,6.392-0.967.967L9.45,10.426,6.708,13.159l-0.967-.967L8.483,9.45,5.741,6.717l0.967-.976L9.45,8.483l2.742-2.742,0.967,0.976L10.417,9.45Z"></path></svg></button>

            </div>';



        return view('pages.settings')->with([
            'datatable' => [
                'title' => 'ประเภทบทความ',

                'options' => [
                    // 'page' => 1,
                    'limit' => 24
                ],
                "url" => '/blogs/category',

                'filter' => $filters,
                'actions_right' => '<a class="btn btn-primary ml-2" href="/blogs/category/create" data-plugin="lightbox"><svg class="svg-icon o__tiny o__by-text" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"><path d="M2 5v2h3v3h2V7h3V5H7V2H5v3H2z"></path></svg> <span>เพิ่ม</span></a>'
            ],
            'page_current_tab' => '/settings/blogs/'.$tab
        ]);
    }
}

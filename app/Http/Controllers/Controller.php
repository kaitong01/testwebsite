<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Support\Facades\Session;
use App\Company;
use App\Library\Business;
use App\Library\Fn;
use App\Library\Ui;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $_company = array();

    public function __construct() {
       	
        $this->ui = New Ui;
        $this->fn = New Fn;

       	// $id = Session::get('cid');
       	// dd( $id );

       	// $db = new Company();
       	// $this->_company = $db->get( $id );
       	// dd($id, $this->_company);
    }
}

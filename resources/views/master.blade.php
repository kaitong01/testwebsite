<?php




if( CompanyController::check( Auth::user()->company_id ) ){
    // return view('pages.settings');
}
else{

    // return view('pages.error');
}
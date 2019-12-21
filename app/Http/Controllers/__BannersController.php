<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Companies;
use App\Models\BannersModel;
use Session;
use Storage;
use Illuminate\Http\File;
use Validator;
use App\Http\Requests\UploadPhotoRequest;

use Illuminate\Support\Facades\Auth;

class BannersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $id = Session::get('cid');
        // dd($id);
        // $this->validate($request, [
        //     'chooseFile'=>'required|image|mimes:jpeg,jpg,png|max:2048'
        // ]);
        // if ($validatedData){
        if($request->file('chooseFile')){
          foreach ($request->file('chooseFile') as $key => $value) {
              //    dd($value);
              $db = new BannersModel;
              // $validatedData = $value->validate([
              //     'chooseFile'=>'required|image|mimes:jpeg,jpg,png|max:2048'
              //     // ]);
              //     $validator = Validator::make($value->all(), [
              //     'chooseFile'=>'required|image|mimes:jpeg,jpg,png|max:2048'
              // ]);
              // // dd($request->file('chooseFile')->path());
              // if($validatedData){
              $db->company_id = $id;
              $db->path = Storage::disk('public')->putFile("{$id}/banners", new File($value->path()));
              $db->created_uid = Auth::user()->id;
              $db->save();

              // }
          }
          return back();
        }else{
          return back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete($id)
    {
        $db = BannersModel::find($id);
        Storage::disk('public')->delete($db->path);
        $db->delete();
        return back();
    }
}

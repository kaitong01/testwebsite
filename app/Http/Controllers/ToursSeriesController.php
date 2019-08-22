<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use App\Models\Wholesale;
use App\Models\ToursSeries;
use App\Models\ToursPeriod;
use phpDocumentor\Reflection\Types\Null_;

class ToursSeriesController extends Controller
{
    protected $table = 'tours_series';
    protected $_validator = [
        'name' => 'required|max:75',
        // 'description' => 'required',
        // 'image' => 'required|mimes:jpeg,jpg,png|max:2048',
    ];
    // 10240 10 MB //  (2048 KB)
    protected $_validatorMessage = [
        'name.required' => 'กรุณากรอกชื่อซีรีย์',
        'description.required' => 'กรุณากรอกคำอธิบาย',
        'image.required' => 'กรุณาใส่รูปภาพ',
        'image.mimes' => 'ชนิดของไฟล์ต้องเป็น .jpeg, .jpg, .png เท่านั้น',
        'image.max' => 'รับขนาดไฟล์สูงสุดที่จะอัปโหลดคือ 2MB',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('errors.404');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('errors.404');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $arr = array();

        $validator = Validator::make($request->all(), $this->_validator, $this->_validatorMessage);

        if ( $validator->fails() ) {

            $arr['code'] = 422;
            $arr['errors'] = $validator->errors();
        }
        else{

            // DB::beginTransaction();

            // store
            $data = new ToursSeries;

            $data->wholesale_id   = $request->wholesale_id;
            $data->company_id     = Session::get('cid');
            $data->route_id       = $request->route_id;
            $data->airline_id     = $request->airline_id;

            $data->code           = $request->code;
            $data->name           = $request->name;
            $data->description    = $request->description;

            $data->days           = $request->days;
            $data->nights         = $request->nights;
            $data->price_at       = $request->price_at;


            $data->conditions     = $request->conditions;

            $data->status         = $request->status;
            $data->created_uid    = Auth::user()->id;
            $data->updated_uid    = Auth::user()->id;

            $plans = array();
            foreach ($request->plans as $value) {
                $plansTimes = array();

                foreach ($value['items'] as $times) {
                    if( empty($times['name']) && empty($times['text']) ) continue;

                    $plansTimes[] = $times;
                }

                if( empty($plansTimes) && empty($value['title']) ) continue;

                $plans[] = array(
                    'title' => trim($value['title']),
                    'items' => $plansTimes
                );
            }
            // dd($plans);
            if( !empty($plans) ){
                $data->plans = json_encode($plans);
            }

            if( $request->has('meals') ){
                $data->meals          = json_encode($request->meals);
            }
            $data->meals_note     = $request->meals_note;


            if( $request->has('hotels') ){

                $hotels = array();
                foreach ($request->hotels as $key => $value) {
                    if( empty($value['name']) ) continue;
                    $hotels[] = $value;
                }

                if( !empty($hotels) ){
                    $data->hotels  = json_encode($hotels);
                }
            }

            if( $request->has('hotels_note') ){
                $data->hotels_note    = $request->hotels_note;
            }

            // dd( $request->period );
            $data->periods_note    = $request->periods_note;

            // dd( $request->files );

            if( $data->save() ){

                $gallery = array();
                if($request->has('images')){

                    // dd( $request->images );
                    foreach ($request->images as $img) {

                        if( !empty($img['upload']) ) {
                            $image = $img['upload']->store(Session::get('cid'), 'public');
                        }
                        else if( !empty($img['name']) ){
                            $image = $img['name'];
                        }

                        $gallery[] = [$image, $img['caption']];
                    }
                }

                if( !empty($gallery) ){
                    $data->gallery = json_encode($gallery);
                    $data->update();
                }


                // set: files
                $files = array();
                if( $request->has('docs') ){

                    // dd( $request->docs );
                    foreach ($request->docs as $key => $value) {
                        if( !empty($value['upload']) ){
                            $files[] = array(
                                'name' => !empty($value['name'])? $value['name']: $value['upload']->getClientOriginalName(),
                                'exten' => $value['upload']->getClientOriginalExtension(),
                                'size' => $value['upload']->getClientSize(),
                                'key' => $value['key'],
                                'path' => $value['upload']->store(Session::get('cid'), 'public')
                            );

                        }
                    }
                }

                if( !empty($files) ){
                    $data->files = json_encode($files);
                    $data->update();
                }

                // set: period
                foreach ($request->period as $item) {

                    if( empty($item['start_date']) || empty($item['end_date']) ) continue;

                    $period = new ToursPeriod;

                    // $period->wholesale_id = $request->wholesale_id;
                    $period->series_id = $data->id;

                    list($d, $m, $y) = explode('/', $item['start_date']);
                    $period->start_date = date("{$y}-{$m}-{$d}");

                    list($d, $m, $y) = explode('/', $item['end_date']);
                    $period->end_date = date("{$y}-{$m}-{$d}");

                    $period->status = $item['status'];

                    $prices = array();
                    if( !empty($item['prices_options']) ){
                        foreach ($item['prices_options'] as $price) {
                            $prices[] = str_replace(',', '', $price);
                        }
                    }

                    if( !empty( $prices[0] ) ){
                        $period->price_at = $prices[0];
                    }

                    $period->prices_options = !empty($prices)? json_encode($prices): '';
                    $period->discount = $item['discount'];
                    $period->created_uid = Auth::user()->id;
                    $period->updated_uid = Auth::user()->id;

                    $period->save();
                }

                // DB::commit();

                $arr['code'] = 200;
                $arr['message'] = 'สร้างซีรีย์ทัวร์เรียบร้อย';
                $arr['redirect'] = '/products/'.$data->id;
            }
            else{
                $arr['code'] = 422;
                $arr['message'] = 'บันทึกข้อมูลล้มเหล่ว, กรุณาลองใหม่';
            }
        }

        return response()->json($arr, $arr['code']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('errors.404');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('errors.404');
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
        $data = ToursSeries::find( $id );
        if( is_null( $data ) ){
            return response()->json(["message" => 'Record not found!'], 404);
        }



        $arr = array();

        $validator = Validator::make($request->all(), $this->_validator, $this->_validatorMessage);

        if ( $validator->fails() ) {

            $arr['code'] = 422;
            $arr['errors'] = $validator->errors();
        }
        else{

            $data->wholesale_id   = $request->wholesale_id;
            $data->company_id     = Session::get('cid');
            $data->route_id       = $request->route_id;
            $data->airline_id     = $request->airline_id;

            $data->code           = $request->code;
            $data->name           = $request->name;
            $data->description    = $request->description;

            $data->days           = $request->days;
            $data->nights         = $request->nights;
            $data->price_at       = $request->price_at;


            $data->conditions     = $request->conditions;

            $data->status         = $request->status;
            $data->created_uid    = Auth::user()->id;
            $data->updated_uid    = Auth::user()->id;

            $plans = array();
            foreach ($request->plans as $key => $value) {
                $plansTimes = array();

                foreach ($value['items'] as $times) {
                    if( empty($times['name']) && empty($times['text']) ) continue;

                    $plansTimes[] = $times;
                }

                if( empty($plansTimes) && empty($value['title']) ) continue;

                $plans[] = array(
                    'title' => trim($value['title']),
                    'items' => $plansTimes
                );
            }
            // dd($plans);

            $data->plans  = !empty($plans)
                ? json_encode($plans)
                : Null;


            if( $request->has('meals') ){
                $data->meals          = json_encode($request->meals);
            }
            $data->meals_note     = $request->meals_note;

            if( $request->has('hotels') ){

                $hotels = array();
                foreach ($request->hotels as $key => $value) {
                    if( empty($value['name']) ) continue;
                    $hotels[] = $value;
                }
            }

            $data->hotels  = !empty($hotels)
                ? json_encode($hotels)
                : Null;

            $data->hotels_note    = $request->hotels_note;
            $data->periods_note   = $request->periods_note;


            // dd( $request->files_word );

            if( $data->update() ){

                // set: gallery
                $oldGallery = json_decode($data->gallery, 1);

                $gallery = array();
                if($request->has('images')){

                    // dd( $request->images );
                    foreach ($request->images as $img) {

                        if( !empty($img['upload']) ) {
                            $image = $img['upload']->store(Session::get('cid'), 'public');
                        }
                        else if( !empty($img['name']) ){
                            $image = $img['name'];
                        }

                        if( !empty($oldGallery) ){
                            foreach ($oldGallery as $i => $value) {
                                if( $value[0]==$image ){
                                    unset( $oldGallery[$i] );
                                }
                            }
                        }

                        $gallery[] = [$image, $img['caption']];
                    }
                }

                if( !empty($oldGallery) ){
                    foreach ($oldGallery as $key => $value) {
                        Storage::disk('public')->delete($value[0]);
                    }
                }

                if( !empty($gallery) ){
                    $data->gallery = json_encode($gallery);
                }
                else{
                    $data->gallery = '';
                }



                // set: files
                $files = array();
                $oldFiles = array();
                if( !empty($data->files) ){
                    $oldFiles = json_decode($data->files, 1);
                }

                if( $request->has('docs') ){

                    // dd( $request->docs );
                    foreach ($request->docs as $key => $value) {

                        if( !empty($value['remove']) && !empty($oldFiles) ){
                            foreach ($oldFiles as $i => $val) {

                                if( $val['key']==$value['key'] ){
                                    Storage::disk('public')->delete($val['path']);
                                }
                            }
                        }

                        if( !empty($value['upload']) ){
                            //insert
                            // dd($value['upload']->getClientOriginalName());

                            $files[] = array(
                                'name' => !empty($value['name'])? $value['name']: $value['upload']->getClientOriginalName(),
                                'exten' => $value['upload']->getClientOriginalExtension(),
                                'size' => $value['upload']->getClientSize(),
                                'key' => $value['key'],
                                'path' => $value['upload']->store(Session::get('cid'), 'public')
                            );

                        } else if( !empty($value['name']) && !empty($oldFiles) ){

                            // update
                            foreach ($oldFiles as $i => $val) {
                                if( $val['key']==$value['key'] ){
                                    $val['name'] = $value['name'];
                                    $files[] = $val;
                                }
                            }
                        }

                    }
                }

                $data->files = !empty($files) ? json_encode($files): NULL;


                //
                $data->update();


                // set: period
                $oldPeriods = ToursPeriod::where('series_id','=', $id)->orderby('start_date', 'asc')->get();
                $hasPeriodIds = array();

                foreach ($request->period as $item) {

                    if( empty($item['start_date']) || empty($item['end_date']) ) continue;

                    if( !empty($item['id']) ){
                        $period = ToursPeriod::find( $item['id'] );
                        $hasPeriodIds[] = $item['id'];
                    }
                    else{
                        $period = new ToursPeriod;
                    }

                    // $period->wholesale_id = $request->wholesale_id;
                    $period->series_id = $data->id;

                    list($d, $m, $y) = explode('/', $item['start_date']);
                    $m++; $m = $m < 10 ? "0{$m}":$m;
                    $period->start_date = date("{$y}-{$m}-{$d}");

                    list($d, $m, $y) = explode('/', $item['end_date']);
                    $m++; $m = $m < 10 ? "0{$m}":$m;
                    $period->end_date = date("{$y}-{$m}-{$d}");

                    $period->status = $item['status'];

                    $prices = array();
                    if( !empty($item['prices_options']) ){
                        foreach ($item['prices_options'] as $price) {
                            $prices[] = str_replace(',', '', $price);
                        }
                    }

                    if( !empty( $prices[0] ) ){
                        $period->price_at = $prices[0];
                    }

                    $period->prices_options = !empty($prices)? json_encode($prices): '';
                    $period->discount = $item['discount'];
                    $period->created_uid = Auth::user()->id;
                    $period->updated_uid = Auth::user()->id;

                    $period->save();
                }

                // dd($hasPeriodIds);
                foreach ($oldPeriods as $item) {
                    if( !in_array($item->id, $hasPeriodIds) ){

                        $period = ToursPeriod::find( $item->id );
                        $period->delete();
                    }
                }

                $arr['code'] = 200;
                $arr['message'] = 'บันทึกเรียบร้อย';
                $arr['clearFormData'] = true;

                $arr['reset_fields'] = ['files_pdf', 'files_word'];
                // $arr['redirect'] = '/tours/series/'.$data->id;

                $arr['call'] = 'reFormSeries';
            }
            else{
                $arr['code'] = 422;
                $arr['message'] = 'บันทึกข้อมูลล้มเหล่ว, กรุณาลองใหม่';
            }
        }

        return response()->json($arr, $arr['code']);
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
}

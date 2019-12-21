<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TourSerieRequest;
use App\Models\DefaultAirlines;
use App\Models\TourCountryModel;
use App\Models\TourSerie;
use App\Models\TourPeriod;
use Illuminate\Support\Facades\Storage;

class TourSerieController extends Controller
{
    public function index(Request $request)
    {
        $ops = [
            'sort' => isset($request->sort)? $request->sort: 'updated_at',
            'dir' => isset($request->dir)? $request->dir: 'desc',

            'limit' => isset($request->limit)? $request->limit: 1,
            'page' => isset($request->page)? $request->page: 1,

            'ts' =>  isset($request->ts)? $request->ts: time(),
        ];

        $where = [];

        if( $request->has('status') ){
            $where[] = ['status', '=', $request->status];
        }


        if( $request->has('state') ){

            if( $request->state==1 ){
                $where[] = ['wholesale_id', '=', 0];

            }
            else{
                $where[] = ['wholesale_id', '>', 0];
            }

        }

        if( $request->has('q') ){
            $where[] = ['name', 'LIKE', "%{$request->q}%"];
            $ops['q'] = $request->q;
        }

        $where[] = ['company_id', '=', $request->user()->company->id ];

        $results = TourSerie::where($where)

            ->orderby( $ops['sort'], $ops['dir'] )

            ->skip( ($ops['page']*$ops['limit'])-$ops['limit'])
            ->take( $ops['limit'] )

            ->paginate( $ops['limit'] );

        $res = [
            'options' => $ops,
            'total' => $results->total(),
            'data' => $results->items(),
        ];

        $res['code'] = 200;
        $res['info'] = 'Results successfully';
        $res['message'] = 'The request has succeeded.';

        // dd($res);
        $res['items'] = $this->ui->item('TourSerieDatatable')->init( $res['data'], $ops );

        return response()->json($res, 200);
    }

    public function create()
    {
        # country
        $TourCountryModel = new TourCountryModel();
        $countryList = $TourCountryModel->getActive();

        # status
        $statusList = TourSerie::status();

        # airline
        $airlineList = DefaultAirlines::get();



        return view('pages.product.create',compact('statusList', 'countryList', 'airlineList'));
    }
    public function store(TourSerieRequest $request)
    {
        $data = new TourSerie;

        if( $data->fill( $request->input() )->save() ){

            ## update: price_at
            $data->price_at = str_replace(',', '', $request->price_at);

            ### update: company
            $data->company_id = $request->user()->company->id;


            ### update: plans
            if( $request->has('plans')  ){

                $plans = [];
                foreach ($request->plans as $value) {
                    $plansTimes = [];

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
            }
            $data->plans = !empty($plans)? json_encode($plans): null;

            ### update: meals
            $data->meals = $request->has('meals')? json_encode($request->meals): null;


            ### update: hotels
            if( $request->has('hotels') ){

                $hotels = [];
                foreach ($request->hotels as $key => $value) {
                    if( empty($value['name']) ) continue;
                    $hotels[] = $value;
                }
            }
            $data->hotels = !empty($hotels)? json_encode($hotels): null;


            ### update: gallery
            $gallery = [];
            if($request->has('images')){

                // dd( $request->images );
                foreach ($request->images as $img) {

                    $dataImage = array();
                    if( !empty($img['upload']) ) {

                        $dataImage['path'] = $img['upload']->store($request->user()->company->id.'/gallery/', 'public');
                        $dataImage['name'] = $img['upload']->getClientOriginalName();

                        if( isset($img['caption']) ){
                            $dataImage['caption'] = $img['caption'];
                        }

                        $gallery[] = $dataImage;
                    }
                }
            }
            $data->gallery = !empty($gallery)? json_encode($gallery): null;


            ### update docs
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
                            'path' => $value['upload']->store($request->user()->company->id.'/docs/', 'public'),

                        );

                    }
                }
            }
            $data->files = !empty($files)? json_encode($files): null;


            ## update permalink
            $data->permalink = $request->has('permalink')
                ? $this->fn->q('text')->createPermalink($request->permalink)
                : $this->fn->q('text')->createPermalink($request->name);


            ## all update
            $data->created_uid = $request->user()->id;
            $data->updated_uid = $request->user()->id;
            $data->update();


            ### set: period
            foreach ($request->period as $item) {

                if( empty($item['start_date']) || empty($item['end_date']) ) continue;

                $period = new TourPeriod();

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
                // $period->discount = $item['discount'];
                $period->created_uid = $request->user()->id;
                $period->updated_uid = $request->user()->id;

                $period->save();
            }



            // $res['data'] = $data;
            $res['code'] = 200;
            $res['message'] = 'บันทึกข้อมูลแล้ว';

            $res['redirect'] = "/tours/series/{$data->id}/edit";
        }
        else{
            $res['code'] = 402;
            $res['message'] = 'บันทึกข้อมูลล้มเหลว, กรุณาลองใหม่';
        }

        return response()->json($res, $res['code']);
    }

    public function edit(Request $request, $id )
    {
        # get Data
        $data = TourSerie::findOrFail( $id );

        if( $data->company_id !== $request->user()->company->id ){
            return  abort(404);
        }

        # country
        $TourCountryModel = new TourCountryModel();
        $countryList = $TourCountryModel->getActive();

        # status
        $statusList = TourSerie::status();

        # airline
        $airlineList = DefaultAirlines::get();

        # periods
        $periods = TourPeriod::where('series_id','=', $id)->orderby('start_date', 'asc')->get();

        return view('pages.product.create',compact('statusList', 'countryList', 'data', 'airlineList', 'periods'));
    }

    public function update(TourSerieRequest $request, $id)
    {
        $data = TourSerie::findOrFail( $id );

        if( $data->fill( $request->input() )->save() ){

            ## update: price_at
            $data->price_at = str_replace(',', '', $request->price_at);

            ### update: plans
            if( $request->has('plans')  ){

                $plans = [];
                foreach ($request->plans as $value) {
                    $plansTimes = [];

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
            }
            $data->plans = !empty($plans)? json_encode($plans, JSON_UNESCAPED_UNICODE): null;

            ### update: meals
            $data->meals = $request->has('meals')? json_encode($request->meals, JSON_UNESCAPED_UNICODE): null;


            ### update: hotels
            if( $request->has('hotels') ){

                $hotels = [];
                foreach ($request->hotels as $key => $value) {
                    if( empty($value['name']) ) continue;
                    $hotels[] = $value;
                }
            }
            $data->hotels = !empty($hotels)? json_encode($hotels, JSON_UNESCAPED_UNICODE): null;


            ### update: gallery
            $gallery = []; $oldGallery = json_decode($data->gallery, 1);
            if($request->has('images')){

                // dd( $request->images );
                foreach ($request->images as $img) {

                    $dataImage = array();

                    if( !empty($img['upload']) ) {
                        $dataImage['path'] = $img['upload']->store($request->user()->company->id.'/gallery/', 'public');
                        $dataImage['name'] = $img['upload']->getClientOriginalName();
                        $dataImage['size'] = $img['upload']->getClientSize();
                    }

                    if( isset($img['id']) && !empty($oldGallery) ){
                        foreach ($oldGallery as $i => $value) {
                            $img_id = isset($value['id']) ? $value['id']: $i;
                            if( $img_id==$img['id'] ){

                                $dataImage = $value;
                                unset( $oldGallery[$i] );
                            }
                        }
                    }

                    if( !empty( $img['caption'] ) ){
                        $dataImage['caption'] = $img['caption'];
                    }
                    else if( isset($dataImage['caption']) ) {
                        unset($dataImage['caption']);
                    }

                    $gallery[] = $dataImage;
                }
            }
            if( !empty($oldGallery) ){
                foreach ($oldGallery as $value) {
                    if( isset($value['path']) ){
                        Storage::disk('public')->delete($value['path']);
                    }
                }
            }
            $data->gallery = !empty($gallery)? json_encode($gallery, JSON_UNESCAPED_UNICODE): null;


            ### update docs
            $files = [];
            $oldFiles = array();
            if( !empty($data->files) ){
                $oldFiles = json_decode($data->files, 1);
            }

            if( $request->has('docs') ){

                // dd( $request->docs );
                foreach ($request->docs as $key => $value) {

                    if( !empty($value['remove']) && !empty($oldFiles) ){
                        foreach ($oldFiles as $val) {

                            if( $val['key']==$value['key'] && !empty($val['path']) ){
                                Storage::disk('public')->delete($val['path']);
                            }
                        }
                    }


                    if( !empty($value['upload']) ){
                        //insert

                        $files[] = array(
                            'name' => !empty($value['name'])? $value['name']: $value['upload']->getClientOriginalName(),
                            'exten' => $value['upload']->getClientOriginalExtension(),
                            'size' => $value['upload']->getClientSize(),
                            'key' => $value['key'],
                            'path' => $value['upload']->store($request->user()->company->id.'/docs/', 'public'),
                        );

                    } else if( !empty($value['name']) && !empty($oldFiles) ){

                        // update
                        foreach ($oldFiles as $val) {
                            if( $val['key']==$value['key'] ){
                                $val['name'] = $value['name'];
                                $files[] = $val;
                            }
                        }
                    }
                }
            }

            $data->files = !empty($files)? json_encode($files, JSON_UNESCAPED_UNICODE): null;


            ## update permalink
            $data->permalink = $request->has('permalink')
                ? $this->fn->q('text')->createPermalink($request->permalink)
                : $this->fn->q('text')->createPermalink($request->name);


            ## all update
            $data->created_uid = $request->user()->id;
            $data->updated_uid = $request->user()->id;
            $data->update();


            ### set: period
            $oldPeriods = TourPeriod::where('series_id','=', $id)->orderby('start_date', 'asc')->get();
            $hasPeriodIds = [];

            foreach ($request->period as $item) {

                if( empty($item['start_date']) || empty($item['end_date']) ) continue;

                if( !empty($item['id']) ){
                    $period = TourPeriod::find( $item['id'] );
                    $hasPeriodIds[] = $item['id'];
                }
                else{
                    $period = new TourPeriod();
                }

                $period->series_id = $data->id;

                list($d, $m, $y) = explode('/', $item['start_date']);
                $m = $m < 10 ? "0{$m}":$m;

                $period->start_date = date("{$y}-{$m}-{$d}");

                list($d, $m, $y) = explode('/', $item['end_date']);
                $m = $m < 10 ? "0{$m}":$m;
                $period->end_date = date("{$y}-{$m}-{$d}");


                $period->status = $item['status'];

                $prices = array();
                if( !empty($item['prices_options']) ){
                    foreach ($item['prices_options'] as $price) {
                        $prices[] = str_replace(',', '', $price);
                    }
                }


                $period->price_at = 0;
                if( !empty( $prices[0] ) ){
                    $period->price_at = $prices[0];
                }

                $period->prices_options = !empty($prices)? json_encode($prices): NULL;

                // $period->discount = $item['discount'];
                $period->created_uid = $request->user()->id;
                $period->updated_uid = $request->user()->id;

                $period->save();
            }

            if( !empty($oldPeriods) ){
                foreach ($oldPeriods as $item) {
                    if( !in_array($item->id, $hasPeriodIds) ){

                        $period = TourPeriod::find( $item->id );
                        $period->delete();
                    }
                }
            }


            ## call back
            $res['code'] = 200;
            $res['message'] = 'บันทึกข้อมูลแล้ว';

            $res['redirect'] = "/tours/series/{$data->id}/edit";
        }
        else{
            $res['code'] = 402;
            $res['message'] = 'บันทึกข้อมูลล้มเหลว, กรุณาลองใหม่';
        }

        return response()->json($res, $res['code']);
    }

    public function switch(Request $request)
    {
        $data = TourSerie::findOrFail($request->id);

        if( $data->fill( $request->input() )->save() ){

            $res['data'] = $data;
            $res['code'] = 200;
            $res['message'] = 'บันทึกข้อมูลแล้ว';
        }
        else{
            $res['code'] = 402;
            $res['message'] = 'บันทึกข้อมูลล้มเหลว, กรุณาลองใหม่';
        }

        return response()->json($res, $res['code']);
    }
}

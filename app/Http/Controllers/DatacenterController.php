<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\DatacenterSeries;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class DatacenterController extends Controller
{
    public function series( Request $request, $tab )
    {
        // $tab = basename(Route::getFacadeRoot()->current()->uri);
        // dd($tab);
        $ops = [
            'sort' => isset($request->sort)? $request->sort: 'updated_at',
            'dir' => isset($request->dir)? $request->dir: 'desc',

            'limit' => isset($request->limit)? $request->limit: 1,
            'page' => isset($request->page)? $request->page: 1,

            'ts' =>  isset($request->ts)? $request->ts: time(),
        ];

        $where = [];

        // if( $request->has('status') ){
        //     $where[] = ['status', '=', $request->status];
        // }

        if( $request->has('q') ){
            $where[] = ['name', 'LIKE', "%{$request->q}%"];
            $ops['q'] = $request->q;
        }

        $where[] = ['status', '=', 1];
        $wholesalesIDs = Company::wholesalesIds( $request->user()->company->id );



        $sth = DatacenterSeries::where($where);

        if( $tab==='new' ){

            //
            $eData = date('Y-m-d 23:59:59');
            $fDate = strtotime("-7 day", strtotime($eData));

            $sth->whereBetween('created_at', [date('Y-m-d 23:59:59', $fDate), $eData]);
        }



        $sth->whereIn( 'wholesale_id', $wholesalesIDs )

            ->orderby( $ops['sort'], $ops['dir'] )

            ->skip( ($ops['page']*$ops['limit'])-$ops['limit'])
            ->take( $ops['limit'] );

        $results = $sth->paginate( $ops['limit'] );

        $res = [
            'options' => $ops,
            'total' => $results->total(),
            'data' => DatacenterSeries::buildFrag( $results->items() ),
        ];

        $res['code'] = 200;
        $res['info'] = 'Results successfully';
        $res['message'] = 'The request has succeeded.';

        // dd($res);
        $res['items'] = $this->ui->item('DatacenterSeriesDatatable')->init( $res['data'], $ops );

        return response()->json($res, 200);
    }
}

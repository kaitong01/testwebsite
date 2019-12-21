<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Company $model, Request $request)
    {

        $ops = array(
            'sort' => isset($request->sort)? $request->sort: 'updated_at',
            'dir' => isset($request->dir)? $request->dir: 'desc',

            'limit' => isset($request->limit)? $request->limit: 1,
            'page' => isset($request->page)? $request->page: 1,

            'ts' => isset($request->ts)? $request->ts: time(),
        );

        $where = [];

        // if( $request->has('status') ){
        //     if( $request->status!='' ){
        //         $where[] = ['status', '=', $request->status];
        //     }
        // }

        $where[] = ['status', '=', 1];

        $sth = Company::where($where)
            ->select([
                'name', 'id', 'status', 'domain', 'username'
            ])
            ->orderby( $ops['sort'], $ops['dir'] )

            ->skip( ($ops['page']*$ops['limit'])-$ops['limit'])
            ->take( $ops['limit'] )

            ->paginate( $ops['limit'] );

        $arr = [
            'options' => $ops,
            'total' => $sth->total(),
            'data' => $model->buildFrag($sth->items()),
        ];

        return response()->json($arr, 200);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Companies;

class CompaniesController extends Controller
{
    protected $table = 'companies';

    public function index(Request $request)
    {
        $model = new Companies;
        $ops = array(
            'sort' => isset($request->sort)? $request->sort: 'updated_at',
            'dir' => isset($request->dir)? $request->dir: 'desc',

            'limit' => isset($request->limit)? $request->limit: 1,
            'page' => isset($request->page)? $request->page: 1,

            'ts' => time(),
        );


        $sth = DB::table($this->table);
        // $sth->where( 'cid', '=', Session::get('cid') );

        // if( isset($request->q) ){
        //     $ops['q'] = trim($request->q);

        //     $sth->where( 'name', 'LIKE', "%{$ops['q']}%" );
        // }

        if( isset($request->status) ){
            $ops['status'] = trim($request->status);
            $sth->where( 'status', '=', $ops['status'] );
        }


        $total = $sth;

        $sth->orderby( $ops['sort'], $ops['dir'] );
        $sth->skip( ($ops['page']*$ops['limit'])- $ops['limit']);
        $sth->take( $ops['limit'] );


        $results = $sth->get();
        $arr['total'] = $total->count();

        $arr['data'] = $model->buildFrag( $results );
        $arr['options'] = $ops;

        // $arr['items'] = $this->ui->q('BlogCategoryUi')->init($arr['data'], $arr['options']);

        return response()->json($arr, 200);
    }
}

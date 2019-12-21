<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TourWholesaleModel extends Model
{
    protected $table = 'companies_wholesales_permit';
    public $primaryKey = 'id';
    public $itemstamps = false;
    public $maxlimit = 24;

    protected $fillable = [
        'company_id',
        'wholesale_id',
        'status',
    ];
    protected $hidden = [];

    # get: Data form database


    public function findActive($ops, $request)
    {
        # connect DB
        $sth = DB::table( 'wholesales' );

        $sth->leftJoin('companies_wholesales_permit', 'wholesales.id', '=', 'companies_wholesales_permit.wholesale_id');

        $sth->groupBy('wholesales.id');

        # set select: fields
        $sth->select([

            'companies_wholesales_permit.id',
            'companies_wholesales_permit.status',

            'wholesales.id as original_id',
            'wholesales.name',
            'wholesales.logo',

        ]);

        # set condition

        $sth->where( 'companies_wholesales_permit.status', '=', 1 );
        $sth->where( 'companies_wholesales_permit.company_id', '=', Auth::user()->company->id );

        if( !empty($request->q) ){
            $sth->where( 'wholesales.name', 'LIKE', "{$request->q}%" );
        }

        # set sort data
        if( $request->has('sort') ){
            // $ops['sort'] = $request->sort;
            // $sort = $ops['sort'];

            // if( $sort=='' ){
            //     $sort = 'updated_at desc';
            // }
            // else{
            //     $sort = 'updated_at desc';
            // }
        }
        else{
            $sth->orderby( 'wholesales.name', 'asc' );
        }

        $sth->skip( ($ops['page']*$ops['limit'])- $ops['limit']);
        $sth->take( $ops['limit'] );

        # get results
        $results = $sth->paginate($ops['limit']);

        // dd($sth->sql());

        # response
        $ops['total'] = $results->total();


        return [
            'options'   => $ops,
            'data'      => $this->buildFrag($results->items()),
            'total'     => $results->total(),
        ];

    }

    public function findAll($ops, $request)
    {
        $limit = ($ops['page']*$ops['limit'])- $ops['limit'];

        $condition = ''; $params = [];

        $company_id = Auth::user()->company->id;


        if( !empty($request->q) ){


            $condition .= !empty($condition)? ' AND ': '';
            $condition .= "(wholesales.name LIKE '{$request->q}%')";

        }

        $where = !empty( $condition)? "WHERE {$condition}": '';
        $sql = "SELECT

                companies_wholesales_permit.id,
                companies_wholesales_permit.status,

                wholesales.id as original_id,
                wholesales.name as name,
                wholesales.logo as logo

            FROM
            wholesales
                LEFT JOIN companies_wholesales_permit ON wholesales.id=companies_wholesales_permit.wholesale_id AND companies_wholesales_permit.company_id={$company_id}

            {$where}

            GROUP BY wholesales.name

            LIMIT {$limit},{$ops['limit']}

        ";
        // dd($sql);

        $results = DB::select($sql, $params);

        # response
        $sth = DB::table('wholesales');
        if( !empty($request->q) ){
            $sth->where( 'wholesales.name', 'LIKE', "{$request->q}%" );
        }

        $ops['total'] = $sth->count();

        return [
            'options'   => $ops,
            'data'      => $results,
            'total'     => $ops['total'],
        ];
    }

    public function find($request)
    {
        # set options
        $ops = array(
            'limit' => intval(isset($request->limit)? $request->limit: 24),
            'page' => intval(isset($request->page)? $request->page: 1),

            'ts' => isset($request->ts)? $request->ts: time(),
        );

        if($ops['limit'] >= $this->maxlimit){
            $ops['limit'] = $this->maxlimit;
        }

        if( $request->has('status') ){

            if( $request->status==1 ) {
                return $this->findActive($ops, $request);
            }
        }

        return $this->findAll($ops, $request);
    }


    # convert: Data
    public function buildFrag($results, $options=[]) {
        $data = [];
        foreach ($results as $key => $value) { if( empty($value) ) continue; $data[] = $this->convert( $value ); }
        return $data;
    }
    public function convert($data){

        // $permalink = strtolower($data->name);
        // $data->permalink = asset('/tours/countries/'.$permalink);

        // $data->name = ucwords($permalink);

        if( !empty( $data->image ) ){
            $data->image_url = asset("storage/{$data->image}");
        }
        else if( !empty( $data->original_image ) ){
            $data->image_url = asset("storage/{$data->original_image}");
        }

        return $data;
    }
    public static function status()
    {
        $items = [];
        $items[] = ['id'=>1, 'name'=>'เปิดใช้งาน'];
        $items[] = ['id'=>0, 'name'=>'ระงับ'];

        return $items;
    }
}

<?php

namespace App\Models;

use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TourCountryModel extends Model
{

    protected $table = 'companies_countries_permit';
    public $primaryKey = 'id';
    public $itemstamps = false;
    public $maxlimit = 24;

    protected $fillable = [
        'name', 'description',

        'company_id', 'country_id', 'status',

        'seo_title', 'seo_description', 'permalink',
    ];
    protected $hidden = [];

    public $_select = [

    ];


    public function getActive($ops = [])
    {
        # connect DB
        $sth = DB::table( 'countries' );

        $sth->leftJoin('companies_countries_permit', 'countries.id', '=', 'companies_countries_permit.country_id');

        $sth->groupBy('countries.id');

        # set select: fields
        $sth->select([

            'companies_countries_permit.id',
            'companies_countries_permit.name',

            'countries.name as original_name',
        ]);

        # set condition
        $sth->where( 'companies_countries_permit.status', '=', 1 );
        $sth->where( 'companies_countries_permit.company_id', '=', Auth::user()->company->id );

        $sth->orderby( 'countries.region_id', 'asc' );
        $sth->orderby( 'countries.name', 'asc' );

        # get results
        $results = $sth->get();
        $data = [];
        foreach ($results as $value) {

            $data[] = [
                'id' => $value->id,
                'name' => !empty($value->name)? $value->name: $value->original_name
            ];
        }

        return $data;
    }

    public function findActive($ops, $request)
    {
        # connect DB
        $sth = DB::table( 'countries' );

        $sth->leftJoin('countries_regions', 'countries_regions.id', '=', 'countries.region_id');
        $sth->leftJoin('companies_countries_permit', 'countries.id', '=', 'companies_countries_permit.country_id');

        $sth->groupBy('countries.id');

        # set select: fields
        $sth->select([

            'companies_countries_permit.id',
            'companies_countries_permit.name',
            'companies_countries_permit.description',
            'companies_countries_permit.status',
            'companies_countries_permit.image',

            'countries.id as original_id',
            'countries.name as original_name',
            'countries.description as original_description',
            'countries.name_th as original_name_th',
            'countries.image as original_image',

            'countries_regions.id as region_id',
            'countries_regions.name as region_name',
        ]);

        # set condition

        $sth->where( 'companies_countries_permit.status', '=', 1 );
        $sth->where( 'companies_countries_permit.company_id', '=', Auth::user()->company->id );

        if( !empty($request->q) ){
            $sth->where( 'countries.name', 'LIKE', "{$request->q}%" );
            $sth->orWhere( 'countries_regions.name', 'LIKE', "{$request->q}%" );
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
            $sth->orderby( 'countries.region_id', 'asc' );
            $sth->orderby( 'countries.name', 'asc' );
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
            $condition .= "(countries.name LIKE '{$request->q}%' OR countries.name_th LIKE '{$request->q}%')";

            // $sth->where( 'countries.name', 'LIKE', "{$request->q}%" );
            // $sth->orWhere( 'countries_regions.name', 'LIKE', "{$request->q}%" );
        }

        $where = !empty( $condition)? "WHERE {$condition}": '';
        // $sth = DB::select('select * from users where active = ?', [1]);
        $sql = "SELECT

            companies_countries_permit.id,
            companies_countries_permit.name,
            companies_countries_permit.description,
            companies_countries_permit.status,
            companies_countries_permit.image,
            companies_countries_permit.company_id,

            countries.id as original_id,
            countries.name as original_name,
            countries.description as original_description,
            countries.name_th as original_name_th,
            countries.image as original_image,

            countries_regions.id as region_id,
            countries_regions.name as region_name


            FROM
            countries
                LEFT JOIN countries_regions ON countries_regions.id=countries.region_id
                LEFT JOIN companies_countries_permit ON countries.id=companies_countries_permit.country_id AND companies_countries_permit.company_id={$company_id}

            {$where}

            GROUP BY countries.id
            ORDER BY countries.region_id, countries.name

            LIMIT {$limit},{$ops['limit']}

        ";
        // dd($sql);

        $results = DB::select($sql, $params);

        # response
        $sth = DB::table('countries');
        if( !empty($request->q) ){
            $sth->where( 'countries.name', 'LIKE', "{$request->q}%" );
            $sth->orWhere( 'countries.name_th', 'LIKE', "{$request->q}%" );
            // $sth->orWhere( 'countries_regions.name', 'LIKE', "{$request->q}%" );
        }

        $ops['total'] = $sth->count();

        return [
            'options'   => $ops,
            'data'      => $results,
            'total'     => $ops['total'],
        ];
    }

    # get: Data form database
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

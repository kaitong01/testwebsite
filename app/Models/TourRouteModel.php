<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TourRouteModel extends Model
{
    protected $table = 'tours_routes';
    public $primaryKey = 'id';
    public $itemstamps = false;
    public $maxlimit = 24;

    protected $fillable = [
        'name', 'highlight', 'description',

        'company_id', 'status',

        'seo_title', 'seo_description',
    ];
    protected $hidden = [];


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

        # connect DB
        $sth = DB::table( $this->table );

        // $sth->leftJoin('countries_regions', 'countries_regions.id', '=', 'countries.region_id');
        // $sth->leftJoin('companies_countries_permit', function ($join)
        // {


        //     $join
        //         ->on('countries.id', '=', 'companies_countries_permit.country_id')
        //         ->raw('companies_countries_permit.company_id='.Auth::user()->company->id );
        // });

        # set select: fields
        // $sth->select([

        //     'companies_countries_permit.id',
        //     'companies_countries_permit.name',
        //     'companies_countries_permit.description',
        //     'companies_countries_permit.status',
        //     'companies_countries_permit.image',

        //     'countries.id as original_id',
        //     'countries.name as original_name',
        //     'countries.description as original_description',
        //     'countries.name_th as original_name_th',
        //     'countries.image as original_image',

        //     'countries_regions.id as region_id',
        //     'countries_regions.name as region_name',
        // ]);

        $sth->where( 'tours_routes.company_id', '=', Auth::user()->company->id );

        # set condition
        if( $request->has('status') ){

            if( $request->status==1 ) {
                $sth->where( 'tours_routes.status', '=', $request->status );
            }
        }

        if( !empty($request->q) ){
            $sth->where( 'tours_routes.name', 'LIKE', "{$request->q}%" );
        }

        # set sort data
        if( $request->has('sort') ){

        }
        else{
            $sth->orderby( 'tours_routes.updated_at', 'desc' );
            $sth->orderby( 'tours_routes.name', 'asc' );
        }


        $sth->skip( ($ops['page']*$ops['limit'])- $ops['limit']);
        $sth->take( $ops['limit'] );

        # get results
        $results = $sth->paginate($ops['limit']);

        // dd(DB::getQueryLog());

        # response
        $ops['total'] = $results->total();

        return [
            'options'   => $ops,
            'data'      => $this->buildFrag($results->items()),
            'total'     => $results->total(),
        ];
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
        $items[] = ['id'=>1, 'name'=>'ใช้งาน'];
        $items[] = ['id'=>0, 'name'=>'ระงับ'];

        return $items;
    }


    public function countries()
    {
        return $this->belongsToMany('App\Models\CountryModel', 'tours_routes_countries', 'route_id', 'country_id');
    }
}

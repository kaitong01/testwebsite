<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Companies extends Model
{
    protected $table = 'companies';
    // protected $prefix = 'co_';

    public $primatyKey = 'id';
    public $itemstamps = false;
    public $_prefixTable = "co_";

    protected $fillable = [
    	  'name'
    	, 'username'
    	, 'domain'
    	, 'status'
    ];


    public function buildFrag($results, $options=array()) {
        $data = array();
        foreach ($results as $key => $value) { if( empty($value) ) continue; $data[] = $this->convert( $value ); }
        return $data;
    }

    public function convert($data){
        $data = $this->__prefixField($this->_prefixTable, $data);
        return $data;
    }

    public function __prefixField($search, $results)
    {
        $data = array();
        foreach ($results as $key => $value) {
            $data[ str_replace($search, '', $key) ] = $value;
        }
        return $data;
    }

    // followed followers
    public static function followedWholesale($id)
    {
        $sth = DB::table("companies_wholesale_permit as permit");
        $sth->leftJoin('wholesales', 'wholesales.id', '=', 'permit.whole_id');
        $sth->select( 'wholesales.*' );
        $sth->where( 'permit.company_id', '=', $id );
        $sth->orderBy( 'sequence', 'asc' );
        return $sth->get();
    }

}

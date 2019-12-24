<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class BlogsCategoryModel extends Model
{
    protected $table = 'blog_category';
    public $primatyKey = 'id';
    public $itemstamps = false;

    protected $fillable = ['name', 'description'];

    private $_findKeyword = ['q', 'status'];
    private $_sort = 'updated_at';
    private $_dir = 'desc';



    public function _conditions(&$options)
    {

        foreach ($this->_findKeyword as $key) {
            if( isset($request->{$key}) ) $options[$key] = $request->{$key};
        }

        $options = array_merge(array(
            'sort' => isset($_REQUEST['sort'])? $_REQUEST['sort']: $this->_sort,
            'dir' => isset($_REQUEST['dir'])? $_REQUEST['dir']: $this->_dir,

            'ts'=> isset($_REQUEST['time'])? $_REQUEST['time']:time(),
        ), $options);


        $params = '';


        return [
            // 'str'=> "{$where} {$groupby} {$having} {$orderby} {$limit}",
            'params' => $params
        ];

    }
    public function _find($ops=array()){

        $ops = array_merge( array(
            'limit' => intval(isset($_REQUEST['limit'])? $_REQUEST['limit']: 5),
            'page' => intval(isset($_REQUEST['page'])? $_REQUEST['page']: 1),
        ), $ops);


        $condition = $this->_conditions( $ops );


        $sth = DB::table($this->table);
        $sth->where( 'cid', '=', Session::get('cid') );


        if( isset($request->q) ){
            $ops['q'] = trim($request->q);

            $sth->where( 'name', 'LIKE', "%{$ops['q']}%" );
        }

        if( isset($request->status) ){
            $ops['status'] = trim($request->status);
            $sth->where( 'status', '=', $ops['status'] );
        }


        dd($ops);


        // return $sth->get();
    }

}

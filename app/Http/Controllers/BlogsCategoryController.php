<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Session;
// use App\Library\Business;

class BlogsCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd($this->_company);


        $cid = Session::get('cid');
        // dd($cid);

        $ops = array(
            'sort' => isset($_GET['sort'])? $_GET['sort']: 'id',
            'dir' => isset($_GET['dir'])? $_GET['dir']: 'asc',


            'limit' => isset($_GET['limit'])? $_GET['limit']: 2,
            'page' => isset($_GET['page'])? $_GET['page']: 1,

            'ts' => time(),
        );



        $results = DB::table('blog_category')

            ->where( 'cid', '=', $cid )
            ->orderby( $ops['sort'], $ops['dir'] )
            ->skip( ($ops['page']*$ops['limit'])- $ops['limit'])
            ->take( $ops['limit'] )
            ->get();


        $arr['total'] = DB::table('blog_category')->count();
        $arr['data'] = $results;
        $arr['options'] = $ops;




        $keys = array();
        $keys[] = array('label'=>'#', 'cls'=>'td-index', 'type'=>'index');
        // $keys[] = array('id'=>'', 'label'=>'', 'cls'=>'td-move', 'type'=>'move');
        // $keys[] = array('id'=>'', 'label'=>'', 'cls'=>'td-checkbox', 'type'=>'checkbox');
        $keys[] = array('id'=>'name', 'label'=>'ชื่อ', 'cls'=>'td-name');
        // $keys[] = array('id'=>'date_at', 'label'=>'วันที่สร้าง', 'cls'=>'td-date');
        $keys[] = array('id'=>'status', 'label'=>'สถานะ', 'cls'=>'td-status', 'type'=>'status');
        $keys[] = array('id'=>'date_at', 'label'=>'วันที่/เวลา', 'cls'=>'td-date');
        $keys[] = array('id'=>'discount', 'label'=>'ส่วนลด', 'cls'=>'td-number td-success', 'type'=>'number');
        $keys[] = array('id'=>'itemsVal', 'label'=>'สินค้าที่ร่วมรายการ', 'cls'=>'td-count', 'type'=>'number');
        $keys[] = array('id'=>'bookVal', 'label'=>'ยอดจอง', 'cls'=>'td-count', 'type'=>'number');


        
        $tr = '';
        $seq = ($ops['page'] * $ops['limit']) - $ops['limit'];

         // header
        if( $ops['page']==1 ){

            $ths = '';
            foreach ($keys as $key => $value) {
                
                $ico = isset($value['icon']) ? '<i class="mr-1 icon-'.$value['icon'].'"></i>':'';
                $cls = isset($value['cls']) ? ' class="'.$value['cls'].'"':'';
                $ths .= '<th'.$cls.'>'.$ico.'<span>'.$value['label'].'</span></th>';
                //  data-col="'.$key.'"
            }
            $tr .= '<tr class="tr-fixed" role="table__fixed">'.$ths.'</tr>';
        }


        // dd($results);
        foreach ($results as $i => $item) {

            $item = json_decode( json_encode($item), 1);

            $tds = '';
            foreach ($keys as $label) {

                $type = isset($label['type'])? $label['type']: 'text';
                $text = '';


                if( $type=='text' ){

                    $text = !empty($item[$label['id']])? $item[$label['id']]: '';
                    $text = '<span ref="'.$label['id'].'">'.$text.'</span>';
                }


                $cls = isset($label['cls']) ? ' class="'.$label['cls'].'"':'';
                $tds .= '<td'.$cls.'>'.$text.'</td>';
            }

            $tr .= '<tr blogs-category-id="'.$item['id'].'">'.$tds.'</tr>';
        }

        $arr['items'] = $tr;
        
        return json_encode($arr);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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

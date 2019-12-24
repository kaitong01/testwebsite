<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogPostRequest;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $tab = basename(Route::getFacadeRoot()->current()->uri);

        $tabs = [
            'blogs' => [
                'title' => 'ทั้งหมด',
            ],
            'posted' => [
                'title' => 'เผยแพร่แล้ว',

                'options' => [
                    'status' => 1
                ]
            ],
            'scheduled' => [
                'title' => 'แบบตั้งเวลา',
            ],
            'draft' => [
                'title' => 'แบบร่าง',
            ],
            'expire' => [
                'title' => 'หมดอายุ',
            ],
            'disabled' => [
                'title' => 'ระงับ',
            ],
        ];

        if( in_array($tab, array_keys($tabs)) ){

            $ops = $tabs[$tab];
            $ops['url'] = '/blogs/find/'.$tab;

            return view('layouts.datatable_tab')->with( BlogController::_init( $request, $ops ) );
        }
        else{
            throw new AuthorizationException('You do not have permission to view this page');
        }
    }

    public function find(Request $request)
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
            if( $request->status!='' ){
                $where[] = ['status', '=', $request->status];
            }
        }

        $where[] = ['company_id', '=', $request->user()->company->id ];


        $results = BlogPost::where($where)

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
        $res['items'] = $this->ui->item('BlogPostDatatable')->init( $res['data'], $res['options'] );

        return response()->json($res, 200);
    }

    public function create(Request $request)
    {
        $statusList = BlogPost::status();
        $categoryList = BlogCategory::where([
            ['status', 1],
            ['company_id', $request->user()->company->id],
        ])->get();

        return view('forms.blogs.post.form', compact('statusList', 'categoryList'));
    }
    public function store(BlogPostRequest $request)
    {
        $data = new BlogPost();
        if( $data->fill( $request->input() )->save() ){

            // update permalink
            if($request->has('permalink')){
                $data->permalink = $this->fn->q('text')->createPermalink($request->permalink);
            }
            else{
                $data->permalink = $this->fn->q('text')->createPermalink($request->name);
            }

            $data->company_id = $request->user()->company->id;

            if($request->has('image')){
                $data->image = $request->file('image')->store( "{$request->user()->company->id}/blogs-posts/" , 'public' );
            }

            $data->update();
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



    public function edit(Request $request, $id)
    {
        $data = BlogPost::findOrFail($id);

        $statusList = BlogPost::status();
        $categoryList = BlogCategory::where([
            ['status', 1],
            ['company_id', $request->user()->company->id],
        ])->get();

        return view('forms.blogs.post.form', compact('data', 'statusList', 'categoryList'));
    }

    public function update(BlogPostRequest $request, $id)
    {
        $data = BlogPost::findOrFail($id);

        if( $data->fill( $request->input() )->save() ){

            // update permalink
            if($request->has('permalink')){
                $data->permalink = $this->fn->q('text')->createPermalink($request->permalink);
            }

            // ลบรูปเดิม
            if(!empty($data->image) && ($request->has('image') || $request->has('image_cancel_file')) ){
                Storage::disk('public')->delete($data->image);
                $data->image = null;
            }

            if($request->has('image')){
                $data->image = $request->file('image')->store( "{$request->company_id}/blogs-posts/" , 'public' );
            }

            $data->update();

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

    public function switch(Request $request)
    {
        $data = BlogPost::findOrFail($request->id);

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


    // set Datatable
    public static function _init ($request, $ops=[] )
    {
        return [
            'title' => 'บทความ',

            'navleft' => BlogController::_leftMenu($request),

            'datatable' => [
                'title' => isset($ops['title'])? $ops['title']: 'ตะกร้า',

                'options' => [
                    'limit' => 24
                ],
                "url" => $ops['url'],

                'filters' => BlogController::_filters( $ops ),
            ],
        ];
    }
    public static function _filters( $ops=[] )
    {

        $ops = array_merge( [
            'status' => 1,
            'state' => '',
        ], $ops );


        $filters = [];

        $filters[] = [
            'position' => 'topLeft',
            'type' => 'searchbox',

            'name' => 'q',
        ];


        $filters[] = [
            'position' => 'topRight',
            'type' => 'button',

            'style' => 'primary',

            'attr' => [
                'data-plugin' => 'lightbox',
                'data-url' => '/blogs/create',
            ],

            'label' => '<svg class="svg-icon o__tiny o__by-text" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"><path d="M2 5v2h3v3h2V7h3V5H7V2H5v3H2z"></path></svg> <span>เพิ่มบทความ</span>'
        ];


        return $filters;
    }
    public static function _leftMenu($request)
    {
        return [
            [
                // "name" => "สถานะ",
                "items" => [
                    [
                        "id"=> "/blogs",
                        "name" => "ทั้งหมด",
                        'count' => BlogPost::
                                where([
                                    ['company_id', $request->user()->company->id]
                                ])
                                ->count()
                    ],
                    [
                        "id"=> "/blogs/posted",
                        "name" => "เผยแพร่แล้ว",
                        'count' => BlogPost::
                            where([
                                ['status', 1],
                                ['company_id', $request->user()->company->id]
                            ])
                            ->count()
                    ],
                    [
                        "id"=> "/blogs/scheduled",
                        "name" => "แบบตั้งเวลา",
                        'count' => BlogPost::
                            where([
                                ['company_id', $request->user()->company->id]
                            ])
                            ->whereNotNull('start_date')
                            ->count()
                    ],
                    [
                        "id"=> "/blogs/expire",
                        "name" => "หมดอายุ",
                        'count' => BlogPost::
                            where([
                                ['status', 1],
                                ['company_id', $request->user()->company->id],
                                ['start_date', '<', date('Y-m-d 00:00:00')]
                            ])
                            ->whereNotNull('start_date')
                            ->count()
                    ],
                    [
                        "id"=> "/blogs/draft",
                        "name" => "แบบร่าง",
                        'count' => BlogPost::
                            where([
                                ['status', 2],
                                ['company_id', $request->user()->company->id]
                            ])
                            ->count()
                    ],



                ]
            ],

            [
                "items" => [
                    [
                        "id"=> "/blogs/disabled",
                        "name" => "ระงับ",
                        'count' => BlogPost::
                            where([
                                ['status', 0],
                                ['company_id', $request->user()->company->id]
                            ])
                            ->count()
                    ],
                ]
            ]
        ];
    }
}

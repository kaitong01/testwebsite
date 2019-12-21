<?php


function tr($seq, $item)
{
    $status = $item['type']==0
        ? '<div class="ui-status">กำหนดเอง</div>'
        : '<div class="ui-status">ค่าเริ่มต้น</div>';

    return '<tr data-id="'.$item['id'].'" data-type="'.$item['type'].'">
        <td class="td-seq">'.$seq.'</td>
        <td class="td-move"><div class="handle fa fa-bars"></div></td>
        <td class="td-name">
            <strong>'.$item['name'].'</strong>
        </td>
        <td class="td-status">'.$status.'</td>
        <td class="td-status">
            <div class="ui-status primary">ใช้งาน</div>
        </td>
        <td class="td-action text-right">
            <div class="d-flex justify-content-end">
                <button type="button" data-action="up" class="btn ml-2"><i class="fa fa-chevron-up"></i></button>
                <button type="button" data-action="down" class="btn ml-2"><i class="fa fa-chevron-down"></i></button>
                <a data-plugin="lightbox" href="'.asset("/site/menu/{$item['id']}/edit").'?type='.$item['type'].'" class="btn ml-2"><i class="fa fa-pencil"></i></a>
            </div>
        </td>
    </tr>';
}

$seq = 1;
$li = ''; $itemsDefaults = [];
foreach ($data['items'] as $item){

    if( $item['type']!=0 ){
        array_push( $itemsDefaults,  $item['type']);
    }
}

$li = '';
foreach ($data['defaults'] as $item){

    if( !in_array($item['id'], $itemsDefaults) && $item['id']!=1 ){
        $item['type'] = $item['id'];
        $item['id'] = 0;

        $seq++;
        $li .= tr( $seq, $item );
    }
}

foreach ($data['items'] as $item){

    if( $item['type']==1 ) continue;
    $seq++;
    $li .= tr( $seq, $item );
}


?><div style="background: linear-gradient(135deg,#e4e6f5,#ecf6ff 39%,#ddecff);background-size: 100% 302px;background-repeat: no-repeat;">
    <div class="business-settings-container" style="margin-left: auto;margin-right: auto">

        <div class="business-settings-header" style="background: transparent">

            <div class="d-flex">
                <div>
                    <h1 class="title">ปรับแต่งเมนูบนเว็บไซต์</h1>
                    {{-- <p class="sub-title"></p> --}}
                </div>
            </div>

            <div class="alert alert-danger mt-4"><h4 class="alert-heading mb-2" style="font-size: 100%; font-weight: bold;">หมายเหตุสำคัญ:</h4> <p>*คุณสามารถ เพิ่มหน้าใหม่ได้ไม่เกิน 5 หน้า</p></div>

        </div>
        <div class="business-settings-body">

            <div  class="business-settings-section">

                <div class="business-settings-section-header">

                    <div class=" d-flex justify-content-between">
                        <div>
                            <h2>เมนู</h2>
                            {{-- <p></p> --}}
                        </div>

                        <button type="button" class="btn btn-primary" data-plugin="lightbox" data-url="{{ asset('/site/menu/create') }}"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" class="svg-icon o__tiny o__by-text"><path d="M2 5v2h3v3h2V7h3V5H7V2H5v3H2z"></path></svg><span class="ml-2">เพิ่มเมนูใหม่</span></button>

                    </div>
                </div>


                <div class="business-settings-section-body">

                    <table class="table table-sitepage" data-plugin="SitePage">
                        <thead>
                            <tr>
                                <th class="td-seq" width="10">#</th>
                                <th class="td-move" width="10"></th>
                                <!-- <th class="td-checkbox"><label class="checkbox"><input type="checkbox" name=""></label></th> -->
                                <th class="td-name">หน้าเว็บไซต์</th>
                                <!-- <th class="td-date">แก้ไขล่าสุด</th> -->
                                <th class="td-status" width="10">ประเภท</th>
                                <th class="td-status" width="10">สถานะ</th>
                                <th class="td-action" width="10"></th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td class="td-seq">1</td>
                                <td class="td-move"></td>
                                <td class="td-name">
                                    <strong>หน้าแรก</strong>
                                </td>
                                <td class="td-status"><div class="ui-status warning">ค่าเริ่มต้น</div></td>
                                <td class="td-status">
                                    <div class="ui-status primary">ใช้งาน</div>
                                </td>
                                <td class="td-action text-right">
                                    <a data-plugin="lightbox" href="{{ asset("/site/menu/index/edit") . '?type=1' }}" class="btn ml-2"><i class="fa fa-pencil"></i></a>
                                </td>
                            </tr>
                        </tbody>

                        <tbody class="table-listbox" role="listbox"><?=$li?></tbody>

                    </table>

                </div>

            </div>


        </div>
        {{-- end business-settings-body --}}
    </div>
</div>


@section('footer_scripts')
    <script src="{{ asset('/js/plugins/dragula.js') }}"></script>
@endsection

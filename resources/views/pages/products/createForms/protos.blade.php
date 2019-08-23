<?php

$gallery = array();

if( !empty($data['gallery']) ){

    $dataGallery = json_decode($data['gallery'], 1);
    // dd( $dataGallery );
    // dd( json_decode($data['gallery'], 1) );
    if(  !empty($dataGallery) ){

        foreach ($dataGallery as $key => $value) {

            // $dGallery = array(
            //     'name' => isset($value['caption'])? $value['caption']: '', $value['name'],
            //     'caption' => isset($value['caption'])? $value['caption']: '',
            //     'id' => isset($value['id'])? $value['id']: $key
            // );
            if( !isset($value['id']) ){
                $value['id'] = $key;
            }

            if( !empty($value['path']) ){
                $value['src'] = asset("storage/{$value['path']}");

            } else if( isset($value['url']) ){
                $value['src'] = $value['url'];
            }

            $gallery[] = $value;
        }
    }
}


?><div class="business-settings-section" data-plugin="seriesProtosForm" data-options="<?=htmlentities(json_encode(array(
    'data'=> $gallery
)))?>">

    <div class="business-settings-section-header">
        <h2>รูปภาพ</h2>
    </div>

    <div class="business-settings-section-body">

            <div id="item_hotels_fieldset" class="control-group">
                <div class="controls">
                    <table class="table-period-form d-none">
                        <thead>
                            <tr>
                                <th class="td-index">#</th>
                                <th>รูป</th>
                                <th class="data-action text-right">
                                    <button type="button" class="btn btn-primary btn-choosefile btn-sm"><span class="d-flex align-items-center"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"><path d="M2 5v2h3v3h2V7h3V5H7V2H5v3H2z"></path></svg><span class="ml-2">อัปโหลดเพิ่ม</span></span><input type="file" accept="image/jpeg,image/png"  multiple="1"></button></th>
                            </tr>
                        </thead>

                        <tbody role="listsbox"></tbody>
                    </table>
                    <div class="dropzone-container" role="dropzone">
                        <div class="toggle-dropzone-upload" style="height: 350px">

                            <div class="h-100 d-flex justify-content-center align-items-center">
                                <div class="p-2 text-center">
                                    <h3 class="mb-1">เพิ่มรูปภาพ</h3>
                                    <p>ลากไฟล์แล้ววางหรืออัปโหลดจากคอมพิวเตอร์ของคุณ</p>
                                    <button type="button" class="mt-2 btn btn-outline-primary" data-action="upload"><span class="d-flex align-items-center"><svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 12L12 6 11 6 11 12 5 12 5 13 11 13 11 19 12 19 12 13 18 13 18 12z"></path></svg><span>อัปโหลด</span></span></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="notification"></div>
                </div>
            </div>

        </div>

</div>

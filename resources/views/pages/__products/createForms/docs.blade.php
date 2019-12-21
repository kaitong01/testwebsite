<div class="business-settings-section">

    <div class="business-settings-section-header">
        <h2>ไฟล์</h2>
        <p class="desc">อัปโหลดไฟล์เอกสาร Word และ PDF</p>

    </div>


    <div class="business-settings-section-body">


            <div id="files_fieldset" class="control-group">
                <div class="controls">
                    <table class="table-period-form">
                        <thead>
                            <tr>
                                <th colspan="2">ชื่อ</th>
                                <th style="width:10px"></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php

                            $filesOps = array();
                            $filesOps[] = ['label'=>'ยังไม่ได้เลือกไฟล์', 'key'=>'word', 'accept'=>'application/msword,.doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.documen', 'icon'=>'<i class="fa fa-file-word-o" style="font-size: 50px;color: #007bff"></i>'];
                            $filesOps[] = ['label'=>'ยังไม่ได้เลือกไฟล์', 'key'=>'pdf', 'accept'=>'application/pdf', 'icon'=>'<i class="fa fa-file-pdf-o" style="font-size: 50px;color: #dc3545;"></i>'];




                            ?>

                            @foreach ($filesOps as $i => $item)

                            <?php

                            $file_id = '';
                            if( !empty( $data->files ) ){

                                $_files = json_decode($data->files, 1);
                                // dd($_files);

                                if( !empty($_files) ){

                                    foreach ($_files as $key => $value) {
                                        $file_id = isset($value['id'])? $value['id']: $key;


                                        if( $value['key']==$item['key'] ){

                                            if( !empty($value['path']) ){
                                                $item['src'] = asset("storage/{$value['path']}");

                                                $item['path'] = $value['path'];
                                            }
                                            elseif( !empty($value['url']) ){
                                                $item['src'] = $value['url'];
                                            }

                                            if( !empty($value['name']) ){
                                                $item['name'] = $value['name'];
                                            }
                                        }
                                    }
                                }
                                // {{-- $ops['data'] = asset( "storage/{$data->file_word}" ); --}}
                            }



                            // dd($item);
                            ?>
                            <tr data-plugin="seriesFilesForm" data-options="<?=htmlentities(json_encode($item))?>">
                                <td style="width: 10px"><div class="pl-2 py-3">{!!$item['icon']!!}</div></td>
                                <td class="pl-3">

                                    <div class="d-flex align-items-center">
                                        <button type="button" class="btn btn-primary btn-choosefile btn-sm"><span class="d-flex align-items-center"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"><path d="M2 5v2h3v3h2V7h3V5H7V2H5v3H2z"></path></svg><span class="ml-2">อัปโหลด</span></span><input type="file" name="docs[{{$i}}][upload]" accept="{{$item['accept']}}"></button>

                                        <strong class="ml-2" role="label">{{$item['label']}}</strong>
                                    </div>

                                    <input type="hidden" role="name" name="docs[{{$i}}][name]" value="{{isset($item['name'])?$item['name']:''}}" autocomplete="off" />

                                    <input disabled type="hidden" role="remove" name="docs[{{$i}}][remove]" value="1" autocomplete="off" />
                                    <input type="hidden" name="docs[{{$i}}][key]" value="{{$item['key']}}" autocomplete="off" />

                                </td>

                                <td class="text-right" style="white-space: nowrap;">


                                        <?php
                                        if( !empty($item['src']) ){
                                            echo '<a class="btn btn btn-sm btn-light ml-1" href="'.$item['src'].'" target="_blank" title="ดาวน์โหลดไฟล์" role="download"><i class="fa fa-download"></i> ดาวน์โหลด</a>';

                                            echo '<button data-action="undo" type="button" title="ใช้รูปเดิม" tabindex="-1" class="btn ml-1 btn btn-sm btn-light d-none"><i class="fa fa-refresh"></i> ใช้ไฟล์เดิม</button>';
                                        }
                                        ?>


                                        <button data-action="remove" type="button" title="ลบไฟล์" tabindex="-1" class="btn btn-sm btn-light ml-1 d-none"><i class="fa fa-remove"></i> ลบ</button>





                                </td>

                            </tr>

                            @endforeach

                        </tbody>
                    </table>

                    <div class="notification"></div>
                </div>
            </div>

        </div>

</div>

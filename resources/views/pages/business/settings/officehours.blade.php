<form action="/business/update/officehours" method="post" data-plugin="formSubmit" class="business-settings-section">
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="PUT" autocomplete="off" >

    <div class="business-settings-section-header">
        <h2>เวลาทำการ</h2>
    </div>
    <div class="business-settings-section-body">

        <?php

        $items = array();
        $items[] = array('id'=>1, 'name'=>'เปิดทำการทุกวัน');
        $items[] = array('id'=>2, 'name'=>'เปิดทำการเฉพาะช่วงเวลา');
        $items[] = array('id'=>0, 'name'=>'ไม่มีเวลาทำการ');

        $officehoursActive = !empty( $item->officehours )? $item->officehours: 0;

        $li = '';
        foreach ($items as $key => $value) {

            $active =$officehoursActive==$value['id'] ? ' checked=""':'';
            $li .= '<li><label class="radio"><input type="radio" name="officehours" value="'.$value['id'].'" data-action="check"'.$active.'><span class="ml-2">'.$value['name'].'</span></label></li>';
        }


        ?>

        <div class="form-insert form-vertical">
            <div class="row">
                <div class="col-sm-6 mbl">
                    <div class="officehours-wrap" data-plugin="officehours">
                       <fieldset id="officehours_fieldset" class="control-group">
                            <ul><?=$li?></ul>

                            <div class="officehours-content mt-4 d-none" role="content">
                            <?php

                            $days = array();
                            $days[] = array('id'=>1, 'name'=>'วันจันทร์', 'times' => array());
                            $days[] = array('id'=>2, 'name'=>'วันอังคาร', 'times' => array());
                            $days[] = array('id'=>3, 'name'=>'วันพุธ', 'times' => array());
                            $days[] = array('id'=>4, 'name'=>'วันพฤหัสบดี', 'times' => array());
                            $days[] = array('id'=>5, 'name'=>'วันศุกร์', 'times' => array());
                            $days[] = array('id'=>6, 'name'=>'วันเสาร์', 'times' => array());
                            $days[] = array('id'=>7, 'name'=>'วันอาทิตย์', 'times' => array());



                            function tableOfficehoursTimes($id, $index, $disabled, $data=null)
                            {

                                $start = !empty($data[0])? $data[0]: '';
                                $end = !empty($data[1])? $data[1]: '';

                                return '<tr>
                                    <td><input type="text" class="form-control" data-plugin="clockTimePicker" aria-id="start" name="officehours_days['.$id.']['.$index.'][]"'.($disabled? ' disabled':' value="'.$start.'"').'></td>
                                    <td>–</td>
                                    <td><input type="text" class="form-control" data-plugin="clockTimePicker" aria-id="end" name="officehours_days['.$id.']['.$index.'][]"'.($disabled? ' disabled':' value="'.$end.'"').'></td>
                                </tr>';

                                // {{-- <td class="td-action">
                                        // <div class="pl-2 d-flex">
                                        //                         <button disabled class="btn" data-action="remove"><i class="fa fa-remove"></i></button>

                                        //                         <button disabled class="btn ml-1" data-action="add" title="เพิ่มเวลาทำการ"><i class="fa fa-plus"></i></button>
                                        //                     </div>
                                        //                 </td> --}}
                            }

                            ?>
                            <table class="table-officehours">
                                <tbody class="">
                                    <?php


                                    $officehours_days = !empty( $item->officehours_days )?json_decode($item->officehours_days, 1): array();

                                    // dd($officehours_days);

                                    foreach ($days as $key => $value) {

                                        $times = array();
                                        $disabled = true;
                                        if( !empty( $officehours_days ) ){

                                            // dd(array_keys($officehours_days));

                                            if( in_array($value['id'], array_keys($officehours_days)  ) ){
                                                $disabled = false;

                                                $times = $officehours_days[$value['id']];
                                            }

                                        }
                                    ?>
                                    <tr>
                                        <td class="td-name">

                                            <label class="checkbox"><input data-action="checkbox" type="checkbox" name="officehours_day"<?=$disabled? '':' checked'?>><span class="ml-2"><?=$value['name']?></span></label>

                                        </td>
                                        <td>

                                            <table class="table-officehours-times">
                                                <body><?php

                                                    if( !empty($times) ){
                                                        foreach ($times as $val) {

                                                            echo tableOfficehoursTimes($value['id'], $key, $disabled, $val);
                                                        }

                                                    }
                                                    else{
                                                        echo tableOfficehoursTimes($value['id'], $key, $disabled);
                                                    }

                                                ?></body>
                                            </table>
                                        </td>

                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>

                            <div class="notification"></div>
                        </fieldset>

                    </div>

                </div>
            </div>

        </div>


    </div>
    <div class="business-settings-section-footer d-flex justify-content-between">
        <div></div>
        <div>
            <button type="submit" class="btn btn-primary btn-submit">บันทึก</button>
        </div>
    </div>
</form>

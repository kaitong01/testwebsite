<?php

$seriesMealsForm = '<div data-plugin="seriesMealsForm" data-options="'.htmlentities(json_encode(array(
    'data'=> !empty($series->meals)? json_decode($series->meals, 1): []
))).'">


    <div id="meals_fieldset" class="control-group">
        <div class="controls">

            <table class="table-period-form" style="    width: auto;">
                <thead>
                    <tr>
                        <th class="td-index">วันที่</th>
                        <th class="td-checkbox">เช้า</th>
                        <th class="td-checkbox">เที่ยง</th>
                        <th class="td-checkbox">เย็น</th>
                        <th class="td-action"></th>
                    </tr>
                </thead>

                <tbody role="listsbox"></tbody>
            </table>

            <div class="notification"></div>
        </div>
    </div>

    <div id="meals_note_fieldset" class="control-group">
        <label for="meals_note" class="control-label">หมายเหตุ</label>
        <div class="controls">
        <textarea id="meals_note" autocomplete="off" class="form-control" name="meals_note" rows="2" data-plugin="autosize">'.( $series->meals_note ?? '' ).'</textarea>
            <div class="notification"></div>
        </div>
    </div>

</div>';

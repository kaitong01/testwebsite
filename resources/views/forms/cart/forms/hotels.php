<?php

$seriesHotelsForm = '<div data-plugin="seriesHotelsForm" data-options="'. htmlentities(json_encode(array(
    'data'=> !empty($series->hotels)? json_decode($series->hotels, 1): []
))).'">
    <div id="hotels_fieldset" class="control-group">
        <div class="controls">
            <table class="table-period-form">
                <thead>
                    <tr>
                        <th class="td-index">คืนที่</th>
                        <th>โรงแรมและที่พัก</th>
                        <th>ระดับ</th>
                        <th class="td-action"></th>
                    </tr>
                </thead>

                <tbody role="listsbox"></tbody>
            </table>

            <div class="notification"></div>
        </div>
    </div>

    <div id="hotels_note_fieldset" class="control-group">
        <label for="hotels_note" class="control-label">หมายเหตุ</label>
        <div class="controls">
            <textarea id="hotels_note" autocomplete="off" class="form-control" name="hotels_note" rows="2" data-plugin="autosize">'.( $series->hotels_note ?? '' ).'</textarea>
            <div class="notification"></div>
        </div>
    </div>

</div>';

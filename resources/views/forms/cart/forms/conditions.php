<?php

$conditions = '<div id="conditions_fieldset" class="control-group">
    <div class="controls">
        <textarea id="conditions" autocomplete="off" class="form-control" name="conditions" data-plugin="autosize" placeholder="เพิ่มข้อจำกัดหรือหมายเหตุ สำหรับการท่องเที่ยวหรือการจอง..." rows="10">'.( $series->conditions ?? '' ).'</textarea>
        <div class="notification"></div>
    </div>
</div>';

<?php

$periodsForm = '<div data-plugin="seriesPeriodsForm" data-options="'.htmlentities(json_encode([
    'period_days'=> 4,
    'data'=> !empty($periods)? $periods: []

])).'">

    <div id="periods_fieldset" class="control-group">
        <div class="controls">
            <table class="table-period-form" role="listsbox">
                <thead>
                    <tr>
                        <th class="td-index">#</th>
                        <th class="text-center" colspan="2">วันที่เดินทาง</th>
                        <th class="td-number td-light text-center" style="padding-left:8px">ราคาผู้ใหญ่</th>
                        <th class="td-number td-light text-center">ราคาเด็ก (ไม่มีเตียง)</th>
                        <th class="td-status" style="padding-left:15px">สถานะ</th>
                        <th class="td-action" style="padding-left:15px"></th>
                    </tr>
                </thead>

            </table>

            <div class="notification"></div>
        </div>
    </div>

    <div id="periods_note_fieldset" class="control-group">
        <label for="periods_note" class="control-label">หมายเหตุ</label>
        <div class="controls">
            <textarea id="periods_note" autocomplete="off" class="form-control" name="periods_note"></textarea>
            <div class="notification"></div>
        </div>
    </div>

</div>';

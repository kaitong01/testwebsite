<div class="business-settings-section">

    <div class="business-settings-section-header">
        <h2>เงื่อนไข</h2>
        <p class="desc">ข้อจำกัดหรือหมายเหตุ สำหรับการท่องเที่ยวหรือการจอง</p>
    </div>

    <div class="business-settings-section-body">

        <div id="conditions_fieldset" class="control-group">
            <div class="controls">
                <textarea id="conditions" autocomplete="off" class="form-control" name="conditions" data-plugin="autosize" rows="5">{{ isset($data['conditions'])? strip_tags( $data['conditions']):'' }}</textarea>
                <div class="notification"></div>
            </div>
        </div>

    </div>
</div>

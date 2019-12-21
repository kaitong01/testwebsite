<div class="business-settings-section">

    <div class="business-settings-section-header">
        <h2>SEO</h2>
        <p class="desc">ปรับแต่งทัวร์คุณให้ติดอันดับบนเครื่องมือการค้นหา</p>
    </div>

    <div class="business-settings-section-body">

        <div class="form-insert form-vertical">
            <div id="seo_title_fieldset" class="control-group">
                <label for="seo_title" class="control-label">ใส่ชื่อเพจที่จะให้แสดงในผลการค้นหาหรือบนแท็บบราวเซอร์ (70 ตัวอักษร)</label>

                <div class="controls"><input id="seo_title" class="form-control input-seo input-title-seo" autocomplete="off" maxlength="70" value="{{ $data->seo_title ?? '' }}" type="text" name="seo_title">

                    <div class="notification"></div>
                </div>
            </div>

            <div id="seo_description_fieldset" class="control-group">
                <label for="seo_description" class="control-label">เพจนี้เกี่ยวกับอะไร เพิ่มคำบรรยายเพจ (320 ตัวอักษร)</label>
                <div class="controls">
                    <textarea id="seo_description" class="form-control input-seo input-content-seo" autocomplete="off" maxlength="320" name="seo_description" data-plugin="autosize">{{ $data->seo_description ?? '' }}</textarea>
                    <div class="notification"></div>
                </div>
            </div>

            <div id="permalink_fieldset" class="control-group">
                <label for="permalink" class="control-label">ใส่ URL เพจของคุณ</label>

                <div class="controls">
                    <div class="seourl-wrap d-flex justify-content-between align-items-center">
                        <div class="seourl-base">/tours/</div>
                        <div class="seourl-input"><input id="permalink" class="form-control input-seo input-url-seo" autocomplete="off" type="text" name="permalink" value="{{ $data->permalink ?? '' }}"></div>
                    </div>
                    <div class="notification"></div>
                </div>
            </div>

            <div class="control-google-preview" ref="preview"><div class="header">ดูตัวอย่างบน Google</div><div class="preview"><div class="preview-content"><div class="title"></div><div class="url"></div><div class="description"></div></div></div></div></div>
    </div>

</div>

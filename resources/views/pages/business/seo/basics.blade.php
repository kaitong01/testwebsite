<?php

$Fn = new Fn;

?><form action="/business/update/seo" method="post" data-plugin="formSubmit" class="business-settings-section">
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="PUT" autocomplete="off" >
    <div class="business-settings-section-header">
        <h2>ข้อมูลทั่วไป</h2>
    </div>
    <div class="business-settings-section-body">

        <div class="form-insert form-vertical" data-plugin="BusinessSeo">

            <div class="row">
                <div class="col-sm-6 mbl">
                    <fieldset id="seo_title_fieldset" class="control-group"><label for="seo_title" class="control-label">Title</label><div class="controls"><input id="seo_title" autocomplete="off" class="form-control" maxlength="75" value="{!!$item->seo_title!!}" type="text" name="seo_title"><div class="notification"></div></div></fieldset>

                    <fieldset id="seo_description_fieldset" class="control-group"><label for="seo_description" class="control-label">Description</label><div class="controls"><textarea id="seo_description" autocomplete="off" class="form-control" rows="5" data-plugin="autosize" name="seo_description" maxlength="320">{!!$item->seo_description!!}</textarea><div class="notification"></div></div></fieldset>

                    {{-- <fieldset id="seo_keywords_fieldset" class="control-group"><label for="seo_keywords" class="control-label">Keywords</label><div class="controls"><input id="seo_keywords" autocomplete="off" value="{!!$item->seo_keywords!!}" type="text" name="seo_keywords"><div class="notification"></div></div></fieldset> --}}
                </div>

                <div class="col-sm-6 mbl">

                    <div class="control-google-preview" role="preview"><div class="header">ตัวอย่างบน Google</div>
                        <div class="preview">
                            <div class="preview-content">
                                <div class="title">{!!$item->seo_title!!}</div>
                                <div class="url">https://www.{!!$item->domain!!}/</div>
                                <div class="description">{!!$item->seo_description!!}</div>
                            </div>
                        </div>
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

<form action="/business/update/settings" method="post" data-plugin="formSubmit" class="business-settings-section">
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="PUT" autocomplete="off" >
    <div class="business-settings-section-header">
        <h2>โปรไฟล์</h2>
    </div>
    <div class="business-settings-section-body">

        <div class="form-insert form-vertical">

            <div class="row">
                <div class="col-sm-6 mbl">
                <fieldset id="name_fieldset" class="control-group"><label for="name" class="control-label">ชื่อธุรกิจหรือเว็บไซต์*</label><div class="controls"><input id="name" autocomplete="off" class="form-control" maxlength="75" placeholder="กรอกชื่อธุรกิจหรือเว็บไซต์" aria-label="required" value="{!!$item->name!!}" type="text" name="name"><div class="notification"></div></div></fieldset>


                    <fieldset id="logo_fieldset" class="control-group">
                        <label for="logo" class="control-label">โลโก้</label>
                        <div class="controls">
                            <div class="row drop-image-wrap" data-plugin="image_once" data-url="<?= !empty($item->logo) ? asset("storage/{$item->logo}"): ''; ?>">
                                <div class="col-auto">
                                    <div class="drop-image">
                                        <div class="preview" role="preview"></div>
                                        <div class="drop" data-action="drop"><svg viewBox="0 0 31 31" fill="currentColor" width="31" height="31" data-hook="additem-icon"><path d="M15 15H0v1h15v15h1V16h15v-1H16V0h-1z"></path></svg></div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="text-muted mb-2">*ขนาด 150x150px, ไม่เกิน 25 MB</div>
                                    <button type="button" class="btn btn-primary btn-choosefile"><span class="btn-text">อัพโหลดโลโก้</span><input type="file" name="logo" accept="image/jpeg,image/png"></button><button class="drop-image-cancel" type="button" data-action="remove">ยกเลิก</button>
                                </div>
                            </div>
                            <div class="notification"></div>
                        </div>
                    </fieldset>
                </div>

                <div class="col-sm-6 mbl">

                    {{-- <fieldset id="hotline_type_fieldset" class="control-group" style="float: left;margin-right: 10px;"><label for="hotline_type" class="control-label">Hotline*</label><div class="controls"><select id="hotline_type" class="form-control" name="hotline_type"><option value="0">Phone</option><option value="1">Facebook</option><option value="2">Line</option></select><div class="notification"></div></div></fieldset> --}}

                    <fieldset id="hotline_fieldset" class="control-group"><label for="hotline" class="control-label">Hotline</label><div class="controls"><input id="hotline" autocomplete="off" class="form-control" maxlength="30" value="{!!$item->hotline!!}" type="text" name="hotline"><div class="notification"></div></div></fieldset>


                    <fieldset id="description_fieldset" class="control-group"><label for="description" class="control-label">คำบรรยายที่เกี่ยวกับธุรกิจหรือเว็บไซต์</label><div class="controls"><textarea id="description" autocomplete="off" class="form-control" rows="5" data-plugin="autosize" name="description">{!!$item->description!!}</textarea><div class="notification"></div></div></fieldset>
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

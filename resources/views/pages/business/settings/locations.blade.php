<form action="/business/update/locations" method="post" data-plugin="formSubmit" class="business-settings-section">
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="PUT" autocomplete="off" >

    <div class="business-settings-section-header">
        <h2>ที่อยู่</h2>
    </div>
    <div class="business-settings-section-body">


        <div class="form-insert form-vertical">
            <div class="row">
                <div class="col-sm-6 mbl">


                    <fieldset id="location_address_fieldset" class="control-group">
                        <label for="location_address" class="control-label">ที่อยู่/ถนน</label>
                        <div class="controls">
                        <textarea id="location_address" autocomplete="off" class="form-control" rows="1" data-plugin="autosize" name="location_address">{!!$item->location_address!!}</textarea>
                            <div class="notification"></div></div>
                    </fieldset>

                    <div class="row">
                        <fieldset id="location_district_fieldset" class="control-group col">
                            <label for="location_district" class="control-label">ตำบล/แขวง</label>

                            <div class="controls">
                                <input id="location_district" autocomplete="off" class="form-control" aria-label="ตำบล/แขวง" placeholder="" value="{!!$item->location_district!!}" type="text" name="location_district">
                                <div class="notification"></div></div>
                        </fieldset>


                        <fieldset id="location_city_fieldset" class="control-group col">
                            <label for="location_city" class="control-label">อำเภอ/เขต</label>

                            <div class="controls">
                                <input id="location_city" autocomplete="off" class="form-control" aria-label="อำเภอ/เขต" placeholder="" value="{!!$item->location_city!!}" type="text" name="location_city">
                                <div class="notification"></div></div>
                        </fieldset>
                    </div>

                    <div class="row">
                        <fieldset id="location_province_fieldset" class="control-group col">
                            <label for="location_province" class="control-label">จังหวัด</label>

                            <div class="controls">
                                <input id="location_province" autocomplete="off" class="form-control" aria-label="จังหวัด" placeholder="" value="{!!$item->location_province!!}" type="text" name="location_province">
                                <div class="notification"></div></div>
                        </fieldset>

                        <fieldset id="location_zip_fieldset" class="control-group col">
                            <label for="location_zip" class="control-label">รหัสไปรษณีย์</label>
                            <div class="controls">
                                <input id="location_zip" autocomplete="off" class="form-control" aria-label="รหัสไปรษณีย์" placeholder="" value="{!!$item->location_zip!!}" type="text" name="location_zip">
                                <div class="notification"></div></div>
                        </fieldset>

                        <fieldset id="location_country_fieldset" class="control-group col">
                            <label for="location_country" class="control-label">ประเทศ/ภูมิภาค</label>

                            <div class="controls">
                                <input id="location_country" autocomplete="off" class="form-control disabled" value="ไทย"  aria-label="ประเทศ" type="text" name="location_country" disabled>
                                <div class="notification"></div></div>
                        </fieldset>
                    </div>


                </div>

                {{-- <div class="col-sm-6 mbl">

                    <fieldset id="location_image_fieldset" class="control-group">
                        <label for="location_image" class="control-label">แนบรูปแผนที่</label>

                        <div class="controls">
                            <div class="row drop-image-wrap" data-plugin="image_once" data-url="!empty($item->location_image) ? asset("storage/{$item->location_image}"): '';">
                                <div class="col-auto">
                                    <div class="drop-image" style="width:300px;height: 180px">
                                        <div class="preview" role="preview"></div>
                                        <div class="drop" data-action="drop"><svg viewBox="0 0 31 31" fill="currentColor" width="31" height="31" data-hook="additem-icon"><path d="M15 15H0v1h15v15h1V16h15v-1H16V0h-1z"></path></svg></div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="text-muted mb-2">*ขนาด 300x220px, ไม่เกิน 25 MB</div>
                                    <button type="button" class="btn btn-primary btn-choosefile"><span class="btn-text">อัพโหลด</span><input type="file" name="location_image" accept="image/jpeg,image/png"></button><button class="drop-image-cancel" type="button" data-action="remove">ยกเลิก</button>
                                </div>
                            </div>

                            <div class="notification"></div>

                        </div>
                    </fieldset>
                </div> --}}
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

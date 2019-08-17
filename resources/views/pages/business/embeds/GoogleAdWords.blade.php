<form action="/business/update/google_ads" method="post" data-plugin="formSubmit" class="business-settings-section">
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="PUT" autocomplete="off" >
    <div class="business-settings-section-header">
        <h2>Google Ads</h2>
        <p>Google Ads Remarketing เป็นเครื่องมือการตลาดที่จะช่วยแสดงซ้ำโฆษณาให้ผู้เข้าชมที่เคยเข้าเว็บของคุณ ด้วยเครื่องมือชุดนี้จะทำให้คุณสามารถระบุกลุ่มลูกค้าเดิมเพื่อแสดงโฆษณาขณะที่พวกเขาเปิดใช้งานโปรแกรมค้นหาบนมือถือหรือค้นหาจาก Google</p>
    </div>
    <div class="business-settings-section-body">

        <div class="alert alert-info">
                <div><strong style="font-size: 100%;font-weight: bold">หมายเหตุ:</strong> การใช้งานฟีเจอร์นี้คุณต้องมีเว็บไซต์ที่เชื่อมต่อกับโดเมนเรียบร้อยแล้ว</div>
        </div>
        <div class="form-insert form-vertical">

            <div class="row">
                <div class="col-sm-6 mbl">
                    <fieldset id="google_conversion_id_fieldset" class="control-group"><label for="google_conversion_id" class="control-label">Google Conversion ID</label><div class="controls"><input id="google_conversion_id" autocomplete="off" class="form-control" maxlength="75" value="{!!$item->google_conversion_id!!}" type="text" name="google_conversion_id"><div class="notification"></div></div></fieldset>


                </div>

            </div>
        </div>

        <div class="alert alert-success mt-4 components-viewer">
            <h4 class="alert-heading mb-2" style="font-size: 100%;font-weight: bold">ขั้นตอนที่ 1 | เรียกใช้งานหมายเลขแท็ก Google Ads :</h4>
            <ol>
                    <li>ลงชื่อเข้าใช้บัญชี Google Ads ของคุณ</li>
                    <li><a href="https://support.google.com/google-ads/answer/2476688?hl=en" target="_blank" class="in-cell-link">เพื่อรับรหัส Google Ads กรุณาปฏิบัติตามคำแนะนำที่ปรากฏที่นี่</a></li>
                    <li>คัดลอกรหัส Conversion ID ที่อยู่ถัดจาก google_conversion_id</li>
                    <li>คลิกสำเร็จ</li>
                </ol>

                <hr>
            <h4 class="alert-heading my-2" style="font-size: 100%;font-weight: bold">ขั้นตอนที่ 2 | ติดตั้ง Google Ads Tag ในเว็บไซต์:</h4>
            <ol>

                <li>วางหมายเลข Google Ads code. ในช่องข้อความ <label for="google_conversion_id"><strong>Google Conversion ID</strong> ด้านบน</label></li>

                <li>คลิก "เชื่อมต่อ Google Ads"</li>
            </ol>
        </div>

        <div class="alert alert-success mt-4">
            <h4 class="alert-heading mb-2" style="font-size: 100%;font-weight: bold">เคล็ดลับ:</h4>
            <ul class="uiListStandard">
                <li><a href="https://support.google.com/analytics/answer/2444872" target="_blank" class="in-cell-link">คลิกที่นี่เพื่อศึกษาเพิ่มเติมเกี่ยวกับการใช้งาน Google Analytics tag สำหรับการลงโฆษณา</a></li>
                <li><a href="https://support.google.com/google-ads/answer/2454000" target="_blank" class="in-cell-link">คลิกที่นี่เพื่อศึกษาเพิ่มเติมเกี่ยวกับการสร้าง Remarketing list</a></li>
            </ul>
        </div>


    </div>
    <div class="business-settings-section-footer d-flex justify-content-between">
        <div></div>
        <div>
            <button type="submit" class="btn btn-primary btn-submit">เชื่อมต่อ Google Ads</button>
        </div>
    </div>
</form>

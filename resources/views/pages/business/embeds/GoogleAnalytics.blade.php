<form action="/business/update/google_analytics" method="post" data-plugin="formSubmit" class="business-settings-section">
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="PUT" autocomplete="off" >
    <div class="business-settings-section-header">
        <h2> Google Analytics</h2>
        <p>Google Analytics ช่วยให้คุณรับทราบข้อมูลการใช้งานของผู้เข้าชมเว็บไซต์ผ่านการติดตามจำนวนผู้เข้าชมและจำนวนการเข้าชมเพจ ผู้เข้าชมเว็บมาจากไหนและอยู่บนเว็บไซต์คุณนานเท่าไหร่ เขาใช้คีย์เวิร์ดอะไรเพื่อค้นหาเว็บคุณ และอื่นๆ อีกมากมาย</p>
    </div>
    <div class="business-settings-section-body">


            <div class="alert alert-info">
                    <div><strong style="font-size: 100%;font-weight: bold">หมายเหตุ:</strong> การใช้งานฟีเจอร์นี้คุณต้องมีเว็บไซต์ที่เชื่อมต่อกับโดเมนเรียบร้อยแล้ว</div>
            </div>

            {{-- เพื่อใช้งานฟีเจอร์นี้คุณต้องมีเว็บไซต์ที่สมัครแพ็กเกจ Premium และ เชื่อมต่อโดเมนเรียบร้อยแล้ว

                    https://www.youtube.com/watch?v=Nnp0EE7yblM
                    --}}
        <div class="form-insert form-vertical">

            <div class="row">
                <div class="col-sm-6 mbl">
                    <fieldset id="google_analytics_id_fieldset" class="control-group"><label for="google_analytics_id" class="control-label">Google Analytics Tracking ID</label><div class="controls"><input id="google_analytics_id" autocomplete="off" class="form-control" maxlength="75" value="{!!$item->google_analytics_id!!}" type="text" name="google_analytics_id"><div class="notification"></div></div></fieldset>


                </div>

                {{-- <div class="col-sm-6 mbl"></div> --}}

            </div>
        </div>

        <div class="alert alert-success mt-4 components-viewer">
            <h4 class="alert-heading my-2" style="font-size: 100%;font-weight: bold">ขั้นตอนที่ 1 | เรียกใช้รหัส Google Analytics :</h4>
            <ol>
                <li>ลงชื่อเข้าใช้บัญชี <a href="http://www.google.com/analytics/" target="_blank">Google Analytics</a> ของคุณ</li>
                <li>คลิกไอคอน <strong>Admin </strong>ที่มุมซ้ายล่างของหน้าเพจ</li>

                <li>ไปที่ <strong>Property </strong>แล้วคลิก <strong>รหัสติดตาม</strong>&nbsp;</li>
                <li>คัดลอกรหัสติดตาม</li>
            </ol>

            <hr>
            <h4 class="alert-heading my-2" style="font-size: 100%;font-weight: bold">ขั้นตอนที่ 2 | ติดตั้งรหัส Google Analytics ในเว็บไซต์:</h4>
            <ol>

                <li>นำรหัสติดตาม วางลงไปในช่องข้อความ <label for="google_analytics_id"><strong>Google Analytics Tracking ID</strong></label> <br><strong>หมายเหตุ: </strong>กรุณาตรวจสอบเพื่อความแน่ใจว่าคุณไม่ได้เว้นวรรคก่อนอักษรตัวแรกของรหัส</li>

                <li>คลิก "เชื่อมต่อ Google Analytics"</li>
            </ol>

        </div>


    </div>
    <div class="business-settings-section-footer d-flex justify-content-between">
        <div></div>
        <div>
            <button type="submit" class="btn btn-primary btn-submit">เชื่อมต่อ Google Analytics</button>
        </div>
    </div>
</form>

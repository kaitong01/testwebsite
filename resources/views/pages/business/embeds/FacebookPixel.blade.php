<form action="/business/update/facebook_pixel" method="post" data-plugin="formSubmit" class="business-settings-section">
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="PUT" autocomplete="off" >
    <div class="business-settings-section-header">
        <h2>Facebook Pixel</h2>
        <p>Facebook Pixel เป็นเครื่องมือทางการตลาดของ Facebook ซึ่งสามารถใช้งานเพื่อติดตามอัตราการเข้าชมเว็บและเพื่อกำหนดกลุ่มเป้าหมายโฆษณาจากกลุ่มผู้เข้าชมที่เคยใช้งานเว็บไซต์ของคุณมาก่อน </p>

        <p>คุณสามารถเพิ่ม Facebook Pixel เพื่อติดตามการใช้งานต่อไปนี้:</p>
        <ul class="uiListStandard"><li>เมื่อผู้เข้าชมเว็บเข้าไปดูสินค้าที่หน้าเพจ</li><li>เมื่อผู้เข้าชมเว็บเพิ่มสินค้าไปยังตะกร้าสินค้าของเขา</li><li>เมื่อผู้เข้าชมเว็บซื้อสินค้าและชำระเงินที่หน้าเว็บของคุณ</li><li>จำนวนเงินทั้งหมดที่ผู้เข้าชมเว็บใช้จ่ายซื้อสินค้าที่หน้าเพจของคุณ</li></ul>
    </div>
    <div class="business-settings-section-body">

        <div class="alert alert-info">
                <div><strong style="font-size: 100%;font-weight: bold">หมายเหตุ:</strong> การใช้งานฟีเจอร์นี้คุณต้องมีเว็บไซต์ที่เชื่อมต่อกับโดเมนเรียบร้อยแล้ว</div>
        </div>
        <div class="form-insert form-vertical">



            <div class="row">
                <div class="col-sm-6 mbl">
                    <fieldset id="facebook_pixel_code_fieldset" class="control-group"><label for="facebook_pixel_code" class="control-label">Facebook Pixel Code</label><div class="controls"><input id="facebook_pixel_code" autocomplete="off" class="form-control" maxlength="75" value="{!!$item->facebook_pixel_code!!}" type="text" name="facebook_pixel_code"><div class="notification"></div></div></fieldset>

                </div>

                {{-- <div class="col-sm-6 mbl"></div> --}}

            </div>
        </div>

        <div class="alert alert-success mt-4 components-viewer">
            <h4 class="alert-heading mb-2" style="font-size: 100%;font-weight: bold">ขั้นตอนที่ 1 | เรียกใช้หมายเลข Facebook Pixel:</h4>
            <ol>
                    <li>ลงชื่อเข้าใช้บัญชี Facebook ของคุณ</li>
                    <li>ทำตามคำแนะนำ <a href="https://www.facebook.com/business/help/952192354843755" target="_blank">ต่อไปนี้</a> เพื่อสร้าง Facebook Pixel</li>
                    <li>คัดลอกหมายเลข Pixel</li>
                </ol>

                <hr>
            <h4 class="alert-heading my-2" style="font-size: 100%;font-weight: bold">ขั้นตอนที่ 2 | ติดตั้ง Facebook Pixel ในเว็บไซต์:</h4>
            <ol>

                <li>วางรหัส Pixel วางลงไปในช่องข้อความ <label for="facebook_pixel_code"><strong>Facebook Pixel Code</strong> ด้านบน</label> <br><strong>หมายเหตุ: </strong>กรุณาตรวจสอบเพื่อความแน่ใจว่าคุณไม่ได้เว้นวรรคก่อนอักษรตัวแรกของรหัส</li>

                <li>คลิก "เชื่อมต่อ Facebook Pixel"</li>
            </ol>
        </div>



    </div>
    <div class="business-settings-section-footer d-flex justify-content-between">
        <div></div>
        <div>
            <button type="submit" class="btn btn-primary btn-submit">เชื่อมต่อ Facebook Pixel</button>
        </div>
    </div>
</form>

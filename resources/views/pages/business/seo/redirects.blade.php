<form action="/business/update/settings" method="post" data-plugin="formSubmit" class="business-settings-section">
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="PUT" autocomplete="off" >
    <div class="business-settings-section-header">
        <h2>จัดการ 301 Redirects</h2>
        <p>ใช้ 301 redirects เมื่อ URL ของหน้าเพจ (ที่อยู่เว็บ) ย้ายไปอยู่ตำแหน่งใหม่แบบถาวร</p>

    </div>
    <div class="business-settings-section-body">

        <div class="form-insert form-vertical">

            <div class="alert alert-warning">
                <div class="mb-2"><strong>301 Redirect คืออะไร?</strong></div>

                <p>31 redirects ช่วยรักษาอันดับของคุณใน Google ไว้หลังจากที่ URL ของหน้าเพจเปลี่ยนไป ทำให้มั่นใจได้ว่า URL เก่าย้ายไปที่ URL ใหม่ และจะไม่เกิดข้อผิดพลาดกับผู้เข้าชมหากไปที่ URL เก่า</p>
            </div>

            <div class="row">
                <div class="col-sm-6 mbl">

                </div>

                {{-- <div class="col-sm-6 mbl"></div> --}}

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

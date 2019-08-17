<form action="/business/update/settings" method="post" data-plugin="formSubmit" class="business-settings-section">
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="PUT" autocomplete="off" >
    <div class="business-settings-section-header">
        <h2>สถานะ SEO</h2>
        <p>เพื่อให้เว็บไซต์ของคุณได้รับผู้เข้าชมจากเสิร์ชเอนจินต้องเปิดใช้งานคุณสมบัตินี้</p>
    </div>
    <div class="business-settings-section-body">

        <div class="form-insert form-vertical">

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

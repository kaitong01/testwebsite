<div style="background: linear-gradient(135deg,#e4e6f5,#ecf6ff 39%,#ddecff);background-size: 100% 302px;background-repeat: no-repeat;">
    <div class="business-settings-container" style="margin-left: auto;margin-right: auto">

        <div class="business-settings-header" style="background: transparent">

            <div class="d-flex">
                <div>
                    <h1 class="title">ปรับแต่งภาพสไลด์บนเว็บไซต์</h1>
                    {{-- <p class="sub-title"></p> --}}
                </div>
            </div>

            <div class="alert alert-danger mt-4"><h4 class="alert-heading mb-2" style="font-size: 100%; font-weight: bold;">หมายเหตุสำคัญ:</h4> <p>*คุณสามารถเพิ่มภาพสไลด์ได้ไม่เกิน 3 ภาพ</p></div>

        </div>
        <div class="business-settings-body">

            <form action="/site/slides" method="POST" data-plugin="formSubmit">
            {{ csrf_field() }}

            <div  class="business-settings-section" data-plugin="SiteSlide" data-options="<?=htmlentities(json_encode([
                'data'=> $data
            ]))?>">

                <div class="business-settings-section-header">

                    <div class=" d-flex justify-content-between">
                        <div>
                            <h2>ภาพสไลด์</h2>
                            {{-- <p></p> --}}
                        </div>

                        <button type="button" class="btn btn-primary btn-choosefile"><span class="d-flex align-items-center"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"><path d="M2 5v2h3v3h2V7h3V5H7V2H5v3H2z"></path></svg><span class="ml-2">อัปโหลดเพิ่ม</span></span><input type="file" accept="image/jpeg,image/png"  multiple="1"></button>

                    </div>
                </div>

                <div class="business-settings-section-body">

                    <div id="item_hotels_fieldset" class="control-group">
                        <div class="controls">
                            <table class="table-period-form d-none">
                                <thead>
                                    <tr>
                                        <th class="td-index">#</th>
                                        <th>รูป</th>
                                        <th class="data-action text-right">
                                            {{-- <button type="button" class="btn btn-primary btn-choosefile btn-sm"><span class="d-flex align-items-center"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"><path d="M2 5v2h3v3h2V7h3V5H7V2H5v3H2z"></path></svg><span class="ml-2">อัปโหลดเพิ่ม</span></span><input type="file" accept="image/jpeg,image/png"  multiple="1"></button> --}}
                                        </th>
                                    </tr>
                                </thead>

                                <tbody role="listsbox"></tbody>
                            </table>
                            <div class="dropzone-container" role="dropzone">
                                <div class="toggle-dropzone-upload" style="height: 350px">

                                    <div class="h-100 d-flex justify-content-center align-items-center">
                                        <div class="p-2 text-center">
                                            <h3 class="mb-1">เพิ่มรูปภาพ</h3>
                                            <p>ลากไฟล์แล้ววางหรืออัปโหลดจากคอมพิวเตอร์ของคุณ</p>
                                            <button type="button" class="mt-2 btn btn-outline-primary" data-action="upload"><span class="d-flex align-items-center"><svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M12 12L12 6 11 6 11 12 5 12 5 13 11 13 11 19 12 19 12 13 18 13 18 12z"></path></svg><span>อัปโหลด</span></span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="notification"></div>
                        </div>
                    </div>

                </div>

                <div class="business-settings-section-footer d-flex justify-content-between"><div></div> <div><button type="submit" class="btn btn-primary btn-submit">บันทึก</button></div></div>

            </div>
            </form>

        </div>
        {{-- end business-settings-body --}}
    </div>
</div>

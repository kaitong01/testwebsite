<div style="background: linear-gradient(135deg,#e4e6f5,#ecf6ff 39%,#ddecff);    background-size: 100% 302px;background-repeat: no-repeat;">
        <div class="business-settings-container" style="margin-left: auto;margin-right: auto">

            <div class="business-settings-header" style="background: transparent">

                <div class="d-flex">
                    <div>
                        <h1 class="title">เครื่องมือติดตามและการวิเคราะห์เว็บไซต์</h1>
                        <p class="sub-title">เพิ่มเครื่องมือลงในโค้ดของเว็บไซต์ของคุณอย่าง Google Analytics และ Facebook Pixel ได้ง่ายๆ</p>
                    </div>

                </div>


                <div class="alert alert-danger mt-4">
                        <h4 class="alert-heading mb-2" style="font-size: 100%;font-weight: bold">หมายเหตุสำคัญ:</h4>
                        <p>โปรดทราบว่าการใช้บริการนี้ดำเนินการผ่านผู้ให้บริการซึ่งเป็นบุคคลที่สามโดยตรง เราแนะนำให้คุณตรวจสอบนโยบายและข้อกำหนดการใช้งานก่อนที่จะใช้บริการ การยินยอมและรับทราบว่าเราจะไม่รับผิดชอบหากเกิดการสูญหายหรือความเสียหายอันเกิดจากการใช้บริการจากบุคคลที่สาม ซึ่งจะรวมถึงความเสียหายอันเกิดจากการแลกเปลี่ยนข้อมูลส่วนบุคคลระหว่างคุณและบุคคลที่สามดังกล่าวด้วย</p>
                    </div>


            </div>
            <div class="business-settings-body">

                    @include('pages.business.embeds.GoogleAnalytics')
                    @include('pages.business.embeds.FacebookPixel')
                    @include('pages.business.embeds.GoogleAdWords')


            </div>
        </div>
</div>

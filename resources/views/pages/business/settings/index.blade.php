<div style="background: linear-gradient(135deg,#e4e6f5,#ecf6ff 39%,#ddecff);    background-size: 100% 302px;background-repeat: no-repeat;">
    <div class="business-settings-container" style="margin-left: auto;margin-right: auto">

        <div class="business-settings-header" style="background: transparent">

            <div class="d-flex">
                <div>
                    <h1 class="title">ข้อมูลเว็บไซต์</h1>
                    <p class="sub-title">ข้อมูลพื้นฐาน ที่นำไปแสดงบนหน้าเว็บไซต์ เพื่อให้ลูกค้ารู้จักคุณและสามารถติดต่อกับคุณได้</p>
                </div>
            </div>

        </div>
        <div class="business-settings-body">

            @include('pages.business.settings.basics')
            @include('pages.business.settings.contacts')
            @include('pages.business.settings.locations')
            @include('pages.business.settings.officehours')

        </div>
    </div>
</div>

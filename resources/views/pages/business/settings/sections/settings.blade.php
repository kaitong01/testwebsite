<div class="business-settings-container">

    <div class="business-settings-header">

        <div class="d-flex">
            <div>
                <h1 class="title">ข้อมูลเว็บไซต์</h1>
                <p class="sub-title">ข้อมูลพื้นฐาน ที่นำไปแสดงบนหน้าเว็บไซต์ เพื่อให้ลูกค้ารู้จักคุณและสามารถติดต่อกับคุณได้</p>
            </div>
        </div>

    </div>
    <div class="business-settings-body">

        @include('pages.business.settings.forms.settings')
        @include('pages.business.settings.forms.contacts')
        @include('pages.business.settings.forms.locations')
        @include('pages.business.settings.forms.officehours')

    </div>
</div>

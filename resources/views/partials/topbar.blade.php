<div id="page-topbar" class="page-topbar">
    <nav class="navbar navbar-expand-md navbar-dark">

        <a class="navbar-brand" href="{{ url('/') }}">
            <h1>Manager</h1>
            <h2>Easy Web Tour</h2>
        </a>

        <div class="collapse navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

                <?php if( Auth::user()->company_id==0 ){

                    // <img src="" alt="">
                    ?>

                    <li class="nav-link dropdown topbar-dropdown-company" data-plugin="SwitchCompany">
                        <div class="account-group topbar-dropdown-company-toggle d-flex align-items-center" data-toggle="dropdown" data-company-id="{{ Session::get('cid') }}">
                            <div class="avatar"></div>
                            <div class="content">
								<div class="pl-2">
									<div class="title" style="white-space: nowrap;">{{ Session::get('cname') }}</div>
									<div class="text">{{ Session::get('cdomain') }}</div>
								</div>
                            </div>
                            <div class="ml-2" style="font-size: 14px;"><i class="fa fa-chevron-down"></i></div>
                        </div>

                        <div class="dropdown-menu" role="dropdown">
                            <div class="dropdown-menu-content has-loading" role="content">
                                <ul role="listbox"></ul>

                                <div class="elem-alert" role="alert">
									<div class="loader"><div class="loader-spin-wrap"><div class="loader-spin"></div></div></div>

									<div class="error">
										<h1 class="mb-2">เกิดข้อผิดพลาด</h1>
										<p><button type="button" data-action="tryagain" class="btn btn-outline-info btn-sm">ลองใหม่</button></p>
									</div>

									<div class="empty"><h1>ไม่พบผลลัพธ์</h1></div>
									<div class="more"><button type="button" data-action="more" class="btn btn-outline-info btn-sm">โหลดเพิ่ม</button></div>
								</div>
                            </div>
                        </div>
                    </li>
                <?php } ?>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto align-items-center">
                <!-- Authentication Links -->

                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @else

                <li class="nav-item ml-2">
                    <a href="/cart" class="nav-link"><svg width="24" height="24" viewBox="0 0 24 24"><path d="M22 9h-4.79l-4.38-6.56c-.19-.28-.51-.42-.83-.42s-.64.14-.83.43L6.79 9H2c-.55 0-1 .45-1 1 0 .09.01.18.04.27l2.54 9.27c.23.84 1 1.46 1.92 1.46h13c.92 0 1.69-.62 1.93-1.46l2.54-9.27L23 10c0-.55-.45-1-1-1zM12 4.8L14.8 9H9.2L12 4.8zM18.5 19l-12.99.01L3.31 11H20.7l-2.2 8z"></path><circle cx="12" cy="15" r="2"></circle></svg></a>

                </li>

                <li class="nav-item dropdown global-notify ml-2 d-none">
                    <a href="javascript:void(0)" class="nav-link" data-toggle="dropdown" aria-expanded="true"><svg width="24" heigth="24" viewBox="0 0 24 24"><path d="m12 24c1.5-0.1 2.7-1.3 2.8-2.8h-5.6c0.1 1.5 1.3 2.7 2.8 2.8zm6.5-17.4c0-2.4-2.3-3.5-5-3.7v-2.2c-0.1-0.4-0.5-0.7-0.9-0.7h-1.2c-0.4 0-0.8 0.3-0.8 0.7v2.2c-2.8 0.3-5 1.3-5 3.7 0 10.9-3.4 10.4-3.4 11.8v1.3h19.8v-1.3c-0.1-1.5-3.5-0.9-3.5-11.8z"/></svg></a>

                    <div class="dropdown-menu global-notify__dropdown-menu dropdown-menu-right has-empty">
                        <div class="global-notify__header">การแจ้งเตือน</div>

                        <div class="global-notify__list">
                            <!-- <div class="global-notify__item head">วันนี้</div> -->
                            <!-- <div class="global-notify__item"></div> -->
                            <!-- <div class="global-notify__item head">ก่อนหน้านี้</div> -->
                        </div>

                        <div class="global-notify__alert state-alert">
                            <div class="loading"><div class="loader-spin-wrap"><div class="loader-spin"></div></div>กำลังโหลด...</div>
                            <div class="empty"><div class="empty-title">ไม่มีการแจ้งเตือน</div></div>
                            <div class="error">เกิดข้อผิดพลาด, <a href="javascript:void(0)" data-action="tryagain">ลองอีกครั้ง</a></div>

                            <div class="more"><a href="javascript:void(0)" data-action="more">เพิ่มเติม</a></div>
                        </div>

                        <div class="global-notify__footer"><a href="/notifications">ดูทั้งหมด</a></div>
                    </div>
                </li>

                <li class="nav-item dropdown global-nav-profile ml-3">

                    <a class="nav-link avatar avatar-9" href="javascript:void(0)" data-toggle="dropdown" aria-expanded="true">
                        <div class="initials"><i class="icon-user"></i></div>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">

                        <div class="dropdown-item-profile px-2 pt-1">
                            <div class="account-group d-flex align-items-center">
                                <div class="mr-2"><div class="initials avatar avatar-9"><i class="icon-user"></i></div></div>
                                <div>
                                    <div class="title">{{Auth::user()->name}}</div>
                                    <div class="subtitle">{{Auth::user()->username}}</div>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="dropdown-divider"></div> -->

                        <!-- <div class="dropdown-item">
                            <div class="row no-gutters">
                                <div class="col mr-3"><span>ออนไลน์</span></div>
                                <div class="col-auto">
                                    <label class="switch"><input type="checkbox" checked=""><span class="slider"></span></label>
                                </div>
                            </div>
                        </div> -->

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="/account"><span>โปรไฟล์</span></a>

                        <!-- <a class="dropdown-item" href="/account/activity"><span>บันทึกกิจกรรม</span></a> -->

                        {{-- <a class="dropdown-item" href="/about"><span>เกี่ยวกับ</span></a> --}}

                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal"><span>ออกจากระบบ</span></a>
                        {{-- /account/logout --}}
                        <!-- data-plugin="lightbox"  -->
                    </div>

                </li>
                {{-- <li class="nav-item">

                    <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">ออกจากระบบ</a>
                </li> --}}

                @endguest

            </ul>
        </div>
    </nav>
</div>

<!-- 'addClass' => 'modal-lg' -->
@section('modals')
    {{-- set modal: logout --}}
    @component('components.modal', [
        'id' => 'logoutModal',
        'form'=> [
            'action'=> route('logout'),
            'method'=> 'POST'
        ],
        'title' => "ออกจากระบบ",

    ])

        ยืนยันการออกจากระบบหรือไม่?

        @slot('buttons')

            <button type="submit" class="btn btn-primary">ออกจากระบบ</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        @endslot
    @endcomponent

@endsection

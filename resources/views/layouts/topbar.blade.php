<?php

// use Illuminate\Support\Facades\Session;



?>
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
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->

                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @else

                <li class="nav-item">

                    <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">ออกจากระบบ</a>
                </li>

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


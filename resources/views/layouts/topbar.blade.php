<div id="page-topbar" class="page-topbar">
    <nav class="navbar navbar-expand-md navbar-dark">

        <a class="navbar-brand" href="{{ url('/') }}">
            <h1>Manager</h1>
            <h2>Easy Web Tour</h2>
        </a>

        <div class="collapse navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

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


@section('modals')
    {{-- set model: logout --}}
    @component('components.model', [
        'id' => 'logoutModal',
        'form'=> [
            'action'=> route('logout'),
            'method'=> 'POST'
        ],
        'title' => "ออกจากระบบ"
    ])

        ยืนยันการออกจากระบบหรือไม่?

        @slot('buttons')

            <button type="submit" class="btn btn-primary">ออกจากระบบ</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        @endslot
    @endcomponent

@endsection


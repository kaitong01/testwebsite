@extends('index')


@section('content')

    <div class="vertical-align-items-center">
        <div class="page-login">

            <form class="page-login-form" method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                @csrf

                <input type="hidden" name="remember" id="remember" value="1" autocomplete="off" />

                <div class="mb-4">

                    <h1>ลงชื่อเข้าใช้</h1>
                </div>


                <div class="form-group">

                    <input id="username" type="username" class="form-textbox form-textbox-text form-icon-left form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="chong"  autocomplete="off" required autofocus>
                    <label class="form-label" for="username">{{ __('ชื่อเข้าใช้งาน') }}</label>

                    <div class="form-icons-wrapper form-icons-wrapper-left">
                        <i class="fa fa-user"></i>
                    </div>

                    @if ($errors->has('username'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <input id="password" type="password" class="form-textbox form-textbox-text form-icon-left form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"  autocomplete="off" required value="1234">

                    <label class="form-label" for="password">{{ __('รหัสผ่าน') }}</label>

                <div class="form-icons-wrapper form-icons-wrapper-left">
                        <i class="fa fa-key"></i>
                    </div>


                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>



                <div class="form-group mb-0">
                    <div class="d-flex flex-row-reverse">

                        <button type="submit" class="btn btn-primary"><span>{{ __('ลงชื่อเข้าใช้') }}</span><i class="ml-2 fa fa-arrow-right"></i></button>
                    </div>
                </div>
            </form>


        </div>
    </div>
@endsection

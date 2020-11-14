@extends('layouts.full_width')
@section('script')
    <script src="{{ asset('js/validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/validate/localization/messages_th.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            
            $('#signup-row').hide();
            $('#already').hide();
            $("#newsignup").click(function () {
                $("#newsignup").toggle();
                $("#already").toggle();
                $("#signup-row").show();
                $("#login-row").hide();

            });
            $("#already").click(function () {
                $("#newsignup").toggle();
                $("#already").toggle();
                $("#login-row").show();
                $("#signup-row").hide();
            });

            $('#form-login').validate({
                errorPlacement: function (error, element) {
                    // Append error within linked label
                    $(element).addClass('error');
                }
            });

            $('#form-signup').validate({
                errorPlacement: function (error, element) {
                    // Append error within linked label
                    $(element).addClass('error');
                }
            });
        });
    </script>
@stop
@section('css')
    <style type="text/css" media="screen">
        /* Login Page */
        body{
            background: #fff ;
        }

        .error {
            border-color: #f00;
        }

        /* End Login Page */
    </style>
@stop
@section('content')
<div id="login-page" align="">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <div class="box-create box-border">
                <div class="box-header">
                    
                </div>
                <div class="box-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li class="text-left">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                   
                    <div id="login-row">
                        <form class="" role="form" method="POST" action="{{ action('UserController@postLogin') }}"
                              id="form-login">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <h2 class="text-left">เข้าสู่ระบบ</h2>
                            <hr>
                            <div id="social-login">
                                <p>
                                    <a href="{{ action('UserController@getSocialLogin', 'facebook') }}{{ Request::has('return') ? '?return=' . Request::input('return') : ''}}{{ Request::has('key') ? '&key' . Request::input('key') : '' }}" 
                                        class="btn btn-block btn-social btn-facebook btn-lg" >
                                        <i class="fa fa-facebook fa-2x"></i>
                                        เข้าสู่ระบบด้วยบัญชี Facebook
                                    </a>
                                </p>
                                <p>
                                    <a href="{{ action('UserController@getSocialLogin', 'google') }}{{ Request::has('return') ? '?return=' . Request::input('return') : ''}}{{ Request::has('key') ? '&key' . Request::input('key') : '' }}" 
                                        class="btn btn-block btn-social btn-google btn-lg" >
                                        <i class="fa fa-google-plus fa-2x"></i>
                                        เข้าสู่ระบบด้วยบัญชี Google
                                    </a>
                                </p>
                            </div>
                            <hr>
                            <h3 class="text-center">เข้าสู่ระบบด้วยอีเมล</h3>
                            <table class="table-form">
                                <div class="form-group has-feedback">
                                    <input type="email" name="email" id="email" class="form-control" placeholder="อีเมล" required>
                                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                </div>
                                <div class="form-group has-feedback">
                                    <input type="password" name="password" id="password" class="form-control" placeholder="รหัสผ่าน" required>
                                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <p class="text-left">
                                            <input type="checkbox" name="keep_login" id="keep_login">
                                            <label for="keep_login">ให้ฉันอยู่ในระบบต่อไป</label>
                                        </p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p class="text-right">
                                            <a href="{{ url('user/forgot-password') }}" title="ลืมรหัสผ่าน">
                                                ลืมรหัสผ่าน?
                                            </a>
                                        </p>
                                    </div>
                                </div>
                                
                                <p>
                                    <button type="submit" id="btn-login" class="btn btn-lg btn-success btn-block">เข้าสู่ระบบ</button>
                                </p>
                            </table>
                        </form>
                        <hr>
                        <p class="text-center">
                            ยังไม่ได้เป็นสมาชิก?&nbsp;
                            <a href="{{ url('signup') }}" id="newsignup">สมัครสมาชิก</a>
                        </p>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop


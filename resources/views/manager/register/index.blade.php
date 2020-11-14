@extends('manager.layouts.master')
@section('script')
    <script src="{{ asset('js/hashids.min.js') }}"></script>
    @if(!\Auth::user()->check())
        <script>
            $(document).ready(function () {
                $("#designer-form input").attr("disabled", true);
                $("#designer-form a").attr("disabled", true);
                $("#login-button").hide();
                $("#register-button").click(function() {
                    $('#login-panel').removeClass('in');
                    $(this).hide();
                    $('#login-button').show();
                });
                $("#login-button").click(function() {
                    console.log('Click');
                    $('#registration-form-panel').removeClass('in');
                    $(this).hide();
                    $('#register-button').show();
                });
            });
        </script>
    @else
        <script>
            $(document).ready(function () {
                $("#agree-terms").change(function () {
                    var element = $(this);
                    if (element.prop("checked")) {
                        $("#register-btn").removeAttr("disabled");
                    } else {
                        $("#register-btn").attr("disabled", true);
                    }
                });
            });
        </script>
    @endif
@stop
@section('css')
    <style type="text/css" media="screen">
        .box {
            background: #fff;
            border: solid 1px #ddd;
            border-radius: 4px;
            margin-bottom: 20px;
            padding: 25px;
        }
        @media(max-width: 767px){
            .nav{
                margin:auto;
            }
            #main-nav-wrapper .navbar-nav{
                padding-left: 0px;
            }
        }
    </style>
@stop
@section('content')
    <div class="row">
        @include('manager.register.registration-step', ['step' => '1'])
        <div class="col-sm-4 col-sm-offset-4">
            <div class="box-create box-border panel-group" id="accordian">
                <div class="box-header">
                    
                </div>
                <div class="box-body panel-collapse collapse" data-parent="accordian" id="registration-form-panel">
                    <h3 class="text-center">สมัครสมาชิก</h3>
                    <div id="social-login">
                        <p>
                            <a href="{{ action('UserController@getSocialLogin', 'facebook') }}?return={{ \Request::path() }}"
                               class="btn btn-block btn-social btn-facebook btn-lg">
                                <i class="fa fa-facebook fa-2x"></i>
                                สมัครสมาชิกด้วยบัญชี Facebook
                            </a>
                        </p>

                        <p>
                            <a href="{{ action('UserController@getSocialLogin', 'google') }}?return={{ \Request::path() }}"
                               class="btn btn-block btn-social btn-google btn-lg">
                                <i class="fa fa-google-plus fa-2x"></i>
                                สมัครสมาชิกด้วยบัญชี Google
                            </a>
                        </p>
                    </div>
                    <hr>
                    <h3>สมัครสมาชิกด้วยอีเมล</h3>

                    <form method="post" action="{{ action('UserController@postRegister') }}?return={{ \Request::path() }}">
                        @foreach ($errors->all() as $error)
                            <p class="alert alert-warning">{{ $error }}</p>
                        @endforeach
                        {{ csrf_field() }}
                        <div class="form-group has-feedback">
                            
                            <input type="text" class="form-control" name="full_name" id="full_name"
                                   placeholder="ใส่ชื่อและนามสกุล" required
                                   value="{{ \Auth::user()->check() ? \Auth::user()->user()->full_name : old('full_name') }}">
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            
                            <input type="email" name="email" id="email" class="form-control"
                                   placeholder="อีเมล"
                                   required
                                   value="{{ \Auth::user()->check() ? \Auth::user()->user()->email : old('email') }}">
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        </div>

                        <div class="form-group has-feedback">
                            
                            <input type="password" name="password" id="password" class="form-control"
                                   placeholder="รหัสผ่าน" required>
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            <p class="">รหัสผ่านต้องมาความยาวไม่น้อยกว่า 6 ตัวอักษรและเป็นตัวอักษรภาษาอังกฤษหรือตัวเลขเท่านั้น</p>
                        </div>
                        <div class="form-group has-feedback">
                            
                            <input type="password" name="password_confirmation" id="password-confirmation"
                                   class="form-control"
                                   placeholder="ใส่รหัสผ่านอีกครั้ง" required>
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>
                        <div class="checkbox">
                            <label>
                                <strong>
                                    <input type="checkbox" id="agree-terms" required="">
                                    &nbsp;ฉันได้อ่านและยอมรับ<a
                                            href="{{ action('HelpController@getTerms') }}"
                                            target="_blank">ข้อตกลงการใช้งาน</a>
                                </strong>
                            </label>
                            <br>
                        </div>
                        <p class="text-center">
                            <button type="submit" class="btn btn-success btn-lg btn-block">
                                ยืนยัน
                            </button>
                        </p>
                    </form>
                </div>
                <div class="box-body panel-collapse collapse in" data-parent="accordian" id="login-panel">
                    
                    <h3 class="text-center">เข้าสู่ระบบ</h3>
                    <div id="login-wrapper">
                        <div class="social-auth-links text-center">
                            <div class="row">
                                <div class="col-sm-12">
                                    <p>
                                        <a href="{{ action('UserController@getSocialLogin', 'facebook') }}{{ Request::has('return') ? '?return=' . Request::input('return') : ''}}"
                                           class="btn btn-block btn-social btn-facebook btn-lg" id="facebook">
                                            <i class="fa fa-facebook"></i>
                                            เข้าสู่ระบบด้วย Facebook
                                        </a>
                                    </p>
                                </div>
                                <div class="col-sm-12">
                                    <p>
                                        <a href="{{ action('UserController@getSocialLogin', 'google') }}{{ Request::has('return') ? '?return=' . Request::input('return') : ''}}"
                                           class="btn btn-block btn-social btn-google btn-lg" id="google">
                                            <i class="fa fa-google-plus fa-2x"></i>
                                            เข้าสู่ระบบด้วย Google
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <h4 class="text-center">- หรือ - </h4>
                        <div id="login-row">
                            <form role="form" method="POST" action="{{ action('UserController@postLogin') }}"
                                  id="form-login">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="form-group has-feedback">
                                    <input type="email" name="email" id="email" class="form-control" placeholder="อีเมล"
                                           required>
                                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                </div>

                                <div class="form-group has-feedback">
                                    <input type="password" name="password" id="password" class="form-control"
                                           placeholder="รหัสผ่าน" required>
                                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <button type="submit" id="btn-login" class="btn btn-success btn-block btn-lg">
                                            เข้าสู่ระบบ
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <p>
                                    <a href="{{ url('user/forgot-password') }}" title="ลืมรหัสผ่าน">
                                        ลืมรหัสผ่าน?
                                    </a>
                                </p>
                            </div>
                        </div>
                        
                        
                    </div>

                
                </div>
                <hr>
                <p class="text-center">
                    <button class="btn btn-default" id="register-button" type="button" data-toggle="collapse" data-target="#registration-form-panel" aria-expanded="false" aria-controls="registration-form-panel">
                        สมัครสมาชิกใหม่
                    </button>
                    <button class="btn btn-default" id="login-button" type="button" data-toggle="collapse" data-target="#login-panel" aria-expanded="false" aria-controls="login-panel">
                        เป็นสมาชิกอยู่แล้ว, เข้าสู่ระบบที่นี่
                    </button>
                </p>
            </div>
        </div>
    </div>
@stop
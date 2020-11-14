@extends('layouts.full_width')
@section('script')
    <script src="{{ asset('js/validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/validate/localization/messages_th.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            

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
        }

        .error {
            border-color: #f00;
        }
        #footer{
            display: none;
        }
        #signup-page{
            margin: 50px auto ;
        }

        #signup-wrapper{
            width: 500px;
        }
        .form-control-feedback {
            top:43px !important;
        }
        /* End Login Page */
    </style>
@stop
@section('content')
      
<div class="row">
    <div class="col-sm-6 col-sm-offset-3">
        <div class="box-create box-border">
            <div class="box-header">
                
            </div>
            <div class="box-body">
                <h2 class="text-left">สมัครสมาชิก</h2>
                <hr>
                <div id="social-login">
                        <p>
                            <a href="{{ action('UserController@getSocialLogin', 'facebook') }}{{ Request::has('return') ? '?return=' . Request::input('return') : ''}}{{ Request::has('key') ? '&key' . Request::input('key') : '' }}" 
                                class="btn btn-block btn-social btn-facebook btn-lg" >
                                <i class="fa fa-facebook fa-2x"></i>
                                ลงทะเบียนด้วยบัญชี Facebook
                            </a>
                        </p>
                        <p>
                            <a href="{{ action('UserController@getSocialLogin', 'google') }}{{ Request::has('return') ? '?return=' . Request::input('return') : ''}}{{ Request::has('key') ? '&key' . Request::input('key') : '' }}" 
                                class="btn btn-block btn-social btn-google btn-lg" >
                                <i class="fa fa-google-plus fa-2x"></i>
                                ลงทะเบียนด้วยบัญชี Google
                            </a>
                        </p>
                    </div>
                    <hr>    
                    
                <h3>สมัครสมาชิกด้วยอีเมล</h3>
                <form method="post" action="{{ action('UserController@postRegister') }}">
                    {!! csrf_field() !!}
                    @foreach ($errors->all() as $error)
                        <p class="alert alert-warning">{{ $error }}</p>
                    @endforeach
                    <div class="form-group">
                        <label for="full_name">ชื่อและนามสกุล</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter your name" required="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">เบอร์โทรศัพท์</label>
                        <input type="text" class="form-control"  name="phone" placeholder="Phone" required="">
                    </div>
                    <div class="form-group has-feedback">
                        <label for="exampleInputEmail1">อีเมล</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="อีเมล"
                               required>
                        <span class="glyphicon glyphicon-envelope form-control-feedback" ></span>
                    </div>

                    <div class="form-group has-feedback">
                        <label for="exampleInputPassword1">รหัสผ่าน</label>
                        <input type="password" name="password" id="password" class="form-control"
                               placeholder="รหัสผ่าน" required>
                        <span class="glyphicon glyphicon-lock form-control-feedback" ></span>
                    </div>
                    <div class="checkbox">
                        <label>
                            <strong>
                            <input type="checkbox" id="agree-terms" required="">&nbsp;ฉันได้อ่านและยอมรับ<a href="{{ action('HelpController@getTerms') }}" class="">ข้อตกลงการใช้งาน</a>
                            </strong>
                        </label>
                        <br>
                    </div>
                    <p class="text-center">
                        <button type="submit" class="btn btn-success btn-lg btn-block">ยืนยัน</button>
                    </p>
                    

                    <hr>
                    <p class="text-center">
                        เป็นสมาชิกอยู่แล้ว?&nbsp;
                        <a href="{{ url('login') }}">เข้าสู่ระบบ</a>
                    </p>
                    
                </form>
            
            </div>
        </div>
    </div>
</div>
   

@stop


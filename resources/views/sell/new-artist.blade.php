@extends('manager.layouts.master')
@section('script')
    <script src="{{ asset('js/hashids.min.js') }}"></script>
    @if(!\Auth::user()->check())
    <script>
        $(document).ready(function() {
             $("#designer-form input").attr("disabled", true);
             $("#designer-form a").attr("disabled", true);
        });
    </script>
    @endif
@stop
@section('css')
    <style type="text/css" media="screen">

    </style>
@stop
@section('content')
<h1 class="box-title text-center">ลงทะเบียนครีเอเตอร์</h1>
<div class="row">
    <div class="col-sm-4">
        <div id="login-warpper">
            <h3 class="text-left">เข้าสู่ระบบ</h3>
            <hr>
            <div class="social-auth-links text-center">
                <div class="row">
                    <div class="col-sm-12">
                        <p>
                            <a href="http://beta.{{ config('profile.sitename') }}/user/facebook/social-login" class="btn btn-block btn-social btn-facebook" id="facebook">
                                <i class="fa fa-facebook"></i>
                                เข้าสู่ระบบด้วยบัญชี Facebook
                            </a>
                        </p>
                    </div>
                    <div class="col-sm-12">
                        <p>
                            <a href="http://beta.{{ config('profile.sitename') }}/user/google/social-login" class="btn btn-block btn-social btn-google" id="google">
                                <i class="fa fa-google-plus fa-2x"></i>
                                เข้าสู่ระบบด้วยบัญชี Google
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            <hr>
            <h3 class="text-center">เข้าสู่ระบบด้วยอีเมล</h3>
            <div id="login-row">
                <form role="form" method="POST" action="http://beta.{{ config('profile.sitename') }}/user/login" id="form-login">
                    <input type="hidden" name="_token" value="hSAsDbFwvI5Zopj3XAPyBtnnAxqjTL6WtklKst80">

                    <div class="form-group has-feedback">
                        <input type="email" name="email" id="email" class="form-control" placeholder="อีเมล" required="">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <input type="password" name="password" id="password" class="form-control" placeholder="รหัสผ่าน" required="">
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
            <br>
            <div class="row">
                <div class="col-sm-12">
                    <p>
                        <a href="http://beta.{{ config('profile.sitename') }}/user/forgot-password" title="ลืมรหัสผ่าน">
                            ลืมรหัสผ่าน?
                        </a>
                    </p>

                    <p>
                        <a href="http://beta.{{ config('profile.sitename') }}/signup" id="newsignup" class="text-left">
                            สมัครสมาชิกด้วยอีเมล
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="box-create box-border">
            <div class="box-header">
                
            </div>
            <div class="box-body">
                <form id="designer-form">
                    <div class="form-group">
                        <label for="full_name">ชื่อและนามสกุล</label>
                        <input type="text" class="form-control" id="full_name" placeholder="Chawput Nawakalanyu" disabled required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">นามปากกา (ใช้แสดงผล)</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Display Name" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">เบอร์โทรศัพท์</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Phone" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">อีเมล</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">รหัสผ่าน</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
                    </div>
                    <hr>
                    <h4>บัญชีธนาคารสำหรับรับรายได้</h4>
                    <div class="form-group">
                        <label for="exampleInputEmail1">ชื่อบัญชีธนาคาร</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="นาย xxxxx xxxxxx" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">เลขบัญชีธนาคาร</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="xxx-x-xxxxx-x" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">ชื่อธนาคาร</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="ธนาคาร.." required>
                    </div>
                    <div class="checkbox">
                        <label>
                            <strong>
                            <input  type="checkbox" id="agree-terms" required>
                            &nbsp;ฉันได้อ่านและยอมรับ<a href="{{ url('help/terms') }}">ข้อตกลงการใช้งาน</a>
                            </strong>
                        </label>
                        <br>
                    </div>
                    <p class="text-center">
                        <a type="submit" href="{{ action('AssociateController@getIndex') }}" class="btn btn-success btn-lg btn-block">ยืนยันการลงทะเบียน</a>
                    </p>
                    <hr>
                    <p class="text-center">
                        <a href="{{ url('manager-login') }}" class="btn btn-default-shadow">เป็นสมาชิกอยู่แล้ว เข้าสู่ระบบที่นี่</a>
                    </p>
                    
                </form>
            
            </div>
        </div>
    </div>
</div>
@stop
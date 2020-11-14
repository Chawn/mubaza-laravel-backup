@extends('manager.layouts.master')
@section('script')
    <script src="{{ asset('js/hashids.min.js') }}"></script>
    <script>
    </script>
@stop
@section('css')
    <style type="text/css" media="screen">
       
       
    </style>
@stop
@section('content')
<h1 class="box-title text-center">ลงทะเบียน Affiliate</h1>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="box-create box-border">
            <div class="box-header">
                
            </div>
            <div class="box-body">
                <form>
                    <div class="form-group">
                        <label for="full_name">ชื่อและนามสกุล</label>
                        <input type="text" class="form-control" id="full_name" placeholder="Name Lastname" required>
                    </div>
                    <div class="form-group">
                        <label for="Phone">เบอร์โทรศัพท์</label>
                        <input type="email" class="form-control" id="Phone" placeholder="Phone" required>
                    </div>
                    <div class="form-group">
                        <label for="email">อีเมล</label>
                        <input type="email" class="form-control" id="email" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">รหัสผ่าน</label>
                        <input type="password" class="form-control" id="password" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <label for="webpage">เว็บไซต์หรือเฟซบุค</label>
                        <input type="text" class="form-control" id="webpage" placeholder="www.xxx.com" required>
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
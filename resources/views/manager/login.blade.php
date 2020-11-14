@extends('layouts.full_width')
@section('script')
    <script src="{{ asset('js/hashids.min.js') }}"></script>
    <script>
    </script>
@stop
@section('css')
    <style type="text/css" media="screen">
        #main-nav-collapse,.searchbar{
            display: none;
        }
    </style>
@stop
@section('content')
<h1 class="box-title text-center">ครีเอเตอร์ เข้าสู่ระบบ</h1>
<div class="row">
    <div class="col-sm-6 col-sm-offset-3">
        <div class="box-create box-border">
            <div class="box-header">
                
            </div>
            <div class="box-body">
                <form>
                    <div class="form-group">
                        <label for="exampleInputEmail1">อีเมล</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">รหัสผ่าน</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
                    </div>
                    <p class="text-center">
                        <a type="submit" href="{{ action('AssociateController@getIndex') }}" class="btn btn-success btn-lg btn-block">เข้าสู่ระบบ</a>
                    </p>
                    <p class="text-center">
                        <a type="submit" href="{{ action('AssociateController@getIndex') }}" class="">ลืมรหัสผ่าน</a>
                    </p>
                    <hr>
                    <p class="text-center">

                        <a type="submit" href="{{ action('AssociateController@getRegister') }}" class="btn  btn-default-shadow">
                            <strong>ลงทะเบียน Associate</strong>
                        </a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
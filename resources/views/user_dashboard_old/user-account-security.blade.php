@extends('layouts.user-profile')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/user-account.css') }}">
<style>
	
</style>
@stop
@section('content')
    <div id="collapse-password" class="box">
        <div class="col-sm-12 col-xs-12">
            <h4 class="sub-title"><strong>กำหนดรหัสผ่าน</strong></h4>
            <form class="form-horizontal" method="POST"
                  action="{{ action('UserController@postChangePassword', $user->id) }}">
                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                @if(!is_null($user->password))
                <div class="form-group">
                    <label class="col-md-3" for="old_password">รหัสผ่านเดิม</label>
                    <div class="col-md-8">
                        <input type="password" name="old_password" id="old_password"
                               class="form-control" placeholder="รหัสผ่านเดิม">
                    </div>
                </div>
                @endif
                <p class="alert alert-warning">
                    คุณยังไม่ได้ตั้งรหัสผ่านสำหรับเข้าสู่ระบบด้วยอีเมล กรุณากรอกรหัสผ่านที่ช่องด้านล่างทั้งสองช่องให้เหมือนกัน เพื่อกำหนดเป็นรหัสผ่านของคุณ
                </p>
                <div class="form-group">
                    <label class="col-md-4" for="password">ตั้งรหัสผ่านใหม่</label>
                    <div class="col-md-8">
                        <input type="password" name="password" id="password"
                               class="form-control" placeholder="รหัสผ่านใหม่">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4" for="password_confimation">ใส่รหัสผ่านใหม่อีกครั้ง</label>
                    <div class="col-md-8">
                        <input type="password" name="password_confirmation"
                               id="password_confirmation" class="form-control"
                               placeholder="รหัสผ่านใหม่อีกครั้ง">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-8 col-md-offset-3">
                        <button id="btn-save-password" type="submit"
                                class="save-data btn btn-success btn-lg btn-save">บันทึก
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
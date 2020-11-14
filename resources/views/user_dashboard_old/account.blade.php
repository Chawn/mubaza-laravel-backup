@extends('layouts.full_width')
@section('content')
<div id="user-dashboard">
    <div class="content">
        <div class="container ">
            <div id="user-setting">
                <div class="row">
                    <div class="col-md-6">
                        <div class="title">แก้ไขข้อมูลส่วนตัว</div>
                        <form action="{{ action('UserController@postUpdateProfile') }}" method="post" accept-charset="utf-8" >
                            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                            <input name="user_id" type="hidden" value="{{ $user->id }}"/>
                            <table class="table-form">
                                <tr>
                                    <td>อีเมล</td>
                                    <td><input type="text" id="" class="form-control" name="email" value="{{ $user->email }}" disabled></td>
                                </tr>
                                <tr>
                                    <td>เบอร์โทรศัพท์</td>
                                    <td><input type="text" id="" class="form-control" name="phone" value="{{ $user->profile->phone }}"></td>
                                </tr>
                                <tr>
                                    <td>ชื่อ-นามสกุล</td>
                                    <td><input type="text" id="" class="form-control" name="full_name" value="{{ $user->full_name }}"></td>
                                </tr>
                                <tr>
                                    <td>ที่อยู่</td>
                                    <td><textarea id="" class="form-control" name="address" rows="3" type="address" autocompletetype="on">{{ $user->profile->address }}</textarea></td>
                                </tr>
                                <tr>
                                    <td>อำเภอ</td>
                                    <td><input type="text" id="" class="form-control" name="district" x-autocompletetype="city" value="{{ $user->profile->district }}"></td>
                                </tr>
                                <tr>
                                    <td>จังหวัด</td>
                                    <td><select name="province" id="province" class="form-control" id="province" required>
                                            @foreach(Config::get('constant.provinces') as $province)
                                                <option value="{{ $province }}" {{ $province == $user->profile->province ? 'selected' : '' }}>{{ $province }}</option>
                                            @endforeach
                                        </select></td>
                                </tr>
                                <tr>
                                    <td>รหัสไปรษณีย์</td>
                                    <td><input type="text" id="" class="form-control" name="zipcode"value="{{ $user->profile->zipcode }}"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><button type="submit" class="btn btn-primary ">บันทึก</button></td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <div class="title">เปลี่ยนรหัสผ่าน</div>
                        <form action="{{ action('UserController@postChangePassword') }}" method="post" accept-charset="utf-8">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                            <input name="user_id" type="hidden" value="{{ $user->id }}"/>
                            
                            <table class="table-form">
                            
                                @if ($user->provider==""||$user->provider!=""&&$user->password!="")
                                    <tr>
                                        <td>รหัสผ่านปัจจุบัน</td>
                                        <td><input type="password" id="" class="form-control" name="old_password"></td>
                                    </tr>
                                @endif
                                <tr>
                                    <td>รหัสผ่านใหม่</td>
                                    <td><input type="password" id="" class="form-control" name="password"></td>
                                </tr>
                                <tr>
                                    <td>ยืนยันรหัสผ่านอีกครั้ง</td>
                                    <td><input type="password" id="" class="form-control" name="password_confirmation"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><button type="submit" class="btn btn-primary">บันทึก</button></td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@stop
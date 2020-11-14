@extends('user.layouts.master')
@section('css')
<style>
    .form-control[readonly]{
        background: #fff;
        border:none;
        border-bottom:1px solid #ddd;
    }
    .a-edit{
        font-size: 14px;
    }
    .box-btn{
        width: 100%;
        margin:10px 0;
    }
</style>
@stop
@section('script')
    <script src="{{ asset('js/profile.js') }}"></script>
    
@stop
@section('content')
    <div class="box">
        @if(\Auth::user()->check() && \Auth::user()->user()->isOwner($user->id))
        <div class="col-sm-12 col-xs-12">
            <form action="" id="form-address">
                <div class="form-group">
                    <label class="account-title">ที่อยู่</label> 
                    <input type="text" class="form-control profile-editor" id="address"
                           placeholder="เช่น 123 หมู่ 4 ซอย 5 ต.หนองบัว" value="{{ $user->profile->address }}">
                </div>
                <div class="form-group">
                    <label class="account-title">อาคาร/ที่พัก</label>
                    <input type="text" class="form-control profile-editor" id="building" placeholder="เช่น อาคารมูบาซ่า"
                           value="{{ $user->profile->building }}">
                </div>
                <div class="form-group">
                    <label class="account-title">เขต/อำเภอ</label>
                    <input type="text" class="form-control profile-editor" id="district" placeholder="เช่น เมือง"
                           value="{{ $user->profile->district }}">
                </div>
                <div class="form-group">
                    <label class="account-title">จังหวัด</label>
                     <input type="text" class="form-control profile-editor" id="province" placeholder="เช่น อุดรธานี"
                           value="{{ $user->profile->province }}">
                </div>
                <div class="form-group">
                    <label class="account-title">รหัสไปรษณีย์</label>
                    <input type="text" class="form-control profile-editor" id="zipcode" placeholder="เช่น 41100"
                           value="{{ $user->profile->zipcode }}">
                </div>
                <div id="save-address" class="form-group">
                    <div class="box-checkbox box-btn">
                        <span><input type="checkbox" id="show_address"
                                     data-input="option|show_address|checkbox"
                                    {{ $user->option->show_address ? 'checked' : '' }}>แสดงข้อมูลที่อยู่นี้แบบสาธารณะ</span>

                    </div>
                    <div class="text-center box-btn">
                        <a class="btn btn-default btn-cancel">ยกเลิก</a>
                        <button class="btn btn-success">บันทึก</button>
                    </div>
                </div>
            </form> 
        </div>
        <!--
            <p>
                <label class="account-title">ที่อยู่</label><span id="span-address">{{ $user->profile->address }}</span>
                <a class="btn-edit" data-toggle="collapse" href="#collapse-address"
                   aria-expanded="false">แก้ไข</a>
            </p>
            <div class="collapse" id="collapse-address">
                <div class="col-md-8 col-xs-12">
                    <input type="text" class="form-control" id="address"
                           placeholder="เช่น 123 หมู่ 4 ซอย 5 ต.หนองบัว" value="{{ $user->profile->address }}">
                </div>
                <div class="col-md-4 col-xs-12">
                    <button id="btn-save-address" type="submit" data-input="profile|address|text"
                            class="btn btn-primary btn-save">บันทึก
                    </button>
                </div>
            </div>
            <p><label class="account-title">อาคาร/ที่พัก</label><span id="span-building">{{ $user->profile->building }}</span>
                <a class="btn-edit" data-toggle="collapse" href="#collapse-building"
                   aria-expanded="false">แก้ไข</a>
            </p>
            <div class="collapse" id="collapse-building">
                <div class="col-md-8 col-xs-12">
                    <input type="text" class="form-control" id="building" placeholder="เช่น อาคารมูบาซ่า"
                           value="{{ $user->profile->building }}">
                </div>
                <div class="col-md-4 col-xs-12">
                    <button id="btn-save-building" type="submit" data-input="profile|building|text"
                            class="btn btn-primary btn-save">บันทึก
                    </button>
                </div>
            </div>
            <p><label class="account-title">อำเภอ</label><span id="span-district">{{ $user->profile->district }}</span>
                <a class="btn-edit" data-toggle="collapse" href="#collapse-district"
                   aria-expanded="false">แก้ไข</a>
            </p>
            <div class="collapse" id="collapse-district">
                <div class="col-md-8 col-xs-12">
                    <input type="text" class="form-control" id="district" placeholder="เช่น เมือง"
                           value="{{ $user->profile->district }}">
                </div>
                <div class="col-md-4 col-xs-12">
                    <button id="btn-save-district" type="submit" data-input="profile|district|text"
                            class="btn btn-primary btn-save">บันทึก
                    </button>
                </div>
            </div>
            <p><label class="account-title">จังหวัด</label><span id="span-province">{{ $user->profile->province }}</span>
                <a class="btn-edit" data-toggle="collapse" href="#collapse-province"
                   aria-expanded="false">แก้ไข</a>
            </p>
            <div class="collapse" id="collapse-province">
                <div class="col-md-8 col-xs-12">
                    <input type="text" class="form-control" id="province" placeholder="เช่น อุดรธานี"
                           value="{{ $user->profile->province }}">
                </div>
                <div class="col-md-4 col-xs-12">
                    <button id="btn-save-province" type="submit" data-input="profile|province|text"
                            class="btn btn-primary btn-save">บันทึก
                    </button>
                </div>
            </div>
            <p><label class="account-title">รหัสไปรษณีย์</label><span id="span-zipcode">{{ $user->profile->zipcode }}</span>
                <a class="btn-edit" data-toggle="collapse" href="#collapse-postcode"
                   aria-expanded="false">แก้ไข</a>
            </p>
            <div class="collapse" id="collapse-postcode">
                <div class="col-md-8 col-xs-12">
                    <input type="text" class="form-control" id="zipcode" placeholder="เช่น 41100"
                           value="{{ $user->profile->zipcode }}">
                </div>
                <div class="col-md-4 col-xs-12">
                    <button id="btn-save-postcode" type="submit" data-input="profile|zipcode|text"
                            class="btn btn-primary btn-save">บันทึก
                    </button>
                </div>
            </div>
            <div class="col-sm-12 box-checkbox">
                <span><input type="checkbox" id="show_address"
                             data-input="option|show_address|checkbox"
                            {{ $user->option->show_address ? 'checked' : '' }}>แสดงข้อมูลที่อยู่นี้แบบสาธารณะ</span>

            </div>
        -->
        @else
            @if($user->option->show_address)
                <p><label class="account-title">ที่อยู่</label>{{ $user->profile->address }}</p>
                <p><label class="account-title">อาคาร/ที่พัก</label>{{ $user->profile->building }}</p>
                <p><label class="account-title">เขต/อำเภอ</label>{{ $user->profile->district }}</p>
                <p><label class="account-title">จัหวัด</label>{{ $user->profile->province }}</p>
                <p><label class="account-title">รหัสไปรษณีย์</label>{{ $user->profile->zipcode }}
                @endif
        @endif
    </div>
@stop
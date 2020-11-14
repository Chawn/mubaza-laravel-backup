@extends('manager.layouts.master')
@section('script')
    <script src="{{ asset('js/hashids.min.js') }}"></script>
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
    </style>
@stop
@section('content')
    <div class="row">
        @include('manager.register.registration-step', ['step' => '2'])
        <div class="col-sm-6 col-sm-offset-3">
            <div class="box-create box-border">
                <div class="box-header">

                </div>
                <div class="box-body">
                    @foreach ($errors->all() as $error)
                        <p class="alert alert-warning">{{ $error }}</p>
                    @endforeach
                    <form id="information-form" method="post"
                          action="{{ action('AssociateController@postRegisterInformation') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="username">รูปภาพโปรไฟล์</label>
                                <img src="{{ $user->avatar }}" alt="">
                            <input type="file" id="avatar" placeholder="รูปภาพโปรไฟล์" name="avatar" {{ $user->avatar == '' ? 'required' : '' }}>
                        </div>
                        <div class="form-group">
                            <label for="full_name">ชื่อ-นามสกุล</label>
                            <input type="text" class="form-control" id="full_name" placeholder="ชื่อ-นามสกุล"
                                   name="full_name" required value="{{ $user->full_name }}">
                            <p class="help-block">ชื่อ-นามสกุลต้องมีความยาวไม่น้อยกว่า 6 ตัวอักษร ห้ามมีตัวอักษรพิเศษ เช่น -, _,*,  ฯลฯ</p>
                        </div>
                        <div class="form-group">
                            <label for="username">นามปากกา (ใช้แสดงผล)</label>
                            <input type="text" class="form-control" id="username" placeholder="Display Name"
                                   name="username" required value="{{ $user->username }}">
                            <p class="help-block">นามปากกาใช้ได้เฉพาะตัวอักษรภาษาอังกฤษและตัววเลขเท่านั้น ห้ามมีตัวอักษรพิเศษ เช่น -, _,*,  ฯลฯ</p>
                        </div>
                        <div class="form-group">
                            <label for="email">อีเมล์</label>
                            <input type="text" class="form-control" id="email" placeholder="เมล์" name="email"
                                   required value="{{ $user->email }}">
                        </div>
                        <div class="form-group">
                            <label for="username">อธิบายเกี่ยวกับคุณ</label>
                            <textarea name="detail" class="form-control" id="detail" cols="30" rows="5"
                                      required>{{ $user->detail }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="address">ที่อยู่</label>
                            <input type="text" class="form-control" id="address"
                                   placeholder="บ้านเลขที่, หมู่ที่, ถนน, ซอย, ตำบล" name="address" required value="{{ $user->profile->address }}">
                        </div>
                        <div class="form-group">
                            <label for="building">อาคาร</label>
                            <input type="text" class="form-control" id="building" placeholder="อาคาร" name="building" value="{{ $user->profile->building }}">
                        </div>
                        <div class="form-group">
                            <label for="district">เขต/อำเภอ</label>
                            <input type="text" class="form-control" id="district" placeholder="เขต/อำเภอ" name="district"
                                   required value="{{ $user->profile->district }}">
                        </div>
                        <div class="form-group">
                            <label for="province">จังหวัด</label>
                            <select name="province" id="province" class="form-control" id="province"
                                    required>
                                @foreach(Config::get('constant.provinces') as $province)
                                    <option value="{{ $province }}" {{ $user->profile->province == $province ? 'selected' : ''}}>{{ $province }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="zipcode">รหัสไปรษณีย์</label>
                            <input type="text" class="form-control" id="zipcode" placeholder="รหัสไปรษณีย์"
                                   name="zipcode" required value="{{ $user->profile->zipcode }}">
                        </div>
                        <div class="form-group">
                            <label for="phone">เบอร์โทรศัพท์</label>
                            <input type="text" class="form-control" id="phone" placeholder="Phone" name="phone"
                                   required value="{{ $user->profile->phone }}">
                        </div>
                        <hr>
                        <p class="text-center">
                            <button type="submit" id="register-btn" class="btn btn-success btn-lg btn-block">
                                บันทึกข้อมูล
                            </button>
                        </p>
                    </form>

                </div>
            </div>
        </div>
    </div>
    </div>
@stop
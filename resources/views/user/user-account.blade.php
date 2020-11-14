@extends('user.layouts.master')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/jquery.fs.dropper.min.css') }}">

    <style>
        #modal-show-qrcodeline .modal-header {
            border-bottom: 1px solid #ddd;
        }

        #modal-show-qrcodeline .modal-body {
            background: #fff;
            text-align: center;
        }

        #modal-show-qrcodeline .modal-body img {
            width: 100%;
        }

        img#show-qrcode {
            width: 100px;
        }

        .form-horizontal .control-label {
            text-align: left;
        }

        .file-pic {
            float: right;
        }

        .form-control[readonly] {
            background: #fff;
            border: none;
            border-bottom: 1px solid #ddd;
        }

        .a-edit {
            font-size: 14px;
        }

        .radio label {
            margin-right: 15px;
            width: 100px;
        }

        @media (max-width: 480px) {
            .user-sub-account-menu {
                display: none;
            }

            #btn-save-password {
                float: left;
            }

            .wrapper {
                width: 100%;
            }

        }

        #show-profile-img {
            max-width: 300px;
        }
    </style>
@stop
@section('script')
    <script src="{{ asset('js/jquery.fs.dropper.min.js') }}"></script>
    <script src="{{ asset('js/profile.js') }}"></script>
    <script type="text/javascript">
        $(function () {

            $("p.linetext").mouseover(function (event) {
                $(this).find('.btn-edit').removeClass('hide');
                $(this).mouseout(function (event) {
                    $(this).find('.btn-edit').addClass('hide');
                });
            });
            $(".drop").dropper({
                        action: $('.drop').data('url'),
                        label: 'ลากและวางไฟล์ หรือ คลิกเพื่อเลือก',
                        postData: {_token: $('.drop').data('token')}
                    })
                    //                    .on("start.dropper", onStart)
                    .on("complete.dropper", onComplete)
                    .on("fileStart.dropper", onFileStart)
                    .on("fileProgress.dropper", onFileProgress)
                    .on("fileComplete.dropper", onFileComplete)
//                    .on("fileError.dropper", onFileError);

            function onFileStart() {
                $('.progress').addClass('show');
                $('.progress').removeClass('hide');
                $('.progress-bar').width('0%');
            }

            function onComplete() {
            }

            function onFileProgress(e, file, percent) {
                $('.progress-bar').width(percent + '%');
            }

            function onFileComplete(e, file, response) {
                $('.progress').addClass('hide');
                $('.progress').removeClass('show');
                console.log(response);
                if (response.error) {
                    console.log(response);
                } else {
                    document.location.reload();
                }

            }

            $('#birthday').datetimepicker({
                format: 'DD/MM/YYYY',
                locale: 'th'
            });
            $('#icon-birthdate').datetimepicker({
                format: 'DD mm YYYY',
                locale: 'th'
            });
        });

        $(document).ready(function () {
            $('.save-data').click(function () {
                save_profile($(this).data('input'));
            });
        });
    </script>
@stop
@section('content')

    <div class="box">
        <!-- Profile -->
        @if(\Auth::user()->check() && \Auth::user()->user()->isOwner($user->id))

                <!--
                <div class="col-sm-6 col-xs-12" >
                    <label class="">รูปโปรไฟล์</label>
                    <div class="text-center">
                            <p>
                           <img src="{{ $user->avatar }}" id="show-profile-img">
                            </p>
                        
                            <a id="edit-profile" class="btn btn-default btn-file">
                                เลือกรูปเพื่ออัพโหลด
                                <form id="avatar-form" action="{{ action('UserController@postUploadAvatar', $user->id) }}" method="POST" enctype="multipart/form-data">
                                    <input name="_token" id="token" type="hidden" value="{{ csrf_token() }}"/>
                                    <input type="file" name="avatar_file" class="upload" />
                                </form>
                            </a>
                    </div>
                    <br><br>
                </div>
            -->

        <div class="col-sm-12">
            <div class="text-center">
                <p>
                    <span class="profile-circle profile-circle-lg" >
                        <span class="profile-image" style="background-image:url('{{ asset(Auth::user()->user()->avatar) }}')"></span>
                    </span>
                    
                </p>
                <form id="avatar-form" action="{{ action('UserController@postUploadAvatar', $user->id) }}" method="POST" enctype="multipart/form-data">
                {!! csrf_field() !!}
                    <input type="file" name="avatar_file" id="input-avatar" class="inputfile" />
                </form>
                <label id="label-avatar" for="input-avatar">
                    เปลี่ยนรูปโปรไฟล์
                </label>
            </div>
            <form id="form-user-contact" method="post"
                  action="{{ action('UserController@postUpdateContact', \Auth::user()->user()->id) }}">
                {!! csrf_field() !!}

                <div class="form-group">
                    <label class="account-title">ชื่อและนามสกุล</label>
                    <input type="text" class="profile-editor form-control" id="full-name" name="full_name"
                           placeholder="ชื่อและนามสกุล" value="{{ $user->full_name }}" required>
                </div>
                <div class="form-group">
                    <label class="account-title">ชื่อผู้ใช้</label>
                    <input type="text" class="profile-editor form-control" id="username" name="username"
                           placeholder="ชื่อผู้ใช้" value="{{ $user->username }}">
                </div>
                <div class="form-group">
                    <label class="account-title">อีเมล์</label>
                    <input type="email" class="profile-editor form-control" id="email" name="email" placeholder="อีเมล์"
                           value="{{ $user->email }}" required>
                </div>
                <div class="form-group">
                    <label class="account-title">หมายเลขโทรศัพท์</label>
                    <input type="text" class="profile-editor form-control" id="phone" name="phone"
                           value="{{ $user->profile->phone }}" placeholder="หมายเลขโทรศัพท์" required>
                </div>
                <div class="form-group">
                    <label class="account-title">เพศ</label>
                    <div class="radio">
                        <label>
                            <input type="radio" name="sex" id="male" value="m" {{ $user->sex == 'm' ? 'checked' : ''}}>
                            ชาย
                        </label>
                        <label>
                            <input type="radio" name="sex" id="female"
                                   value="f" {{ $user->sex == 'f' ? 'checked' : '' }}> หญิง
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="birthdate" class="account-title">วัน/เดือน/ปี เกิด</label>
                    <input id="birthday" type="text" class="date-picker form-control" name="birthday"
                           placeholder="วัน/เดือน/ปี เกิด" value="{{ $user->profile->birthday->format('d/m/Y') }}"/>
                </div>
                <div class="form-group">
                    <label class="account-title">ที่อยู่</label>
                    <input type="text" class="profile-editor form-control" id="address" name="address"
                           placeholder="เช่น 123 หมู่ 4 ซอย 5 ต.หนองบัว" value="{{ $user->profile->address }}">
                </div>
                <div class="form-group">
                    <label class="account-title">อาคาร/ที่พัก</label>
                    <input type="text" class="profile-editor form-control" id="building" name="building"
                           placeholder="เช่น อาคารมูบาซ่า" value="{{ $user->profile->building }}">
                </div>
                <div class="form-group">
                    <label class="account-title">เขต/อำเภอ</label>
                    <input type="text" class="profile-editor form-control" id="district" name="district"
                           placeholder="เขต/อำเภอ" value="{{ $user->profile->district }}">
                </div>
                <div class="form-group">
                    <label class="account-title">จังหวัด</label>
                    <input type="text" class="profile-editor form-control" id="province" name="province"
                           placeholder="เช่น อุดรธานี"
                           value="{{ $user->profile->province }}">
                </div>
                <div class="form-group">
                    <label class="account-title">รหัสไปรษณีย์</label>
                    <input type="text" class="profile-editor form-control" id="zipcode" name="zipcode"
                           placeholder="เช่น 41100"
                           value="{{ $user->profile->zipcode }}">
                </div>
                <div id="save-usercontact" class="form-group text-center">
                    <button type="reset" class="btn btn-default btn-cancel">ยกเลิก</button>
                    <button type="submit" class="btn btn-success">บันทึก</button>
                </div>
            </form>
        </div>
        @endif
    </div>
@stop
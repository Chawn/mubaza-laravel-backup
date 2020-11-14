@extends('layouts.user-profile')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/user-account.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.fs.dropper.min.css') }}">
    <style>
    #modal-show-qrcodeline .modal-header{
        border-bottom: 1px solid #ddd;
    }
    #modal-show-qrcodeline .modal-body{
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
        .box {
            width: 90%;
            margin: 0 auto;
        }
        .wrapper {
            width: 300px;
            min-height: 150px;
        }
        @media (max-width: 480px){
            .user-sub-account-menu {
                display: none;
            }
            #btn-save-password{
                float: left;
            }
            .wrapper{
                width: 100%;
            }

        }
    </style>
@stop
@section('script')
    <script src="{{ asset('js/jquery.fs.dropper.min.js') }}"></script>
    <script src="{{ asset('js/profile.js') }}"></script>
    <script type="text/javascript">
        $(function () {

            $("p.linetext").mouseover(function(event) {
                $(this).find('.btn-edit').removeClass('hide');
                $(this).mouseout(function(event) {
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
                if(response.error) {
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
            <h4 class="sub-title"><strong>ข้อมูลพื้นฐานและโปรไฟล์</strong></h4>
            <div class="col-sm-12 col-xs-12" style="text-align:center;">
                <div id="show-profile">
                    <img src="{{ $user->avatar }}" id="show-profile-img">
                </div>
                <a id="edit-profile" class="btn btn-default">อัพโหลดรูปโปรไฟล์
                    <form id="avatar-form" action="{{ action('UserController@postUploadAvatar', $user->id) }}" method="POST" enctype="multipart/form-data">
                        <input name="_token" id="token" type="hidden" value="{{ csrf_token() }}"/>
                        <input type="file" name="avatar_file" class="upload" />
                    </form>
                </a>
            </div>

            <p class="linetext">
                <label class="account-title">ชื่อ - สกุล</label><span id="span-full_name" class="hide-overflow">{{ $user->full_name }}</span>
                <a class="btn-edit hide" data-toggle="collapse" href="#collapse-name" aria-expanded="false"><i class="fa fa-pencil"></i> แก้ไข</a>
            </p>
            <div class="collapse" id="collapse-name">
                <div class="col-sm-8 col-xs-12">
                    <input type="text" class="form-control" name="full_name" id="full_name"
                           placeholder="ชื่อ - สกุล" value="{{ $user->full_name }}" maxlength="120">
                </div>
                <div class="col-sm-4 col-xs-12">
                    <button id="btn-save-name" type="submit"
                            data-input="user|full_name|text,option|show_full_name|checkbox"
                            class="save-data btn btn-primary btn-save">บันทึก
                    </button>
                </div>
                <div class="col-sm-12 box-checkbox">
                <span><input type="checkbox" id="show_full_name" name="show_full_name"
                             value="test" {{ $user->option->show_full_name ? 'checked' : '' }}>แสดงข้อมูลนี้แบบสาธารณะ</span>
                </div>
            </div>
            <p class="linetext">
                <label class="account-title">ชื่อแทน</label>
                <span id="span-username" class="hide-overflow">{{ $user->username === null ? '-' : $user->username }}</span>
                <a class="btn-edit hide" data-toggle="collapse" href="#collapse-username"
                   aria-expanded="false"><i class="fa fa-pencil"></i> แก้ไข</a>
            </p>
            <div class="collapse" id="collapse-username">
                <div class="col-sm-8 col-xs-12">
                    <input type="text" class="form-control" placeholder="ชื่อที่ใช้แสดง" id="username"
                           value="{{ $user->username === null ? '' : $user->username }}" maxlength="80">
                </div>
                <div class="col-sm-4 col-xs-12">
                    <button id="btn-save-username" type="submit" data-input="user|username|text"
                            class="save-data btn btn-primary btn-save">บันทึก
                    </button>
                </div>
            </div>
            <p class="linetext">
                <label class="account-title">ชื่อ URL ที่ใช้แสดง</label>
                <span id="span-url" class="hide-overflow">
                    @if($user->url!=null)
                    <a href="{{ $user->url }}" title="">{{ url('/user') }}/{{ $user->url }}
                    </a>
                    @else
                        -
                    @endif
                </span>
                <a class="btn-edit hide" data-toggle="collapse" href="#collapse-url"
                   aria-expanded="false"><i class="fa fa-pencil"></i> แก้ไข</a>
            </p>
            <div class="collapse" id="collapse-url">
                <div class="col-sm-8 col-xs-12">
                    <input type="text" class="form-control" placeholder="{{ config('profile.sitename') }}/URL" id="url"
                           value="{{ $user->url === null ? '' : $user->url }}" maxlength="40">
                </div>
                <div class="col-sm-4 col-xs-12">
                    <button id="btn-save-url" type="submit" data-input="user|url|url"
                            class="save-data btn btn-primary btn-save">บันทึก
                    </button>
                </div>
            </div>

            <p class="linetext">
                <label class="account-title">อธิบายเกี่ยวกับคุณ</label>
                <span id="span-detail" class="hide-overflow">{{ $user->detail === '' ? '-' : $user->detail }}</span>
                <a class="btn-edit hide" data-toggle="collapse" href="#collapse-detail"
                   aria-expanded="false"><i class="fa fa-pencil"></i> แก้ไข</a>
            </p>
            <div class="collapse" id="collapse-detail">
                <div class="col-sm-8 col-xs-12">
                    <input type="text" class="form-control" id="detail" placeholder="อธิบายสั้นๆ เกี่ยวกับคุณ"
                           value="{{ $user->detail === null ? '' : $user->detail }}" maxlength="255">
                </div>
                <div class="col-sm-4 col-xs-12">
                    <button id="btn-save-detail" type="submit" data-input="user|detail|text"
                            class="save-data btn btn-primary btn-save">บันทึก
                    </button>
                </div>
            </div>
    <!-- End Profile -->
    <!-- Contact -->
        <h4 class="sub-title"><strong>ข้อมูลการติดต่อ</strong></h4>
        <p class="linetext">
            <label class="account-title">อีเมล์</label><span id="span-email" class="hide-overflow">{{ $user->email }}</span>
            <a class="btn-edit hide" data-toggle="collapse" href="#collapse-email"
               aria-expanded="false"><i class="fa fa-pencil"></i> แก้ไข</a>
        </p>
        <p class="linetext">
            <label class="account-title">หมายเลขโทรศัพท์</label>
            <span class="hide-overflow">{{ $user->profile->phone }}</span>
            <a class="btn-edit hide" data-toggle="collapse" href="#collapse-phone" aria-expanded="false"><i class="fa fa-pencil"></i> แก้ไข</a>
        </p>
        <div class="collapse" id="collapse-phone">
            <div class="col-md-8 col-xs-12">
                <input type="text" class="form-control" id="phone" value="{{ $user->profile->phone }}" placeholder="">
            </div>
            <div class="col-md-4 col-xs-12">
                <button id="btn-save-phone" type="submit" data-input="profile|phone|text" class="btn btn-primary save-data btn-save">บันทึก</button>
            </div>
        </div>

        <!-- Address -->
            <p class="linetext">
                <label class="account-title">ที่อยู่</label><span id="span-address">{{ $user->profile->address }}</span>
                <a class="btn-edit" data-toggle="collapse" href="#collapse-address"
                   aria-expanded="false"><i class="fa fa-pencil"></i> แก้ไข</a>
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
            <p class="linetext"><label class="account-title">อาคาร/ที่พัก</label><span id="span-building">{{ $user->profile->building }}</span>
                <a class="btn-edit hide" data-toggle="collapse" href="#collapse-building"
                   aria-expanded="false"><i class="fa fa-pencil"></i> แก้ไข</a>
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
            <p class="linetext"><label class="account-title">อำเภอ</label><span id="span-district">{{ $user->profile->district }}</span>
                <a class="btn-edit hide" data-toggle="collapse" href="#collapse-district"
                   aria-expanded="false"><i class="fa fa-pencil"></i> แก้ไข</a>
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
            <p class="linetext"><label class="account-title">จังหวัด</label><span id="span-province">{{ $user->profile->province }}</span>
                <a class="btn-edit hide" data-toggle="collapse" href="#collapse-province"
                   aria-expanded="false"><i class="fa fa-pencil"></i> แก้ไข</a>
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
            <p class="linetext"><label class="account-title">รหัสไปรษณีย์</label><span id="span-zipcode">{{ $user->profile->zipcode }}</span>
                <a class="btn-edit hide" data-toggle="collapse" href="#collapse-postcode"
                   aria-expanded="false"><i class="fa fa-pencil"></i> แก้ไข</a>
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
        <!-- End Address -->

        <!-- Social -->
            <p class="linetext">
                <label class="account-title account-social">
                    Facebook
                </label>
                <span class="hide-overflow">
                    <a href="{{ $user->profile->facebook }}" target="_blank">
                        {{ $user->profile->facebook }}
                    </a>
                </span>
                <a class="btn-edit hide" data-toggle="collapse" href="#collapse-facebook" aria-expanded="false"><i class="fa fa-pencil"></i> แก้ไข</a>
            </p>
            <div class="collapse" id="collapse-facebook">
                <div class="col-md-8 col-xs-12">
                    <input type="text" class="form-control" id="facebook" value="{{ $user->profile->facebook }}" placeholder="ป้อน url เช่น https://www.facebook.com/MUBAZA">
                </div>
                <div class="col-md-4 col-xs-12">
                    <button id="btn-save-facebook" type="submit" data-input="profile|facebook|text" class="btn btn-primary save-data btn-save">บันทึก</button>
                </div>
            </div>

            <p class="linetext">
                <label class="account-title account-social">
                    Twitter
                </label>
                <span class="hide-overflow">
                    <a href="{{ $user->profile->twitter }}" target="_blank">
                        {{ $user->profile->twitter }}
                    </a>
                </span>
                <a class="btn-edit hide" data-toggle="collapse" href="#collapse-line-id" aria-expanded="false"><i class="fa fa-pencil"></i> แก้ไข</a>
            </p>
            <div class="collapse" id="collapse-line-id">
                <div class="col-md-8 col-xs-12">
                    <input type="text" class="form-control" id="twitter" value="{{ $user->profile->twitter }}" placeholder="ป้อน url เช่น https://twitter.com/MUBAZA">
                </div>
                <div class="col-md-4 col-xs-12">
                    <button id="btn-save-twitter" type="submit" data-input="profile|twitter|text" class="btn btn-primary btn-save save-data">บันทึก</button>
                </div>
            </div>

            <p class="linetext">
                <label class="account-title account-social">Line ID</label>
                <span class="hide-overflow">
                    <a href="http://line.me/ti/p/%40{{ '@' . $user->profile->line_id }}" target="_blank">
                        {{ $user->profile->line_id }}
                    </a>
                </span>
                <a class="btn-edit hide" data-toggle="collapse" href="#collapse-twitter" aria-expanded="false"><i class="fa fa-pencil"></i> แก้ไข</a>
            </p>
            <div class="collapse" id="collapse-twitter">
                <div class="col-md-8 col-xs-12">
                    <input type="text" class="form-control" id="line_id" value="{{ $user->profile->line_id }}" placeholder="ป้อน Line ID">
                </div>
                <div class="col-md-4 col-xs-12">
                    <button id="btn-save-twitter" type="submit" data-input="profile|line_id|text" class="btn btn-primary btn-save save-data">บันทึก</button>
                </div>
            </div>

            <p class="linetext">
                <label class="account-title account-social">
                    Line QR Code
                </label>
                <span class="hide-overflow">
                    @if($user->profile->line_qr)
                    <img id="show-qrcode" src="{{ url('/') . '/' . $user->profile->line_qr }}" >
                        <a href="{{ action('UserController@getDeleteLineQR', $user->getID()) }}">ลบ</a>
                    @endif
                </span>
                <a class="btn-edit hide" data-toggle="collapse" href="#collapse-line" aria-expanded="false"><i class="fa fa-pencil"></i> แก้ไข</a>
             </p>
            <div class="collapse" id="collapse-line">
                <div class="col-md-3">
                </div>
                <div class="col-md-9">
                    <div class="wrapper upload">
                        <div class="text-center">
                            <div class="progress hide">
                                <div class="progress-bar progress-bar-success progress-bar-striped"
                                     role="progressbar" aria-valuenow="40" aria-valuemin="0"
                                     aria-valuemax="100" style="width: 0%;">
                                </div>
                            </div>
                            <div class="drop"
                                 data-token="{{ csrf_token() }}"
                                 data-url={{ action('UserController@postUploadLineQR', $user->id) }}></div>
                        </div>
                    </div>

                </div>
            </div>

            <p class="linetext">
                <label class="account-title">Website</label>
                <span class="hide-overflow">
                    <a href="{{ $user->profile->website }}">{{ $user->profile->website}}
                    </a>
                </span>
                <a class="btn-edit hide" data-toggle="collapse" href="#collapse-website" aria-expanded="false"><i class="fa fa-pencil"></i> แก้ไข</a>
            </p>
        <!-- End Social -->
        <div class="collapse" id="collapse-email">
            <div class="col-sm-12 col-xs-12">
                @if(is_null($user->password))
                    <p class="linetext">คุณต้องตั้งค่ารหัสผ่านก่อนที่จะดำเนินการเปลี่ยนข้อมูลอีเมล์</p>
                    @else
                <form class="form-horizontal" method="POST"
                      action="{{ action('UserController@postChangeEmail', $user->id) }}">
                    <div class="form-group">
                        <label class="col-sm-2" for="email">อีเมล์</label>
                        <div class="col-sm-8">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                            <input type="email" class="form-control" id="email" name="email" placeholder="อีเมล์" value="{{ $user->email }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2" for="email-old-pasword">รหัสผ่าน</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="email-old-password" name="password" placeholder="กรุณากรอกรหัสผ่าน" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-2">
                            <span>
                                <input type="checkbox" name="show_email"
                                       id="show_email" {{ $user->option->show_email ? 'checked' : '' }}>แสดงข้อมูลนี้แบบสาธารณะ
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-8 col-md-offset-2">
                            <button id="btn-save-email" type="submit"
                                    class="save-data btn btn-primary btn-save">บันทึก
                            </button>
                        </div>
                    </div>
                </form>
                    @endif
            </div>
        </div>
    <!-- End Contact -->
        
        @endif
    </div>
@stop
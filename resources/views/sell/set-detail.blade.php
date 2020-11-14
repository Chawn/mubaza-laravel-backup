@extends('layouts.full_width')
@section('script')
    <script src="{{ asset('js/hashids.min.js') }}"></script>
    <script src="{{ asset('js/validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/validate/localization/messages_th.min.js') }}"></script>
    <script src="{{ asset('ckeditor-custom/ckeditor.js') }}"></script>
    <script src="{{ asset('js/selectize/selectize.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $("#toggle-location").click(function () {
                $("#front").toggleClass('hidden');
                $("#back").toggleClass('hidden');
                $(".toggle-look").toggleClass('hidden');
            });

            loadCampaign();
            $('#campaign-detail').validate({
                errorPlacement: function (error, element) {
                    // Append error within linked label
                    $(element).addClass('error');
                }
            });

            $('#save-campaign').click(function () {
                var btn = $(this);
                if ($('#agree-tos').prop('checked')) {
                    if (CKEDITOR.instances.description.getData() != "") {
                        if ($('#tags').val() != "") {
                            if ($('#campaign-detail').valid()) {
                                    $(this).attr('disabled', 'disabled');
                                    $(this).html('<i class="fa fa-spinner fa-pulse"></i>&nbsp;กรุณารอสักครู่');
                                    var hash_id = getHashID();
                                    var key = hash_id[0] + '/' + hash_id[1];
                                    var campaign = parseOut(key);
                                    campaign.campaign.title = $('#title').val();
                                    campaign.campaign.back_cover = $('input[name=back_cover]:checked').val();
                                    campaign.campaign.description = CKEDITOR.instances.description.getData();
                                    campaign.campaign.url = $('#url').val();
                                    var tags = $('#tags').val().split(",");
                                    var tag_array = [];
                                    $.each(tags, function (k, v) {
                                        tag_array.push(v);
                                    });

                                    campaign.campaign.tags = tag_array;
                                    var next_key = hash_id[0] + '/' + (parseInt(hash_id[1]) + 1);
                                    parseIn(next_key, campaign);
                                    setUrl(next_key);
                                    $.ajax({
                                        type: "POST",
                                        url: "/campaign/save",
                                        data: {
                                            _token: $('#token').val(),
                                            campaign: campaign.campaign
                                        },
                                        dataType: "json",
                                        success: function (data) {
                                            if (data.success) {
                                                window.location = data.redirect_url;
                                            }
                                            else {
                                                alert(data.message);
                                            }

                                            if (data.error) {
                                                alert(data.message);
                                            }
                                            btn.removeAttr('disabled');
                                            btn.html('<i class="fa fa-check"></i>&nbsp;ต่อไป');
                                        },
                                        failure: function (errMsg) {
                                            alert(errMsg);
                                        }
                                    })
                            }
                        }
                        else {
                            alert('กรุณาใส่แทกสำหรับแคมเปญนี้ด้วย');
                        }
                    } else {
                        alert('กรุณาใส่รายละเอียดสำหรับแคมเปญนี้ด้วย');
                    }
                }
                else {
                    alert('คลิ๊กเพื่อยอมรับข้อตกลงสำหรับการใช้งาน');
                }
            });

            $('#tags').selectize({
                delimiter: ',',
                persist: false,
                create: function (input) {
                    return {
                        value: input,
                        text: input
                    }
                }
            });

            function parseOut(key) {
                return JSON.parse(localStorage.getItem(key));
            }

            function parseIn(key, data) {
                localStorage.setItem(key, JSON.stringify(data))
            }

            function setUrl(key) {
                window.location.hash = "!/" + key;
            }

            function getHashID() {
                var url_hash = window.location.hash;
                var key = '';
                var hash_id = new Hashids("mubaza");
                if (url_hash == "") {
                    key = hash_id.encode(Date.now());
                    return [key, 0];
                }
                else {
                    var url_split = url_hash.split('/');
                    return [url_split[1], url_split[2]];
                }
            }

            function loadCampaign() {
                var hash_id = getHashID();
                var key = hash_id[0] + '/' + hash_id[1];
                var campaign = parseOut(key);

                $('#title').val(campaign.campaign.title);
                CKEDITOR.instances.description.setData(campaign.campaign.description);
//                $('#back_cover').prop('checked', campaign.campaign.back_cover);
                $('#main-product #front').html('<img src="/' + campaign.campaign.base_folder + campaign.campaign.thumbnail_front + '" />');
                $('#main-product #back').html('<img src="/' + campaign.campaign.base_folder + campaign.campaign.thumbnail_back + '" />');
                $('#img-front-product').attr('src', '/' + campaign.campaign.base_folder + campaign.campaign.thumbnail_mini_front);
                $('#img-back-product').attr('src', '/' + campaign.campaign.base_folder + campaign.campaign.thumbnail_mini_back);
                var tag = "";
                $.each(campaign.campaign.tags, function (k, v) {
                    if (k == 0) {
                        tag += v;
                    }
                    else {
                        tag += "," + v;
                    }
                });

                $('#tags').val(tag);
                if($('#login-link') != undefined) {
                    $('#login-link').attr('href', $('#login-link').attr('href') + "&key=" + key);
                }
            }

            $('#img-front-product').click(function () {
                $('#back').addClass('hidden');
                $('#front').removeClass('hidden');
            });
            $('#img-back-product').click(function () {
                $('#front').addClass('hidden');
                $('#back').removeClass('hidden');
            });
        });
    </script>
@stop
@section('css')
    <link rel="stylesheet" href="{{ asset('css/selectize/selectize.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/selectize/selectize.bootstrap3.css') }}"/>
    <style type="text/css" media="screen">
        .cke_chrome {
            display: block;
            border: none !important;
            border-radius: 4px;
            padding: 0 !important;
            background: #EEE;
        }

        .cke_toolbar_break {
            display: block;
            clear: none !important;
        }

        .cke_bottom, .cke_top {
            background: #f5f5f5 !important;
        }

        .error {
            border: 1px solid #ff0000;
        }

        .input-price {
            width: 55px !important;
            padding: 5px 0 5px 5px;
        }

        .column {
            vertical-align: middle;
            padding: 1px;
        }

        .col-image {
            width: 45px;
        }

        .col-color {
            width: 40px;
        }

        .col-name {
            width: 110px;
        }

        .col-price {
            width: 60px;
        }

        .col-profit {
            width: 60px;
            text-align: center;
        }

        .col-trash {
            margin-left: 10px;
        }

        .col-cat-option {
            width: 110px;
        }

        .col-product-option {
            width: 180px;
        }

        #main-product {

        }

        #main-product img {
            max-width: 100%;
        }

        #main-product img#preview {
            position: absolute;
            z-index: 1;
        }

        #set-goal .profit {

        }

        .profit-total {
            font-size: 30px;
        }

        .set-goal-table .topic {
            width: 120px;
        }

        #product-selected .column {
            display: table-cell;
        }
    </style>
@stop
@section('content')
    <div id="set-goal">
        <h1>{{  $title }}</h1>
        <input name="_token" type="hidden" id="token" value="{{ csrf_token() }}"/>

        <div class="row">
            <div class="col-md-6">
                <div id="main-product">
                    <div id="front"></div>
                    <div id="back" class="hidden"></div>
                </div>
                <div id="toggle-location">
                    <div class="toggle-look">
                        ดูด้านหลัง
                    </div>
                    <div class="toggle-look hidden">
                        ดูด้านหน้า
                    </div>
                    <img class="look-back" src="{{ asset('images/icon/look-back.png') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="box">
                    <div class="wrapper">
                        <div class="title">รายละเอียดสินค้า</div>
                        <div class="detail">
                            <form id="campaign-detail" method="GET">
                                <table>
                                    <tr>
                                        <td>
                                            <b>ชื่อแคมเปญ</b>
                                            <span class="badge"><i class=" fa fa-question"></i></span>
                                            <input type="text" id="title" class="form-control" required>
                                            <span>สรุปแคมเปญของคุณใน 40 ตัวอักษรหรือน้อยกว่า</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b class="">คำอธิบาย</b>
                                        <textarea name="description" id="description" class="form-control description"
                                                  rows="3" required></textarea>
                                            <script>
                                                CKEDITOR.replace('description');
                                            </script>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>

                                            <b>แท็ก</b>
                                            <input type="text" class="form-control" id="tags" name="tags" required>
                                            <span>แท็กผลิตภัณฑ์ของคุณ จะช่วยให้ลูกค้าค้นหาเจอได้ง่ายบนเว็บของเรา และจากเว็บค้นหาอื่นๆ (เช่น แมว, จักรยาน, ท่องเที่ยว)</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>ตัวเลือกการแสดง</b>
                                            </td>
                                        <tr>
                                        <td><label for="front_cover">
                                                <input type="radio" name="back_cover" id="front_cover" value="0" checked>
                                                แสดงด้านหน้าเป็นค่าปริยาย
                                            </label></td>
                                    </tr>
                                    <tr>
                                        <td><label for="back_cover">
                                                <input type="radio" name="back_cover" id="back_cover" value="1">
                                                แสดงด้านหลังเป็นค่าปริยาย
                                            </label></td>
                                    </tr>

                                </table>
                            </form>
                        </div>

                    </div>

                </div>
                <br>

                <div class="wrapper">
                    <p>
                        <label>
                            <input type="checkbox" id="agree-tos" required>
                            ฉันได้อ่านและตกลงที่จะเงื่อนไขการให้บริการ(Terms)
                            และสามารถยืนยันได้ว่าภาพและเนื้อหาที่ใช้ในแคมเปญของฉัน ไม่ละเมิดสิทธิของบุคคลที่สามใด ๆ
                        </label>
                    </p>

                    <br>
                    <button type="submit"
                            id="save-campaign" class="btn btn-success btn-medium"
                            data-url="{{ action('CampaignController@postSave', 'sell')}}"
                            {{ \Auth::user()->check() ? '' : 'disabled="disabled"' }}><i class="fa fa-check"></i>&nbsp;ต่อไป
                    </button>
                    <span>
                        @if(!\Auth::user()->check())
                            <a href="{{ url('/auth/login') }}?return={{ Request::path() }}"
                               class="login-link">{{ Lang::get('messages.login') }}</a>&nbsp;
                            ระบบเพื่อดำเนินการต่อ</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop
    
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

            var validate = $('#campaign-detail').validate({
                errorPlacement: function (error, element) {
                    // Append error within linked label
                    $(element).addClass('error');
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


            $('#img-front-product').click(function () {
                $('#back').addClass('hidden');
                $('#front').removeClass('hidden');
            });
            $('#img-back-product').click(function () {
                $('#front').addClass('hidden');
                $('#back').removeClass('hidden');
            });

            function escapeRegExp(string) {
                return string.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
            }

            function replaceAll(string, find, replace) {
                return string.replace(new RegExp(escapeRegExp(find), 'g'), replace);
            }
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
        .col-cat-option{
            width: 110px;
        }
        .col-product-option{
            width: 180px;
        }
        #main-product {
            
        }
        #main-product img {
            max-width: 100% ;
        }
        #main-product img#preview {
            position: absolute;
            z-index: 1;
        }
        #set-goal .profit{
            
        }
        .profit-total{
            font-size: 30px;
        }
        .set-goal-table .topic{
            width: 120px;
        }
        #product-selected .column{
            display: table-cell;
        }
    </style>
@stop
@section('content')
    <div id="set-goal">
        <h1>{{  $title }}</h1>
        <div class="row">
            @if($errors->has())
                <div class="alert alert-warning">{{ $errors->first() }}</div>
            @endif
            <div class="col-md-6">
                <div id="main-product">
                    <div id="front" class="{{ ($campaign->back_cover==1) ? 'hidden' : '' }}">
                        <img src="{{ $campaign->design->image_front_preview }}" alt="{{ $campaign->title }}"/>
                    </div>
                    <div id="back" class="{{ ($campaign->back_cover==0) ? 'hidden' : '' }}">
                        <img src="{{ $campaign->design->image_back_preview }}" alt="{{ $campaign->title }}"/>
                    </div>
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
            <form id="campaign-detail" method="POST" action="{{ action('CampaignController@postEditDetail', $campaign->id) }}">
                <input name="_token" type="hidden" id="token" value="{{ csrf_token() }}"/>
                <div class="box">
                    <div class="wrapper">
                        <div class="title">รายละเอียดสินค้า</div>
                        <div class="detail">
                                <table>
                                    <tr>
                                        <td>
                                            <b>ชื่อแคมเปญ</b>
                                            <input type="text" id="title" name="title" class="form-control" value="{{ $campaign->title }}" required>
                                            <span>สรุปแคมเปญของคุณใน 40 ตัวอักษรหรือน้อยกว่า</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b class="">คำอธิบาย</b>
                                        <textarea name="description" id="description" class="form-control description"
                                                  rows="3" required>{{ $campaign->description }}</textarea>
                                            <script>
                                                CKEDITOR.replace('description');
                                            </script>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>

                                            <b>แท็ก</b>
                                            <input type="text" class="form-control" id="tags" name="tags" value="{{ $campaign->allTags() }}">
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
                        </div>

                    </div>

                </div>
                <br>

                <div class="wrapper">
                    <input type="submit" class="btn btn-success btn-medium" value="บันทึก" />
                </div>
                </form>
            </div>
        </div>
    </div>
@stop
    
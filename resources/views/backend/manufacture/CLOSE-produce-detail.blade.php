@extends('backend.layouts.master')
@section('css')
    <style>
        #produce-detail-img {
            max-width: 320px;
        }

        #produce-detail-img img {
            max-width: 320px;
        }

        #produce-detail-header {
            min-height: 100px;
        }

        .produce-detail-name {
            font-size: 24px;
            color: #202020;
            padding: 0px 0 10px 0;
            margin: 0 0 0 0;

        }

        .produce-all-sold {
            font-size: 20px;
            color: #202020;
            padding: 0px 0 10px 0;
            margin: 0 0 0 0;
        }

        .produce-detail-designer {
            font-size: 16px;
            color: #e67e22;
            display: block;
            margin: 5px 0 5px 0;
        }

        .produce-detail-designer:hover {
            color: #e67e22;
        }

        .produce-detail-designer:focus {
            color: #e67e22;
            text-decoration: none;
        }

        .produce-detail-link-collapse {
            font-size: 14px;
            margin: 0px 10px 0 0;
        }

        .produce-detail-link-collapse:hover {

        }

        .produce-detail-link-collapse:focus {

            text-decoration: none;
        }

        .select-status {
            width: 150px;
            height: 35px;
            border: 1px solid #ddd;
        }

        #save-produce-status {
            margin: 0 0 0 15px;
        }

        .well {
            background: transparent;
            border-radius: 0px;
            margin: 5px 0 10px 0;
            min-width: 640px;
        }

        /**/
        .box-produce {
            width: 200px;
            height: 100px;
            border-radius: 5px;
            background: #ccc;
            color: #202020;
            float: left;
            margin-right: 20px;
        }

        .box-produce h2 {
            text-align: center;
        }

        .box-produce p {
            text-align: center;
        }

        #produce-detail-sold {
            min-height: 400px;
        }

        .produce-detail-sold-box {
            min-height: 160px;
            min-width: 400px;
            margin-bottom: 10px;
            padding-top: 5px;
        }

        .produce-detail-sold-icon {
            width: 150px;
            height: 150px;
            text-align: center;
            float: left;
            margin-right: 30px;
        }

        .produce-detail-sold-icon img {
            max-width: 120px;
            max-height: 120px;
            margin-top: 20px;
        }

        .produce-detail-sold-right {
            width: 400px;
            padding-top: 10px;
            float: left;
        }

        .product-type {
            font-size: 20px;
            padding-top: 20px;
        }

        .product-price {
            font-size: 16px;
            margin: 10px 0 10px 0;
        }

        .product-sold {
            font-size: 16px;
        }

        #group-btn-flip {
            margin: 10px 0 0 0;
            text-align: center;
        }

        .btn-backend-flip-img {
            width: 25px;
            height: 25px;
            border-radius: 50%;
            background: #ddd;
            color: #202020;
            border: 1px solid transparent;
            text-align: center;
            vertical-align: middle;
            margin-right: 10px;
            padding: 2px 0 0 0px;
        }

        .btn-backend-flip-img:focus {
            border-radius: 50%;
        }

        .btn-backend-flip-img:active {
            border-radius: 50%;
            border: 1px solid transparent;
        }

        .flip-choose {
            background: #202020;
            color: #fff;
        }

        .flip-choose:hover {
            background: #202020;
            color: #fff;
        }

        .flip-choose:focus {
            background: #202020;
            color: #fff;
        }

        /*ตารางแสดงไซต์ สั่ง*/
        .table-produce-detail-sold {
            margin: 10px 0 20px 0;
            text-align: center;
        }

        .table-produce-detail-sold tr {
            height: 30px;
        }

        .table-produce-detail-sold th {
            text-align: center;
        }

        .table-produce-detail-sold tr td:first-child {
            font-weight: bold;
            text-align: left;
        }

        .table-produce-detail-sold td {
            min-width: 60px;
        }

        #group-btn-download {
            margin: 15px 0 0 0;
            width: 100%;
            height: 60px;
        }

        #group-btn-download i {
            margin: 0 5px 0 0;
        }

        .btn-orenge {
            margin: 0 10px 0 0;
            width: 150px;
            border-bottom: 2px solid #B95E0D;
        }

        .btn-orenge:active {
            border-bottom: 2px solid transparent;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#produce-detail-img-back').hide();
            $("#flip-font").click(function () {
                $("#produce-detail-img-font").show();
                $("#produce-detail-img-back").hide();
            });
            $("#flip-back").click(function () {
                $("#produce-detail-img-font").hide();
                $("#produce-detail-img-back").show();
            });
            $(".btn-backend-flip-img").click(function () {
                $(".btn-backend-flip-img.flip-choose").removeClass("flip-choose");
                $(this).addClass("flip-choose");
            });
            $('#save-campaign-status').click(function () {
                $.ajax({
                    type: "POST",
                    url: $('.select-status').data('url'),
                    data: {
                        "_token": $('#save-status-token').val(),
                        "status_name": $('.select-status').val()
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data.success) {
                            alert(data.message);
                            location.reload();
                        } else {
                            alert(data.message);
                        }
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            });

            $('#download-file').click(function () {
                $.ajax({
                    type: "GET",
                    url: $(this).data('url'),
                    dataType: "json",
                    success: function (data) {
                        if (!data.error) {
                            document.location = data.file_url;
                        } else {
                            alert(data.message);
                        }
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            });
        });
    </script>
@stop
@section('content')
    <div class="col-md-4">
        <div id="produce-detail-img">
            <img id="produce-detail-img-font" src="{{ $campaign->design->image_front_preview }}">
            <img id="produce-detail-img-back" src="{{ $campaign->design->image_back_preview }}">
        </div>
        <div id="group-btn-flip">
            <a id="flip-font" class="btn btn-backend-flip-img flip-choose" href="#">F</a>
            <a id="flip-back" class="btn btn-backend-flip-img " href="#">B</a>
        </div>
    </div>
    <div class="col-md-8">
        <div id="produce-detail-header">
            <h1 class="produce-detail-name">{{ $campaign->title }}</h1>

            <h1 class="produce-all-sold">ยอดรวม&nbsp;{{ $ordered_product['total'] }}&nbsp;ตัว</h1>
            @if($campaign->produce_status->name === 'producing')
                <a class="produce-detail-link-collapse a-link" href="#collapse-produce-edit-status"
                   data-toggle="collapse" aria-expanded="false" aria-controls="collapse-produce-edit-status">แก้ไขสถานะการผลิต</a>
                <div class="collapse" id="collapse-produce-edit-status">
                    <div class="well">
                        <input name="_token" value="{{ csrf_token() }}" }} id="save-status-token" type="hidden"/>
                        <select class="select-status"
                                data-url="{{ action('CampaignController@postSaveStatus', $campaign->id) }}">
                            <option value="waiting">{{ \App\CampaignProduceStatus::whereName('waiting')->first()->detail }}</option>
                            <option value="shipping">{{ \App\CampaignProduceStatus::whereName('shipping')->first()->detail }}</option>
                        </select>
                        <button id="save-campaign-status" class="btn btn-green">บันทึก</button>
                    </div>
                </div>
            @endif
        </div>
        <div id="produce-detail-sold">
            @foreach($ordered_product['items'] as $product)
                <div class="produce-detail-sold-box">
                    <div class="produce-detail-sold-icon">
                        <img src="{{ asset('images/icon/icon-t-shirt.png') }}">
                    </div>
                    <div class="produce-detail-sold-right">
                        <h3 class="product-type">{{ $product['name']  }}</h3>
                        <table class="table-produce-detail-sold">
                            <thead>
                            <tr>
                                <th></th>
                                @foreach(explode(',', $product['available_size']) as $size)
                                    <th>{{ $size }}</th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($product['colors'] as $key => $color)
                                <tr>
                                    <td>{{ $key }}</td>
                                    @foreach(explode(',', $product['available_size']) as $size)
                                        <td>{{ isset($color['sizes'][$size]) ? $color['sizes'][$size] : '0' }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @if($campaign->produce_status->name === 'producing')
        <div class="col-md-12">
            <div id="group-btn-download">
                <a class="btn-orenge" href="javascript:void(0)" id="download-file"
                   data-url="{{ action('BackendController@getCampaignFile', $campaign->id) }}"><i
                            class="fa fa-download"></i></i>ดาวโหลดลาย</a>
                <a class="btn-orenge" href="{{ action('BackendController@getPrintProduceList', $campaign->id) }}"
                   target="_blank">
                    <i class="fa fa-print"></i>พิมพ์ข้อมูลการผลิต</a>
                <a class="btn-orenge" href="{{ action('BackendController@getPrintCustomerAddress', $campaign->id) }}"
                   target="_blank"><i
                            class="fa fa-print"></i>พิมพ์ใบปะหน้าที่อยู่</a>
                <a class="btn-orenge" href="{{ action('BackendController@getPrintCheckListReport', $campaign->id) }}"
                   target="_blank"><i class="fa fa-print"></i>พิมพ์รายการจัดส่ง</a>
            </div>
        </div>
    @endif
@stop
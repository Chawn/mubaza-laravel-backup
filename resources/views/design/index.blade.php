@extends('layouts.full_width')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop
@section('script')
    <script src="{{ asset('js/rotate/jquery.ui.rotatable.js') }}"></script>
    <script src="{{ asset('js/design.js') }}"></script>
    <script src="{{ asset('js/jquery.fs.dropper.min.js') }}"></script>
    <script src="{{ asset('js/hashids.min.js') }}"></script>
    <script src="{{ asset('js/html2canvas.js') }}"></script>
    <script src="{{ asset('js/canvas2image.js') }}"></script>
    <script src="{{ asset('js/spin.js') }}"></script>
    <script src="{{ asset('js/typed.js') }}"></script>
    <script src="{{ asset('js/guessLang/_languageData.js') }}"></script>
    <script src="{{ asset('js/guessLang/guessLanguage.js') }}"></script>
    @if(\Request::is('design'))
        <script src="{{ asset('js/design-order.js') }}"></script>
    @endif
@stop
@section('css')
    <link rel="stylesheet" href="{{ asset('css/design.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.fs.dropper.min.css') }}">

    <style>
        .transparent-border {
            border-color: transparent !important;
        }

        .hide {
            visibility: hidden;
        }

        .show {
            visibility: visible;
        }

        .main {
            padding: 15px 0;
        }

        .modal-body {
            background: #fff;
        }

        .table-form {
            margin-left: auto;
            margin-right: auto;
        }

        .table-form thead tr th {
            border-bottom: 2px solid #555;
        }

        .table-form td, th {
            text-align: center;
            padding: 5px 0;
        }

        .table-form td:first-child, th:first-child {
            text-align: center;
            border-right: 1px solid #989898;
        }

        @media (max-width: 480px) {
            .set-size {
                padding: 2px 6px;
            }

            .table-form > tbody > tr > td:first-child {
                display: table-cell;
            }
        }
    </style>
@stop
@section('content')
    @if(Request::is('design'))
        <input name="campaign_type" id="campaign-type" type="hidden" value="buy"/>
    @elseif(Request::is('sell'))
        <input name="campaign_type" id="campaign-type" type="hidden" value="sell"/>
    @endif

    <input type="hidden" id="error-item-message" value="{{ \Lang::get("messages.design_error_item") }}"/>
    <input type="hidden" id="error-qty-message" value="{{ \Lang::get("messages.design_error_qty") }}"/>
    <input type="hidden" id="root_url" value="{{ url() }}">
    <div class="alert alert-warning text-center mobile-aleart" role="alert">ขออภัย !!!
        หน้าออกแบบยังไม่พร้อมใช้งานในสมาร์ทโฟนและแท็บเล็ต
    </div>
    <div id="design">
        <div id="design-frame">
            <div id="design-wrapper" class="row">
                <div id="col-tee" class="col-md-8 col-xs-12">
                    <div id="custom-area" class="noselect">
                        <div id="location-front" class="custom-frame active">
                            <img id="product-front-now" class="nodrag product-img product-now product-now-front"
                                 src=""
                                 data-product-id="{{ $products->first()->id }}"
                                 data-color="{{ $products->first()->getCover()->color }}"
                                 data-color-id="{{ $products->first()->getCover()->id }}"
                                 data-one-side-price="{{ $products->first()->one_side_price }}"
                                 data-two-side-price="{{ $products->first()->two_side_price }}"
                                 data-size="false"
                                 data-url="{{ action('DesignController@getProductDetail') }}"
                                 data-gen-thmb="{{ action('DesignController@postGenThumbnail') }}">

                            <div class="frame frame-front frame-active hide" style="" data-location="front"
                                 data-url="{{ action('DesignController@postSavePreviewImage') }}"></div>
                        </div>
                        <div id="location-back" class="custom-frame">
                            <img id="product-back-now" class="nodrag product-img product-now product-now-back"
                                 src=""
                                 data-gen-thmb="{{ action('DesignController@postGenThumbnail') }}">

                            <div class="frame frame-back" style="" data-location="back"
                                 data-url="{{ action('DesignController@postSavePreviewImage') }}"></div>
                        </div>
                        <div id="toggle-location">
                            <div class="toggle-look">
                                ดูด้านหลัง
                            </div>
                            <div class="toggle-look hide">
                                ดูด้านหน้า
                            </div>
                            <img class="look-back" src="{{ asset('images/icon/look-back.png') }}">
                        </div>
                    </div>
                </div>
                <div id="col-tool" class="col-md-4 pull-right col-xs-12">
                    <div id="tool-box">
                        <ul id="tabs" class=" nav nav-tabs" role="tablist">
                            <li class="active" role="presentation">
                                <a href="#product-panel" id="tab-product" aria-controls="product" role="tab"
                                   data-toggle="tab">
                                    <img src="images/icon/t-icon.png">

                                    <p>สินค้า</p>
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#text-panel" id="tab-text" aria-controls="text" role="tab" data-toggle="tab">
                                    <span class="icon-tab icon-tab-text fa fa-font"></span>

                                    <p>ข้อความ</p>
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#picture-panel" id="tab-picture" aria-controls="picture" role="tab"
                                   data-toggle="tab">
                                    <span class="icon-tab icon-tab-image fa fa-picture-o"></span>

                                    <p>รูปภาพ</p>
                                </a>
                            </li>
                        </ul>
                        <script>
                            $(function () {
                                $('#tabs a:first').tab('show');
                                $('.tab-content').css('display', 'block');
                                $('#tabs a').click(function (e) {
                                    e.preventDefault();
                                    $(this).tab('show');
                                })
                            })
                        </script>
                        <div id="design-box" role="tabpanel" class="pull-right">
                            <div id="design-content" class="tab-content">
                                <div id="product-panel" role="tabpanel" class="tab-pane active">
                                    <div class="box">
                                        <div class="wrapper">
                                            <div class="title"><b>เลือกสินค้า</b></div>
                                            <select id="select_category" name="select_category" class="form-control">
                                                <option value="all">ทั้งหมด</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->detail }}</option>
                                                @endforeach
                                            </select>
                                            @if(Request::is('design'))
                                                <p>
                                                    <a data-toggle="modal" data-target="#tshirt-size">
                                                        ตารางเปรียบเทียบขนาด
                                                    </a>
                                                </p>
                                            @endif

                                        </div>
                                        <div class="wrapper">
                                            <ul id="product-list" class="product-list list-unstyled"
                                                data-url="{{ action('DesignController@getProductList')  }}">
                                            </ul>
                                        </div>

                                    </div>
                                </div>
                                <div id="text-panel" role="tabpanel" class="tab-pane">
                                    <div class="box">
                                        <div class="wrapper">
                                            <div class="form-group">
                                                <label class="title" for="input-text"><b>ใส่ข้อความ</b></label>
                                                <input type="text" name="input-text" id="input-text"
                                                       class="new-text form-control" placeholder="ใส่ข้อความที่นี่">
                                            </div>
                                        </div>
                                        <div class="wrapper">
                                            <div id="dialog-font" class="design-dialog dialog">
                                                <div class="font-type">
                                                    <select id="select-font-type" class="form-control">
                                                        <option value="all">ทั้งหมด</option>
                                                        <option value="thai">ภาษาไทย</option>
                                                    </select>
                                                </div>
                                                <ul class="font-list all">
                                                    <li><p class="select-font" style="font-family:Aileron-Regular">
                                                            Aileron-Regular</p></li>
                                                    <li><p class="select-font" style="font-family:Aileron-UltraLight">
                                                            Aileron-UltraLight</p></li>
                                                    <li><p class="select-font" style="font-family:AlphaRuler-bold">
                                                            AlphaRuler-bold</p></li>
                                                    <li><p class="select-font" style="font-family:AlphaRuler">
                                                            AlphaRuler</p></li>
                                                    <li><p class="select-font" style="font-family:Anders">Anders</p>
                                                    </li>
                                                    <li><p class="select-font" style="font-family:Bariol_Regular">
                                                            Bariol_Regular</p></li>
                                                    <li><p class="select-font" style="font-family:Baron Neue Bold">Baron
                                                            Neue Bold</p></li>
                                                    <li><p class="select-font" style="font-family:BIG_JOHN">BIG_JOHN</p>
                                                    </li>
                                                    <li><p class="select-font" style="font-family:Biko_Bold">
                                                            Biko_Bold</p></li>
                                                    <li><p class="select-font" style="font-family:Biko_Light">
                                                            Biko_Light</p></li>
                                                    <li><p class="select-font" style="font-family:Biko_Regular">
                                                            Biko_Regular</p></li>
                                                    <li><p class="select-font" style="font-family:Bizon">Bizon</p></li>
                                                    <li><p class="select-font" style="font-family:Building">Building</p>
                                                    </li>
                                                    <li><p class="select-font" style="font-family:Calendas_Plus">
                                                            Calendas_Plus</p></li>
                                                    <li><p class="select-font" style="font-family:Chunkfive">
                                                            Chunkfive</p></li>
                                                    <li><p class="select-font" style="font-family:Dancing Script">
                                                            Dancing Script</p></li>
                                                    <li><p class="select-font" style="font-family:Dense-Regular">
                                                            Dense-Regular</p></li>
                                                    <li><p class="select-font" style="font-family:Distractor-Roman">
                                                            Distractor-Roman</p></li>
                                                    <li><p class="select-font" style="font-family:Duke">Duke</p></li>
                                                    <li><p class="select-font" style="font-family:GoodDelicate">
                                                            GoodDelicate</p></li>
                                                    <li><p class="select-font" style="font-family:Higher">Higher</p>
                                                    </li>
                                                    <li><p class="select-font" style="font-family:Homestead-Inline">
                                                            Homestead-Inline</p></li>
                                                    <li><p class="select-font" style="font-family:Homestead-Regular">
                                                            Homestead-Regular</p></li>
                                                    <li><p class="select-font" style="font-family:Jaapokki-Regular">
                                                            Jaapokki-Regular</p></li>
                                                    <li><p class="select-font" style="font-family:Kankin">Kankin</p>
                                                    </li>
                                                    <li><p class="select-font" style="font-family:KiloGram_KG">
                                                            KiloGram_KG</p></li>
                                                    <li><p class="select-font" style="font-family:Komoda">Komoda</p>
                                                    </li>
                                                    <li><p class="select-font" style="font-family:Langdon">Langdon</p>
                                                    </li>
                                                    <li><p class="select-font" style="font-family:Lobster-Regular">
                                                            Lobster-Regular</p></li>
                                                    <li><p class="select-font" style="font-family:LockSmith_reg">
                                                            LockSmith_reg</p></li>
                                                    <li><p class="select-font" style="font-family:Lovelo Black">Lovelo
                                                            Black</p></li>
                                                    <li><p class="select-font" style="font-family:Lovelo Line Bold">
                                                            Lovelo Line Bold</p></li>
                                                    <li><p class="select-font" style="font-family:Lovelo Line Light">
                                                            Lovelo Line Light</p></li>
                                                    <li><p class="select-font" style="font-family:MANIFESTO">
                                                            MANIFESTO</p></li>
                                                    <li><p class="select-font" style="font-family:MODERNE SANS">MODERNE
                                                            SANS</p></li>
                                                    <li><p class="select-font" style="font-family:Mohave-Bold">
                                                            Mohave-Bold</p></li>
                                                    <li><p class="select-font" style="font-family:molesk">molesk</p>
                                                    </li>
                                                    <li><p class="select-font" style="font-family:Moonshiner-Regular">
                                                            Moonshiner-Regular</p></li>
                                                    <li><p class="select-font" style="font-family:Muchacho">Muchacho</p>
                                                    </li>
                                                    <li><p class="select-font" style="font-family:Open Sans">Open
                                                            Sans</p></li>
                                                    <li><p class="select-font" style="font-family:Oranienbaum">
                                                            Oranienbaum</p></li>
                                                    <li><p class="select-font" style="font-family:Parisish">Parisish</p>
                                                    </li>
                                                    <li><p class="select-font" style="font-family:RBNo2Light">
                                                            RBNo2Light</p></li>
                                                    <li><p class="select-font" style="font-family:Reckoner">Reckoner</p>
                                                    </li>
                                                    <li><p class="select-font" style="font-family:REIS-regular">
                                                            REIS-regular</p></li>
                                                    <li><p class="select-font" style="font-family:scalpel">scalpel</p>
                                                    </li>
                                                    <li><p class="select-font" style="font-family:Slim Joe">Slim Joe</p>
                                                    </li>
                                                    <li><p class="select-font" style="font-family:Snickles">Snickles</p>
                                                    </li>
                                                    <li><p class="select-font" style="font-family:SUNN">SUNN</p></li>
                                                    <li><p class="select-font" style="font-family:vevey">vevey</p></li>
                                                    <li><p class="select-font" style="font-family:Vincent-Regular">
                                                            Vincent-Regular</p></li>
                                                    <li><p class="select-font" style="font-family:THBaijam">TH
                                                            Baijam</p></li>
                                                    <li><p class="select-font" style="font-family:THChakraPetch">TH
                                                            ChakraPetch</p></li>
                                                    <li><p class="select-font" style="font-family:THCharmofAU">TH
                                                            CharmofAU</p></li>
                                                    <li><p class="select-font" style="font-family:THCharmonman">TH
                                                            Charmonman</p></li>
                                                    <li><p class="select-font" style="font-family:THFahkwang">TH
                                                            Fahkwang</p></li>
                                                    <li><p class="select-font" style="font-family:THK2DJuly8">TH
                                                            K2DJuly8</p></li>
                                                    <li><p class="select-font" style="font-family:THKodchasal">TH
                                                            Kodchasal</p></li>
                                                    <li><p class="select-font" style="font-family:THKoHo">TH KoHo</p>
                                                    </li>
                                                    <li><p class="select-font" style="font-family:THKrub">TH Krub</p>
                                                    </li>
                                                    <li><p class="select-font" style="font-family:THMaliGrade6">TH
                                                            MaliGrade6</p></li>
                                                    <li><p class="select-font" style="font-family:THNiramitAS">TH
                                                            NiramitAS</p></li>
                                                    <li><p class="select-font" style="font-family:THSrisakdi">TH
                                                            Srisakdi</p></li>
                                                    <li><p class="select-font" style="font-family:THSarabunNew">TH
                                                            SarabunNew</p></li>
                                                </ul>
                                                <ul class="font-list thai hide">
                                                    <li><p class="select-font" style="font-family:THBaijam">TH
                                                            Baijam</p></li>
                                                    <li><p class="select-font" style="font-family:THChakraPetch">TH
                                                            ChakraPetch</p></li>
                                                    <li><p class="select-font" style="font-family:THCharmofAU">TH
                                                            CharmofAU</p></li>
                                                    <li><p class="select-font" style="font-family:THCharmonman">TH
                                                            Charmonman</p></li>
                                                    <li><p class="select-font" style="font-family:THFahkwang">TH
                                                            Fahkwang</p></li>
                                                    <li><p class="select-font" style="font-family:THK2DJuly8">TH
                                                            K2DJuly8</p></li>
                                                    <li><p class="select-font" style="font-family:THKodchasal">TH
                                                            Kodchasal</p></li>
                                                    <li><p class="select-font" style="font-family:THKoHo">TH KoHo</p>
                                                    </li>
                                                    <li><p class="select-font" style="font-family:THKrub">TH Krub</p>
                                                    </li>
                                                    <li><p class="select-font" style="font-family:THMaliGrade6">TH
                                                            MaliGrade6</p></li>
                                                    <li><p class="select-font" style="font-family:THNiramitAS">TH
                                                            NiramitAS</p></li>
                                                    <li><p class="select-font" style="font-family:THSrisakdi">TH
                                                            Srisakdi</p></li>
                                                    <li><p class="select-font" style="font-family:THSarabunNew">TH
                                                            SarabunNew</p></li>
                                                </ul>
                                            </div>
                                            <div class="form-group">
                                                <label class="title" for="input-font-add"><b>เลือกฟอนท์</b></label>

                                                <div id="fake-select">
                                                    <span style="font-family:Open-Sans">Open-Sans</span>
                                                    <img class="arrow-dropdown arrow-1 pull-right"
                                                         src="{{ asset('images/icon/arrow.png') }}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="wrapper">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label class="title"
                                                           for="input-font-size"><b>ขนาดตัวอักษร</b></label>
                                                    <input type="number" id="input-font-size" class="form-control"
                                                           value="40">
                                                </div>
                                                <div id="dialog-text-color" class="design-dialog dialog">
                                                    <?php
                                                    $color = [
                                                            'Black' => '#000000',
                                                            'Gray' => '#8C8C8C',
                                                            'White' => '#FFFFFF',
                                                            'Light Blue' => '#68BCE5',
                                                            'Blue' => '#073E94',
                                                            'Navy Blue' => '#040451',
                                                            'Brite Red' => '#A1040C',
                                                            'Warm Red' => '#CB454C',
                                                            'Magenta' => '#D24174',
                                                            'Violet' => '#6E58B2',
                                                            'Orange' => '#FF5700',
                                                            'Yellow' => '#F8D138',
                                                            'Gold Yellow' => '#FBB027',
                                                            'Green Yellow' => '#7DAE34',
                                                            'Leaf Green' => '#137742',
                                                            'Brown' => '#653726',
                                                            'Silver' => '#C0C0C0',
                                                            'Sunny Gold' => '#D3A92E',
                                                            'Royal Gold' => '#C58A3F',
                                                    ];
                                                    foreach ($color as $name => $color) {
                                                        echo '<button class="btn-color text-color" data-color="' . $color . '" title="' . $name . '" style="background-color:' . $color . '"></button>';
                                                    }
                                                    $color2 = [
                                                            'Blue Fluorescent' => '#4BBEE7',
                                                            'Pink Fluorescent' => '#FF5794',
                                                            'Orange Fluorescent' => '#FF7757',
                                                            'Yellow Fluorescent' => '#EFF965',
                                                            'Green Fluorescent' => '#82EF73',
                                                    ];
                                                    echo "<hr>";
                                                    echo "<small>สีสะท้อนแสง</small><br>";

                                                    foreach ($color2 as $name => $color) {
                                                        echo '<button class="btn-color text-color" data-color="' . $color . '" title="' . $name . '" style="background-color:' . $color . '"></button>';
                                                    }
                                                    ?>

                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="title" for="input-text-color"><b>สี</b></label>
                                                    <br>
                                                    <button type="button" class="btn-color" id="input-text-color"
                                                            data-color="#000000"
                                                            style="background-color:#000000"></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="wrapper">
                                            <div class="item-tool text-tool form-group ">
                                                <label class="title"><b>เครื่องมือ</b></label>

                                                <div class="copy-item column icon" title="คัดลอก"
                                                     data-toggle="tooltip" data-placement="top">
                                                    <img src="{{ asset('images/icon/copy-item.png') }}">
                                                </div>
                                                <div class="move-center column icon" title="จัดให้อยู่ตรงกลาง"
                                                     data-toggle="tooltip" data-placement="top">
                                                    <img src="{{ asset('images/icon/move-center.png') }}">
                                                </div>
                                                <div class="move-down column icon" title="ย้ายไปไว้ข้างหลัง"
                                                     data-toggle="tooltip" data-placement="top">
                                                    <img src="{{ asset('images/icon/move-back.png') }}">
                                                </div>
                                                <div class="remove-tool column icon icon-remove" title="ลบ"
                                                     data-toggle="tooltip" data-placement="top">
                                                    <span class="glyphicon glyphicon-trash"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="picture-panel" role="tabpanel" class="tab-pane">
                                    <div class="box">
                                        <div class="wrapper show-picture"
                                             data-url="{{ action('DesignController@getGetUploadPicture') }}">
                                        </div>
                                        <div class="wrapper">
                                            <div class="item-tool picture-tool form-group">
                                                <label class="title"><b>เครื่องมือ</b></label>

                                                <div class="move-center column icon" title="จัดให้อยู่ตรงกลาง"
                                                     data-toggle="tooltip" data-placement="top">
                                                    <img src="{{ asset('images/icon/move-center.png') }}">
                                                </div>
                                                <div class="move-down column icon" title="ย้ายไปไว้ข้างหลัง"
                                                     data-toggle="tooltip" data-placement="top">
                                                    <img src="{{ asset('images/icon/move-back.png') }}">
                                                </div>
                                                <div class="icon-remove column icon" title="ลบ"
                                                     data-toggle="tooltip" data-placement="top">
                                                    <span class="glyphicon glyphicon-trash"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="wrapper upload">
                                            <div class="text-center">
                                                <div class="progress hide">
                                                    <div class="progress-bar progress-bar-success progress-bar-striped"
                                                         role="progressbar" aria-valuenow="40" aria-valuemin="0"
                                                         aria-valuemax="100" style="width: 0%;">
                                                    </div>
                                                </div>
                                                <div class="drop" data-token="{{ csrf_token() }}"
                                                     data-url={{ action('DesignController@postUploadPicture') }}></div>
                                            </div>
                                        </div>
                                        <p class="under-text text-left">
                                            <strong>ขนาดไฟล์สูงสุด:</strong> 5MB
                                            <br>
                                            <strong>ประเภทไฟล์:</strong> .jpg และ .png
                                            <br>
                                            <strong>ความละเอียดต่ำสุด:</strong> 1200 x 1200 pixel
                                            <br>
                                            <strong>ความละเอียดสูงสุด:</strong> 5,000 x 5,000 pixel

                                        <p class="alert alert-warning">
                                            การอัพโหลดไฟล์หรือรูปภาพนี้ คุณยอมรับว่าคุณมีสิทธิ์ในการทำซ้ำและจัดจำหน่าย
                                        </p>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="summary-wrapper">
                                <div class="submit-box">
                                    <div class=" text-right">
                                        <button id="btn-next" class="btn-add-basket column btn btn-success btn-lg">
                                            ต่อไป
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="front-thumbnail"></div>
    <div class="back-thumbnail"></div>
@stop
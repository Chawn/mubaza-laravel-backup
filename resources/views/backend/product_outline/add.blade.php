@extends('backend.layouts.master')
@section('css')
<link rel="stylesheet" href="{{ asset('jquery-ui/jquery-ui.min.css') }}"/>
<style type="text/css" media="screen">

        .custom-frame {
            text-align: center;
            background: #FFF;
            position: relative;
            padding: 0;
            width: 500px;
            margin: 0;
        }

        .custom-frame img.product-img {
            width: 500px;
        }

        #frame {
            border: solid 1px #CE934E;
            width: 200px;
            height: 200px;
            position: absolute;
            left: 100px;
            top: 100px;
            background: rgba(206, 147, 78, 0.08);
        }
    
        .move-center img{
            width: 25px;
        }
        input {
            width: 50px;
        }
</style>
@stop
@section('script')
    <script src="{{ asset('js/product-outline.js') }}"></script>
@stop
@section('content')
    <h2>กำหนดพื้นที่ออกแบบ</h2>
    <a href="{{ action('BackendController@getProductOutline') }}" title=""><< ย้อนกลับ </a>
    <div class="media">
        <div class="row">
            <div class="col-md-7">
                <div class="custom-frame add-frame">
                    <img class="product-img" src="{{ $product->getCover()->image_front }}">

                    <div id="frame"
                         data-id="{{ $product->id }}"
                         data-token="{{ csrf_token()  }}"
                         data-save-link="{{ action('BackendController@postSaveProductOutline') }}"
                         data-width="{{ $product->outline ? $product->outline->outline_width : 0 }}"
                         data-height="{{ $product->outline ? $product->outline->outline_height : 0 }}"
                         data-posx="{{ $product->outline ? $product->outline->outline_left : 0 }}"
                         data-posy="{{ $product->outline ? $product->outline->outline_top : 0 }}"
                         style="left: {{ $product->outline ? $product->outline->outline_left : 0 }}px;
                                 top: {{ $product->outline ? $product->outline->outline_top : 0 }}px;
                                 width: {{ $product->outline ? $product->outline->outline_width : 0 }}px;
                                 height: {{ $product->outline ? $product->outline->outline_height : 0 }}px;"></div>

                </div>
                <br>

            </div>
            <div class="col-md-5">
                <button id="btn-save" class="btn btn-success btn-lg btn-block">บันทึก</button>
                <br>

                <div class="product-detail panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">กำหนดค่า</h3>
                    </div>
                    <div class="panel-body">
                        <table>
                            <tr>
                                <td width="150" align="right">
                                    width : <input type="number" id="input-width" name="input-width"
                                                   value="{{ $product->outline ? $product->outline->outline_width : 0 }}">
                                    px
                                </td>

                                <td width="150" align="right">
                                    x : <input type="number" id="input-posx" name="input-posx"
                                               value="{{ $product->outline ? $product->outline->outline_left : 0 }}">
                                    px
                                </td>
                            </tr>
                            <tr>

                                <td align="right">
                                    height : <input type="number" id="input-height" name="input-height"
                                                    value="{{ $product->outline ? $product->outline->outline_height : 0 }}">
                                    px
                                </td>
                                <td align="right">
                                    y : <input type="number" id="input-posy" name="input-posy"
                                               value="{{ $product->outline ? $product->outline->outline_top : 0 }}">
                                    px
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <button class="btn btn-default btn-lg move-center column icon" title="จัดให้อยู่ตรงกลาง"
                                     data-toggle="tooltip" data-placement="top">
                                    <img src="{{ asset('images/icon/move-center.png') }}">
                                </button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="product-detail panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">ข้อมูลสินค้า</h3>
                    </div>
                    <div class="panel-body">
                        <div class="media">
                            <div class="media-left ">
                                <img class="media-object" width="64" height="64"
                                     src="{{ $product->getCover()->image_front }}"
                                     alt="รูปสินค้า">
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">{{ $product->name }}</h4>
                                รหัสสินค้า: {{ $product->id }}
                                <br>
                                ยี่ห้อ: {{ $product->brand->name }}
                                <br>
                                หมวดหมู่: {{ $product->category->name }}
                                <br>
                                ราคา: {{ $product->price }}
                            </div>
                        </div>
                    </div>
                </div>
                <p class="alert alert-danger" role="alert">
                    <b>วิธีกำหนดค่า:</b><br>
                    1.เลื่อนและขยายกรอบสีส้ม
                    <br>
                    2.ใส่ตัวเลขในช่องกำหนดค่า
                </p>

            </div>
        </div>
    </div>
    <div id="show-data">
    </div>
@stop
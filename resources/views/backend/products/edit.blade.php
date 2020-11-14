@extends('backend.layouts.master')
@section('css')
    <style>
        #color-table tbody tr td {
            vertical-align: middle;
        }
        .box-color{
            width: 30px;
            height: 30px;
            border: solid 1px #ccc;
        }
    </style>
@stop
@section('content')
    @if(\Session::has('message'))
        <div class="alert alert-success"><i class="fa fa-check-circle"></i>&nbsp;{{ \Session::get('message') }}</div>
    @endif
    @if($errors->has())
        <div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i>&nbsp;{{ $errors->first() }}</div>
    @endif
<form action="{{ action('BackendController@postUpdateProduct', $product->id) }}" method="post" id="product_edit_form" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="row">
    <div class="col-md-9">
        <div class="box">
            <div class="box-header">
                <div class=" form-inline">
                    <div class="row">
                        <div class="col-md-6">
                             <h3 class="box-title">ข้อมูลพื้นฐาน</h3>
                        </div>
                        <div class="col-md-6">
                            <div class="pull-right">
                                <a class="btn btn-primary" href="{{ action('BackendController@getAddProductOutline', $product->id) }}">กำหนดพื้นที่ออกแบบ</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="">
                    <input name="id" value="{{ $product->id }}" type="hidden"/>
                    <div style="width:280px">
                        <div class="form-group">
                            <label>หมวดหมู่</label>
                            <select name="category_id" class="form-control" required>
                                @foreach($categories as $key => $category)
                                    @if($product->category_id === $category->id)
                                        <option value="{{ $category->id }}" selected>{{ $category->detail }}</option>
                                    @else
                                        <option value="{{ $category->id }}">{{ $category->detail }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>ชื่อ</label>
                            <input type="text" class="form-control" name="name" required value="{{ $product->name }}">
                        </div>
                        <div class="form-group">
                            <label>ราคาเสื้อเปล่า</label>
                            <input type="number" name="price" class="form-control" autocomplete="off" required
                                   value="{{ $product->price }}">
                        </div>
                        <div class="form-group">
                            <label>ราคาขายพิมพ์ด้านเดียว</label>
                            <input type="number" name="one_side_price" class="form-control" autocomplete="off" required
                                   value="{{ $product->one_side_price }}">
                        </div>
                        {{--<div class="form-group">--}}
                            {{--<label>ราคาขายพิมพ์สองด้าน</label>--}}
                            {{--<input type="number" name="two_side_price" class="form-control" autocomplete="off" required--}}
                                   {{--value="{{ $product->two_side_price }}">--}}
                        {{--</div>--}}
                        <div class="form-group">
                            <label>ราคาขายสูงสุด</label>
                            <input type="number" name="max_price" class="form-control" autocomplete="off" required
                                   value="{{ $product->max_price }}">
                        </div>
                    </div>

                </div>
                
            </div>
        </div>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">
                    ตารางเปรียบเทียบขนาดเสื้อต่างๆ
                </h3>
            </div>
            <div class="box-body">
                <div class="">
                    <img src="{{ $product->size_chart }}" alt="">
                    <input type="file" name="size_chart_file" id="size-chart-file">
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="box">
            <div class="box-body">
                <button type="submit" class="pull-right btn btn-success btn-lg btn-block">
                    บันทึกการเปลี่ยนแปลง
                </button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">สีเสื้อและรูปภาพ</h3>
                <a href="{{ action('BackendController@getAddProductColor', $product->id) }}" class="pull-right btn btn-success" id="add-shirt-color-edit"><span
                                class="glyphicon glyphicon-plus"></span>&nbsp;เพิ่มสีเสื้อ
                    </a>
            </div>

            <div class="box-body">
                <table class="table table-hover" >
                    <thead>
                    <tr>
                        <th>รูปด้านหน้า</th>
                        <th>รูปด้านหลัง</th>
                        <th>สี</th>
                        <th>ขนาดที่มี</th>
                        <th width="10%"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($product->colors as $item)
                        <tr>
                            <td><img src="{{ action('ProductColorController@getFile', ['front', $item->id]) }}" width="100"></td>
                            <td><img src="{{ action('ProductColorController@getFile', ['back', $item->id]) }}" width="100"></td>
                            <td>{{ $item->color_name }}</td>
                            <td>{{ $item->getAvailableSizeString() }}</td>
                            <td><a href="{{ action('BackendController@getEditProductColor', $item->id) }}"
                                   class="btn btn-warning">แก้ไข</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                
            </div>
            
        </div>
    </div>
</div>
</form>
   
@stop
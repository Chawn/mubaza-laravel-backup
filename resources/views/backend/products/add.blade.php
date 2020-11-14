@extends('backend.layouts.master')
@section('css')
    <style>
        #color-table tbody tr td {
            vertical-align: middle;
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
    <form action="{{ action('BackendController@postSaveProduct') }}" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-header">
                    <div class=" form-inline">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="box-title">ข้อมูลพื้นฐาน</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="">
                        <div style="width:280px">
                            <div class="form-group">
                                <label for="category_id">หมวดหมู่</label>
                                <select name="category_id" id="category_id" class="form-control" required>
                                    @foreach($categories as $key => $category)
                                            <option value="{{ $category->id }}">{{ $category->detail }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name">ชื่อ</label>
                                <input type="text" class="form-control" name="name" id="name" required value="">
                            </div>
                            <div class="form-group">
                                <label for="price">ราคาเสื้อเปล่า</label>
                                <input type="number" name="price" id="price" class="form-control" autocomplete="off" required
                                       value="">
                            </div>
                            <div class="form-group">
                                <label for="one_side_price">ราคาขายพิมพ์ด้านเดียว</label>
                                <input type="number" name="one_side_price" id="one_side_price" class="form-control" autocomplete="off" required
                                       value="">
                            </div>
                            {{--<div class="form-group">--}}
                                {{--<label for="two_side_price">ราคาขายพิมพ์สองด้าน</label>--}}
                                {{--<input type="number" name="two_side_price" id="two_side_price" class="form-control" autocomplete="off" required--}}
                                       {{--value="">--}}
                            {{--</div>--}}
                            <div class="form-group">
                                <label for="max_price">ราคาขายสูงสุด</label>
                                <input type="number" name="max_price" id="max_price" class="form-control" autocomplete="off" required
                                       value="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">
                        ตารางเปรียบเทียบขนาดเสื้อ
                    </h3>
                </div>

                <div class="box-body">
                    <div class="">
                        <input type="file" name="size_chart_file" id="size-chart-file" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-md-offset-8 text-right">
            <a href="{{ URL::previous() }}" class="btn btn-default-shadow btn-lg">
                ยกเลิก
            </a>
            <button type="submit" class="btn btn-success btn-lg ">
                บันทึกการเปลี่ยนแปลง
            </button></div>
    </div>
    </form>
@stop
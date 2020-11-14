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
    <form action="{{ action('BackendController@postAddProductColor', $product->id) }}" method="POST" enctype="multipart/form-data">
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
                    <table class="table table-hover" >
                        <tbody>
                        <tr>
                            <td>สี</td>
                            <td><input type="color" name="color" value="" />&nbsp;<input type="text" name="color_name" class="form-control" value="" style="width:200px" required/></td>
                        </tr>
                        <tr>
                            <td>รูปด้านหน้า</td>
                            <td>
                                <input type="file" name="image_back" class="img_back">
                            </td>
                        </tr>
                        <tr>
                            <td>รูปด้านหลัง</td>
                            <td>
                                <input type="file" name="image_front" class="img_front">
                            </td>
                        </tr>
                        <tr>
                            <td >ขนาดที่มีจำหน่าย</td>
                            <td>
                                @foreach(config('constant.available_sizes') as $size)
                                    <label><input type="checkbox" name="sizes[]" value="{{ $size }}">&nbsp;<br>{{ $size }}</label>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <a href="{{ URL::previous() }}" class="btn btn-default-shadow btn-lg ">
                                    ยกเลิก
                                </a>
                                <button type="submit" class="btn btn-success btn-lg ">
                                    บันทึกการเปลี่ยนแปลง
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    </form>

@stop
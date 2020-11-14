@extends('manager.layouts.master')
@section('script')
    <script src="{{ asset('js/hashids.min.js') }}"></script>
    <script>
    </script>
@stop
@section('css')
    <style type="text/css" media="screen">
        .product-img{
            height: 200px;
        }
        .product-img img {
            width: 100px;
        }
    </style>
@stop
@section('content')
<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">สร้างคอลเล็คชั่นใหม่</h4>
            </div>
            <form>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="">ชื่อคอลเล็คชั่น</label>
                        <strong class="text-danger">*</strong>
                        <input type="email" class="form-control" id="" required>
                    </div>
                    <div class="form-group">
                        <label for="">รายละเอียด</label>
                        <textarea name="" id="" cols="30" rows="3" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">รูปหน้าปก</label>
                        <input type="file" id="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">สถานะ</label>
                        <select name="" id="" class="form-control">
                            <option value="">สาธารณะ</option>
                            <option value="">ส่วนตัว</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-success">สร้าง</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Collection Name</h3>
                    <p class="box-detail">Collection Description</p>
                </div>
                <div class="box-body">
                    <div class="row">
                        @for($i=1;$i<=12;$i++)
                        <div class="col-sm-2">
                            <div class="surprise-result product-box">
                                <a href="">
                                    <div class="product-img" style="height: 200px;">
                                        <img src="http://localhost/mubaza-laravel/public/images/mockup/img1.jpg">
                                    </div>
                                </a>
                                <div class="product-detail">
                                    <div class="product-name text-center">
                                        Campaign Name
                                    </div>
                                    <div class="product-description ">
                                        <span class="price">
                                            ฿399
                                        </span>
                                        <span class="wish pull-right">
                                            
                                            <a class="btn-add-cart" data-toggle="modal" href="#modal-cart">
                                                <i class="fa fa-close"></i>&nbsp;
                                            </a>
                                        </span>                    
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endfor
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <a href="" class="btn btn-success btn-lg btn-block">
                                <i class="fa fa-plus"></i> เพิ่มสินค้า
                            </a>
                        </div>
                        <div class="col-sm-4">
                            <a href="" class="btn btn-default-shadow btn-lg btn-block">
                                <i class="fa fa-pencil"></i> แก้ไขรายละเอียด
                            </a>
                        </div>
                        <div class="col-sm-4">
                            <a href="" class="btn btn-warning btn-lg btn-block">
                                <i class="fa fa-trash"></i> ลบ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
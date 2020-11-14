@extends('manager.layouts.master')
@section('script')
    <script src="{{ asset('js/hashids.min.js') }}"></script>
    <script>
    </script>
@stop
@section('css')
    <style type="text/css" media="screen">
       .product-img img{
        max-width: 100px;
       }
       .modal-dialog .table td:first-child{
            text-align: right;
            font-weight: bold;
            vertical-align: top;
       }
    </style>
@stop
@section('content')
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">รายละเอียด</h4>
            </div>
            <div class="modal-body">
                <table class="table" >
                    <tbody>
                        <tr>
                            <td width="120">รหัสสินค้า</td>
                            <td> #000001</td>
                        </tr>
                        <tr>
                            <td>ชื่อสินค้า</td>
                            <td> Product Name A</td>
                        </tr>
                        <tr>
                            <td>ข้อความวันที่</td>
                            <td>{{ Carbon::now()->toDateTimeString() }}</td>
                        </tr>
                        <tr>
                            <td>หัวข้อ</td>
                            <td>ผิดเงื่อนไข</td>
                        </tr>
                        <tr>
                            <td>รายละเอียด</td>
                            <td>
                                <p>สินค้ามีลายเสื้อที่เป็นลิขสิทธิ์ของผู้อื่น หากคุณมีเอกสารยืนยันการเป็นเจ้าของลิขสิทธิ์ หรือได้รับอนุญาติให้ใช้ลายดังกล่าว กรุณาติดต่อเรา</p>
                                <br>
                                <p>ทีมงานมูบาซ่า</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default-shadow" data-dismiss="modal">
                    ปิด
                </button>
            </div>
        </div>
    </div>
</div>
<div class="box-blank">
    <div class="box-body">
                 <table class="table table-bordered table-hover dataTable text-center">
                    <thead>
                        <tr>
                            <th>สถานะการอ่าน</th>
                            <th>รหัสสินค้า</th>
                            <th>ชื่อสินค้า</th>
                            <th>หัวข้อ</th>
                            <th>ข้อความวันที่</th>
                            <th>รายละเอียด</th>
                        </tr>
                    </thead>
                    @for($i=1;$i<=9;$i++)
                        <tr>
                            <td>
                                <i class="fa fa-email"></i>อ่านแล้ว
                            </td>
                            <td>
                                #00000{{$i}}
                            </td>
                            <td>
                                <p>Product Name AAAAA</p>
                            </td>
                            <td>
                                <strong class="text-danger"> ผิดเงื่อนไข</strong>
                            </td>
                            <td>
                                10/05/2558 10:59 น.
                            </td>
                            <td>
                                <a href="#" data-toggle="modal" data-target="#modal">อ่านรายละเอียด</a>
                            </td>
                        </tr>
                    @endfor
                </table>
            </div>
</div>
@stop
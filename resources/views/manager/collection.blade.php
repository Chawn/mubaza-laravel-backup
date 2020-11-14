@extends('manager.layouts.master')
@section('script')
    <script src="{{ asset('js/hashids.min.js') }}"></script>
    <script>
        $(document).ready(function () {
//            $("#save-button").click(function () {
//                $("#collection-form").submit();
//            });
        });
    </script>
@stop
@section('css')
    <style type="text/css" media="screen">
        .product-img img {
            max-width: 100px;
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">สร้างคอลเล็คชั่นใหม่</h4>
                </div>
                <form action="{{ action('AssociateController@postSaveCollection') }}" method="post" id="collection-form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="user_id" value="{{ \Auth::user()->user()->id }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name-input">ชื่อคอลเล็คชั่น</label>
                        <strong class="text-danger">*</strong>
                        <input type="text" name="name" class="form-control" id="name-input" required>
                    </div>
                    <div class="form-group">
                        <label for="detail-input">รายละเอียด</label>
                                <textarea name="detail" id="detail-input" cols="30" rows="3"
                                          class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="cover-image-input">รูปหน้าปก</label>
                        <input type="file" id="cover-image-input" name="cover_image" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="private-input">สถานะ</label>
                        <select name="private" id="private-input" class="form-control">
                            <option value="0">สาธารณะ</option>
                            <option value="1">ส่วนตัว</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-success" id="save-button">สร้าง</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="box">
                <div class="box-header">
                    <button class="btn btn-success pull-right" data-toggle="modal" data-target="#myModal">
                        <i class="fa fa-plus"></i> สร้างใหม่
                    </button>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-hover dataTable text-center">
                        <thead>
                        <tr>
                            <th>ชื่อคอลเล็คชั่น</th>
                            <th>รายละเอียด</th>
                            <th>รูปภาพหน้าปก</th>
                            <th>สถานะ</th>
                            <th>จำนวนสินค้า</th>
                            <th>เครื่องมือ</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($collections as $collection)
                        <tr>
                            <td>
                                {{ $collection->name }}
                            </td>
                            <td>
                                {{ $collection->detail }}
                            </td>
                            <td>

                                <img src="" alt="">
                            </td>
                            <td>
                                {{ $collection->private ? 'ส่วนตัว' : 'สาธารณะ' }}
                            </td>
                            <td>{{ $collection->items->count() }}</td>
                            <td>
                                <a href="" class="btn btn-default-shadow" data-toggle="modal" data-target="#myModal">
                                    <i class="fa fa-pencil"></i> แก้ไข
                                </a>
                                <a href="{{ url('manager/collection-detail') }}" class="btn btn-default-shadow">
                                    <i class="fa fa-cog"></i> จัดการสินค้า
                                </a>
                                <a href="" class="btn btn-warning">
                                    <i class="fa fa-trash"></i> ลบ
                                </a>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="6">ไม่มีรายการสินค้า</td>
                            </tr>
                        @endforelse
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="6">{!! str_replace('/?', '?', $collections->render()) !!}</td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
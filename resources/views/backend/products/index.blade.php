@extends('backend.layouts.master')
@section('css')
<style>

</style>

<script type="text/javascript">
  $(function() {
    $(".clickable-row").click(function() {
      window.document.location = $(this).data("href");
    });
    $('.clickable-row').on('click', 'td:first-child, td:last-child', function(e) {
        e.stopPropagation();
    });
  });

  $(document).ready(function() { 
    $("#table-product").tablesorter(); 
  }); 
</script>
@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">สินค้า</h3>
                <a href="{{ action('BackendController@getAddProduct') }}" class="btn btn-success pull-right">เพิ่มสินค้าใหม่</a>
            </div>
            <div class="box-body">
                <table id="table-product" class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th width="">รหัส</th>
                        <th width="">ชื่อสินค้า</th>
                        <th width="">หมวดหมู่</th>
                        <th width="">ราคาเสื้อเปล่า</th>
                        <th width="">ราคาพิมพ์ด้านเดียว</th>
                        {{--<th width="">ราคาพิมพ์สองด้าน</th>--}}
                        <th width="">ราคาขายสูงสุด</th>
                        <th width="">เครื่องมือ</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr class="clickable-row" data-href="">
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->detail }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->one_side_price }}</td>
                            {{--<td>{{ $product->two_side_price }}</td>--}}
                            <td>{{ $product->max_price }}</td>
                            <td>
                                <div class="tool-group-xs" role="group">
                                    <a class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="แก้ไข" href="{{ action('BackendController@getEditProduct', $product->id) }}">
                                       <i class="fa fa-pencil"></i>                         
                                    </a>
                                    <a class="btn btn-danger btn-sm" onclick="return confirm('คุณต้องการที่จะลบใช่ไหม?')" data-toggle="tooltip" data-placement="top" title="ลบ"
                                       href="{{ action('BackendController@getDeleteProduct', $product->id) }}">
                                       <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">หมวดหมู่สินค้า</h3>
                <a href="{{ action('BackendController@getAddProduct') }}" class="btn btn-success pull-right">เพิ่มหมวดหมู่ใหม่</a>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th width="">รหัส</th>
                        <th width="">ชื่อหมวดหมู่</th>
                        <th width="">เครื่องมือ</th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse ($categories as $category)
                    <tr>
                        <td>{{ $category->id  }}</td>
                        <td>{{ $category->detail }}</td>
                        <td>
                            <div class="tool-group-xs" role="group">
                                <a class="btn btn-warning btn-sm" href="{{ action('BackendController@getEditCategory', $category->id) }}">
                                    <i data-toggle="tooltip" data-placement="top" title="แก้ไข" class="fa fa-pencil"></i>
                                </a>
                                
                                <a class="btn btn-danger btn-sm" onclick="return confirm('คุณต้องการที่จะลบใช่ไหม?')" 
                                    href="{{ action('BackendController@getDeleteCategory', $category->id) }}">
                                    <i data-toggle="tooltip" data-placement="top" title="ลบ" class="fa fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                        @empty
                        <tr>
                            <td colspan="3">ไม่มีรายการหมวดหมู่</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
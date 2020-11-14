@extends('backend.layouts.master')
@section('css')
<script type="text/javascript">
	$(document).ready(function() { 
		$("#table-outline").tablesorter(); 
	}); 
</script>
@stop
@section('content')
    <h3>พื้นที่ออกแบบ</h3>
    <table id="table-outline" class="table-radius">
        <caption></caption>
        <thead>
        <tr>
            <th width="">รูปภาพ</th>
            <th width="">ชื่อ</th>
            <th>ตำแหน่ง x</th>
            <th>ตำแหน่ง y</th>
            <th>ความสูง</th>
            <th>ความกว้าง</th>
            <th width="">เครื่องมือ</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $id => $product)
        <tr>
            <td>
                <img src="{{ $product->getCover()->image_front }}" height="80">
            </td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->outline ? $product->outline->outline_left : 0 }}px</td>
            <td>{{ $product->outline ? $product->outline->outline_top : 0 }}px</td>
            <td>{{ $product->outline ? $product->outline->outline_height : 0 }}px</td>
            <td>{{ $product->outline ? $product->outline->outline_width : 0 }}px</td>

            <td>
                <a class="btn btn-danger" href="{{ action('BackendController@getAddProductOutline', $product->id) }}">กำหนดพื้นที่</a>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <div class="div-pagination">
		<div class="navbar-left">
       		<p>แสดง 10 จาก 109</p>
      	</div>
  		<div class="navbar-right">
       		<div class="a-pagination">
            	<a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>   
              	<a href="#">1</a>
              	<a href="#">2</a>
               	<a href="#">3</a>
              	<a href="#">4</a>
               	<a href="#">5</a>
                <a href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
			</div>
    	</div>
	</div><!-- end div-pagination -->
@stop
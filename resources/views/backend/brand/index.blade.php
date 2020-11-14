@extends('backend.layouts.master')
@section('css')
<style>

</style>
@stop
@section('content')
	<h3>ยี่ห้อสินค้า</h3>
    <div class="add-header">         	
		{{--<a class="pull-right" data-toggle="collapse" href="#add-brand-collapse" aria-expanded="false" aria-controls="add-collapse"><i class="fa fa-plus">&nbsp;เพิ่มยี่ห้อสินค้า</i></a> <br>--}}
		<a class="pull-right" href="{{ action('BackendController@getAddBrand') }}"><i class="fa fa-plus">&nbsp;เพิ่มยี่ห้อสินค้า</i></a> <br>
        <div class="collapse" id="add-brand-collapse">
        	<div class="well">
            	<div class="collapse-title">เพิ่มยี่ห้อสินค้า</div>
            	<form class="form-horizontal">
                    <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">ชื่อ</label>
                        <div class="col-sm-4">
                        	<input type="text" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputDetail" class="col-sm-2 control-label" >คำอธิบาย</label>
                        <div class="col-sm-4">
                            <input type="text" name="detail" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="btn-save-brand" class="col-sm-2 control-label" ></label>
                        <div class="col-sm-4">
                            <button id="btn-save-brand" type="submit" class="btn btn-green">บันทึก</button>
                        </div>
                    </div>
    			</form>
    		</div>
        </div><!-- collapse -->
        
        <div class="collapse" id="edit-brand-collapse">
        	<div class="well">
            	<div class="collapse-title">แก้ไขยี่ห้อสินค้า</div>
            	<form class="form-horizontal">
                    <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">ชื่อ</label>
                        <div class="col-sm-4">
                        	<input type="text" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputDetail" class="col-sm-2 control-label" >คำอธิบาย</label>
                        <div class="col-sm-4">
                            <input type="text" name="detail" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="btn-save-edit-brand" class="col-sm-2 control-label" ></label>
                        <div class="col-sm-4">
                            <button id="btn-save-edit-brand" type="submit" class="btn btn-green">บันทึก</button>
                        </div>
                    </div>
    			</form>
    		</div>
        </div>
    </div>
<table class="table-radius">
    <caption></caption>
    <thead>
    <tr>
        <th width="10%">รหัส</th>
        <th width="70%">ชื่อยี่ห้อ</th>
        <th width="20%">เครื่องมือ</th>
    </tr>
    </thead>
    <tbody>
    @forelse ($brands as $brand)
    <tr>
        <td>{{ $brand->id  }}</td>
        <td>{{ $brand->name }}</td>
        <td>
            <div class="tool-group-xs" role="group">
                {{--<a data-toggle="collapse" aria-expanded="false" aria-controls="edit-brand-collapse"--}}
                	{{--href="#edit-brand-collapse">                    --}}
                    {{--<i data-toggle="tooltip" data-placement="top" title="แก้ไข" class="fa fa-pencil-square-o"></i>--}}
                {{--</a>--}}
                <a href="{{ action('BackendController@getEditBrand', $brand->id) }}">
                    <i data-toggle="tooltip" data-placement="top" title="แก้ไข" class="fa fa-pencil-square-o"></i>
                </a>
                <a onclick="return confirm('คุณต้องการที่จะลบใช่ไหม?')" 
                   href="{{ action('BackendController@getDeleteBrand', $brand->id) }}">
                   <i data-toggle="tooltip" data-placement="top" title="ลบ" class="fa fa-minus-circle"></i>
                </a>
            </div>
        </td>
    </tr>
    @empty
        <tr>
            <td colspan="3">ไม่มีรายการยี่ห้อ</td>
        </tr>
        @endforelse
    </tbody>
</table>
    <div class="div-pagination">
        {!! str_replace('/?', '?', $brands->render()) !!}
    </div><!-- end div-pagination -->
@stop
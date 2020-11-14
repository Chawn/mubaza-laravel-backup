@extends('backend.layouts.master')
@section('css')
<style>

</style>
<script type="text/javascript">
	$(document).ready(function() { 
		$("#table-product-type").tablesorter(); 
	}); 
</script>
@stop
@section('content')
	<h3>ประเภทสินค้า</h3>
    <div class="add-header">         	
		<a class=" pull-right" data-toggle="collapse" href="#add-product-type-collapse" aria-expanded="false" aria-controls="add-product-type-collaps"><i class="fa fa-plus">&nbsp;เพิ่มประเภทสินค้า</i></a> <br>
        <div class="collapse" id="add-product-type-collapse">
        	<div class="well">
            	<div class="collapse-title">เพิ่มประเภทสินค้า</div>
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
                        <label for="btn-save-type" class="col-sm-2 control-label" ></label>
                        <div class="col-sm-4">
                            <button id="btn-save-type" type="submit" class="btn btn-green">บันทึก</button>
                        </div>
                    </div>
    			</form>
    		</div>
        </div><!-- collapse -->
        
        <div class="collapse" id="edit-product-type-collapse">
        	<div class="well">
            	<div class="collapse-title">แก้ไขประเภทสินค้า</div>
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
                        <label for="btn-save-edit-type" class="col-sm-2 control-label" ></label>
                        <div class="col-sm-4">
                            <button id="btn-save-edit-type" type="submit" class="btn btn-green">บันทึก</button>
                        </div>
                    </div>
    			</form>
    		</div>
        </div>
    </div>
<table id="table-product-type" class="table-radius">
    <caption></caption>
    <thead>
    <tr>
        <th width="10%">รหัส</th>
        <th width="70%">ชื่อประเภท</th>
        <th width="20%">เครื่องมือ</th>
    </tr>
    </thead>
    <tbody>
    <?
    foreach ($product_types as $product_type) {?>
    <tr>
        <td>{{ $product_type->id  }}</td>
        <td>{{ $product_type->name }}</td>
        <td>
            <div class="tool-group-xs" role="group">
                <a data-toggle="collapse" aria-expanded="false" aria-controls="edit-product-type-collapse"
                   href="#edit-product-type-collapse">
                   <i data-toggle="tooltip" data-placement="top" title="แก้ไข" class="fa fa-pencil-square-o"></i>
                </a>
                <a onclick="return confirm('คุณต้องการที่จะลบใช่ไหม?')" 
                   href="{{ action('BackendController@getDeleteProductType', $product_type->id) }}">
                   <i data-toggle="tooltip" data-placement="top" title="ลบ" class="fa fa-minus-circle"></i>
                </a>
            </div>
        </td>
    </tr>
    <?
    }
    ?>
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
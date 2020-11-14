@extends('backend.layouts.master')
@section('css')

@stop
@section('content')
<h3>ชนิดเสื้อ</h3>
<div class="add-header">
	<a class=" navbar-right" data-toggle="collapse" href="#add-type-collapse" aria-expanded="false" aria-controls="add-collapse"><i class="fa fa-plus">&nbsp;เพิ่มชนิดเสื้อ</i></a> <br>
</div>
<div class="collapse" id="add-type-collapse">
	<div class="well">
    	<form class="form-horizontal">
			<div class="form-group">
                <label for="inputColor" class="col-sm-2 control-label">เพิ่มสี</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="inputSname" placeholder="ระบุสีที่ต้องการเพิ่ม">
                </div>
                
            </div>
        </form>
        <label for="inputColor" class="col-sm-2 control-label"></label>
        <div class="col-sm-4">
        <button class="btn btn-success">บันทึก</button>
        </div>
    </div>
</div>

@stop
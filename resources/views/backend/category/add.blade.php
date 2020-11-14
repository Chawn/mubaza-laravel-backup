@extends('backend.layouts.master')
@section('content')
    <h2>เพิ่มหมวดหมู่สินค้า</h2>

{!! Form::open([
'action' => 'BackendController@postSaveCategory',
'method' => 'post',
'id'        => 'category_add_form'
]) !!}
    <div style="width:280px">
        <div class="form-group">
            <label >ชื่อ</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label >คำอธิบาย</label>
            <input type="text" name="detail" class="form-control">
        </div>
    </div>
    <button type="submit" class="btn btn-success btn-">บันทึก</button>
{!! Form::close() !!}
    @stop
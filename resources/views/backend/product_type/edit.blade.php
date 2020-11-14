@extends('backend.layouts.master')
@section('content')
    <h2>แก้ไขประเภทสินค้า</h2>
{!! Form::open([
'action' => 'BackendController@postUpdateProductType',
'method' => 'post',
'id'        => 'product_type_edit_form'
]) !!}
    <input type="hidden" name="id" value="{{ $product_type->id }}">
    <div style="width:280px">
        <div class="form-group">
            <label >ชื่อ</label>
            <input type="text" name="name" value="{{ $product_type->name }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label >คำอธิบาย</label>
            <input type="text" name="detail" value="{{ $product_type->detail }}" class="form-control">
        </div>
    </div>
    <button type="submit" class="btn btn-success btn-">บันทึก</button>
</form>
    @stop
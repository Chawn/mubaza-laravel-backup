@extends('backend.layouts.master')
@section('content')
    <h2>แก้ไขยี่ห้อสินค้า</h2>
{!! Form::open([
'action' => 'BackendController@postUpdateBrand',
'method' => 'post',
'id'        => 'brand_edit_form'
]) !!}
    <input type="hidden" name="id" value="{{ $brand->id }}">
    <div style="width:280px">
        <div class="form-group">
            <label >ชื่อ</label>
            <input type="text" name="name" value="{{ $brand->name }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label >คำอธิบาย</label>
            <input type="text" name="detail" value="{{ $brand->detail }}" class="form-control">            
        </div>
    </div>
    <button type="submit" class="btn btn-success btn-">บันทึก</button>
</form>
    @stop
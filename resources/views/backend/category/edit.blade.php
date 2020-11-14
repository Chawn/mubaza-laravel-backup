@extends('backend.layouts.master')
@section('content')
<div class="box">
    <div class="box-body">
        {!! Form::open([
            'action' => 'BackendController@postUpdateCategory',
            'method' => 'post',
            'id'        => 'category_edit_form'
            ]) !!}
            <input type="hidden" name="id" value="{{ $category->id }}">
            <div style="width:280px">
                <div class="form-group">
                    <label >ชื่อ</label>
                    <input type="text" name="name" value="{{ $category->name }}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label >คำอธิบาย</label>
                    <input type="text" name="detail" value="{{ $category->detail }}" class="form-control">
                </div>
            </div>
            <a href="{{ URL::previous() }}" class="btn btn-default-shadow">ยกเลิก</a>
            <button type="submit" class="btn btn-success btn-">บันทึก</button>
        </form>
        @stop
    </div>
</div>
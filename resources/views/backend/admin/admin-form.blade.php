@extends('backend.layouts.master')
@section('css')
<style>
</style>
@stop
@section('script')
    <script src="{{ asset('js/validate/jquery.validate.min.js') }}"> </script>
    <script src="{{ asset('js/validate/additional-methods.min.js') }}"> </script>
    <script src="{{ asset('js/validate/localization/messages_th.min.js') }}"> </script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#save-btn").on("click", function() {
            $("#admin-form").submit();
        });
    });
</script>
@stop
@section('content')
<div class="row">
	<div class="col-md-9">
        <div class="box">
            <div class="box-header">
                รายละเอียดผู้ใช้
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-9">
                        @include('backend.layouts.include.alert')
                        @if(isset($admin))
                            {!! Form::model($admin, ['url' => action('BackendController@postEditAdmin'), 'method' => 'POST', 'id' => 'admin-form']) !!}
                            {!! Form::hidden('id', $admin->id) !!}
                        @else
                            {!! Form::open(['url' => action('BackendController@postAddAdmin'), 'method' => 'POST', 'id' => 'admin-form']) !!}
                        @endif
                        <div class="form-group">
                            {!! Form::label('full_name', 'ชื่อ-นามสกุล') !!}
                            {!! Form::text('full_name', null, ['class' => 'form-control', 'placeholder' => 'ชื่อ-นามสกุล']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('email', 'อีเมล์') !!}
                            {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'อีเมล์']) !!}
                        </div>
                        @if(isset($admin))
                        <div class="form-group">
                            {!! Form::label('change_password', 'เปลี่ยนรหัสผ่าน') !!}
                            {!! Form::checkbox('change_password', 1, false, ['class' => 'form-group']) !!}
                        </div>
                        @endif
                        <div class="form-group">
                            {!! Form::label('password', 'รหัสผ่าน') !!}
                            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'รหัสผ่าน']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('admin_role_id', 'ตำแหน่ง') !!}
                            {!! Form::select('admin_role_id', $admin_roles, null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('admin_status_id', 'สถานะ') !!}
                            {!! Form::select('admin_status_id', $admin_statuses, null, ['class' => 'form-control']) !!}
                        </div>
                        {!! Form::close() !!}</div>
                </div>
            </div>
        </div>
        

	</div>
    <div class="col-md-3">
        <div class="box">
            <div class="box-header">
                เครื่องมือ
            </div>
            <div class="box-body">
                <button type="button" class="btn btn-success btn-block" id="save-btn">
                    <i class="fa fa-check"></i> บันทึกข้อมูล
                </button>
                <a href="{{ action('BackendController@getAdmin') }}" class="btn btn-default btn-block">
                    <i class="fa fa-times"></i> ยกเลิก
                </a>
            </div>
        </div>
    </div>
</div>
@stop
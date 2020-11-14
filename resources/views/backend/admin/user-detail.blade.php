@extends('backend.layouts.master')
@section('meta')
	<meta name="csrf-token" content="{{ csrf_token() }}">
@stop
@section('css')
<style>
</style>
@stop
@section('script')
    <script src="{{ asset('js/validate/jquery.validate.min.js') }}"> </script>
    <script src="{{ asset('js/validate/additional-methods.min.js') }}"> </script>
    <script src="{{ asset('js/validate/localization/messages_th.min.js') }}"> </script>
    <script src="{{ asset('js/countdown/jquery.countdown.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
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
                <table class="table">
                    <tr>
                        <td>รูปโปรไฟล์:</td>
                        <td>
                            <span class="profile-circle" style="width:60px;height:60px;">   <span class="profile-image" style="background-image:url('{{ asset($user->avatar) }}')">
                                </span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>รหัสผู้ใช้:</td>
                        <td>{{ $user->id }}</td>
                    </tr>
                    <tr>
                        <td>ชื่อ - สกุล:</td>
                        <td>{{ $user->full_name }}</td>
                    </tr>
                    <tr>
                        <td>ชื่อผู้ใช้:</td>
                        <td>{{ $user->username }}</td>
                    </tr>
                    <tr>
                        <td>อีเมล:</td>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td>เบอร์โทร:</td>
                        <td>{{ $user->profile->phone }}</td>
                    </tr>
                    <tr>
                        <td>Line:</td>
                        <td>{{ $user->profile->line_id }}</td>
                    </tr>
                    <tr>
                        <td>วันที่สมัครใช้งาน:</td>
                        <td>{{ $user->created_at->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <td>แก้ไขข้อมูลล่าสุด:</td>
                        <td>{{ $user->updated_at->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <td>สถานะการใช้งาน:</td>
                        <td>{{ $user->status->detail }}</td>
                    </tr>
                    <tr>
                        <td>ที่อยู่</td>
                        <td>{{ $user->profile->address }}</td>
                    </tr>
                    <tr>
                        <td>อาคาร</td>
                        <td>{{ $user->profile->building }}</td>
                    </tr>
                    <tr>
                        <td>เขต/อำเภอ</td>
                        <td>{{ $user->profile->district }}</td>
                    </tr>
                    
                    <tr>
                        <td>จังหวัด</td>
                        <td>{{ $user->profile->province }}</td>
                    </tr>
                    <tr>
                        <td>รหัสไปรษณีย์</td>
                        <td>{{ $user->profile->zipcode }}</td>
                    </tr>
                </table>
                
            </div>
        </div>
        

	</div>
    <div class="col-md-3">
        <div class="box">
            <div class="box-header">
                เครื่องมือ
            </div>
            <div class="box-body">
                <a class="btn btn-primary btn-block" href="{{ action('UserController@getCreatorShow',$user->id) }}">
                    <i class="fa fa-search"></i> ดูหน้าแสดงสินค้า
                </a>
                @if($user->status->name === 'normal' || $user->status->name == 'inactive')
                    <button type="button" class="btn btn-danger btn-block" data-url="{{ action('BackendController@getSetUserStatus', [$user->id, 'banned']) }}" data-toggle="modal" data-target="#confirm-ban">
                        <i class="fa fa-ban"></i> ระงับผู้ใช้
                    </button> 
                @elseif($user->status->name === 'banned')
                    <a class="btn btn-success btn-block" href="{{ action('BackendController@getSetUserStatus', [$user->id, 'normal'] ) }}">
                        <i class="fa fa-check"></i> ยกเลิกการระงับผู้ใช้
                    </a> 
                @endif
            
                
            </div>
        </div>
    </div>
</div>


				    <!-- End comfirm dialog box -->
@stop
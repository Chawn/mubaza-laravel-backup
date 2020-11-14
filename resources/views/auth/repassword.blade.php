@extends('layouts.full_width')
@section('css')
<style type="text/css">
#repassword {
	min-height: 420px;
}
.mar {
	margin-bottom: 15px;
}
.btn {
	width: 100px;
}
    .error {
        border-color: #f00;
        color: #f00;
    }
</style>
@stop
@section('script')
    <script src="{{ asset('js/validate/jquery.validate.min.js') }}"> </script>
    <script src="{{ asset('js/validate/additional-methods.min.js') }}"> </script>
    <script src="{{ asset('js/validate/localization/messages_th.min.js') }}"> </script>
    <script>
        $(document).ready(function() {
            $('#password-form').validate({
                rules: {
                    password: "required",
                    password_confirmation: {
                        equalTo: "#password-new"
                    }
                },
                errorPlacement: function (error, element) {
                    // Append error within linked label
//                    $(element).addClass('error');
                    error.insertAfter(element);
                }

            });
        });
    </script>
@stop
@section('content')
<div id="repassword">
    <h3><i class="fa fa-lock"></i>&nbsp;กรอกรหัสผ่านใหม่ที่คุณต้องการ</h3>
    <hr/>
    <form method="POST" action="{{ action('UserController@postResetPassword') }}" id="password-form">
        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
        <input name="user_id" type="hidden" value="{{ $user->id }}"/>
    <div class="col-md-6 col-md-offset-3">
        <div class="col-sm-4"><label for="password">รหัสผ่านใหม่</label></div>
		<div class="col-sm-8">
			<input type="password" name="password" class="form-control mar" id="password-new" placeholder="กรอกรหัสผ่านใหม่">
		</div>
	</div>
	<div class="col-md-6 col-md-offset-3">
        <div class="col-sm-4"><label for="password-confirm">รหัสผ่านใหม่อีกครั้ง</label></div>
		<div class="col-sm-8">
			<input type="password" name="password_confirmation" class="form-control mar" id="password-confirm" placeholder="กรอกรหัสใหม่ผ่านอีกครั้ง">
		</div>
	</div>
	<div class="col-md-6 col-md-offset-3">
		<div class="col-sm-offset-9 col-sm-3">
			<button class="btn btn-success"><i class="fa fa-check"></i>&nbsp;ยืนยัน</button>
		</div>
	</div>
        </form>
</div>
@stop
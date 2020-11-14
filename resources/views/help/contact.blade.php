@extends('layouts.help')
@section('css')
<style>
    .error {
        border-color: #f00;
    }
#contact {
	min-height: 250px;
}
label{
	text-align: right;
	line-height: 35px;
	vertical-align: middle;
	font-size: 14px;
}
#cle{
	width: 100px;
}
.box {
	border-bottom:1px solid #ddd;
	padding: 5px;
	margin-bottom: 5px;
}
@media(max-width: 767px){
	.form-group label{
		text-align: left;
	}
}
</style>
@stop
@section('script')
    <script src="{{ asset('js/validate/jquery.validate.min.js') }}"> </script>
    <script src="{{ asset('js/validate/additional-methods.min.js') }}"> </script>
    <script src="{{ asset('js/validate/localization/messages_th.min.js') }}"> </script>
    <script>
        $(document).ready(function() {
           $('#contact-form').validate({
               errorPlacement: function (error, element) {
                   // Append error within linked label
                   $(element).addClass('error');
               }
           });
            $('#send').click(function() {
               if($('#contact-form').valid())
               {
                   $('#contact-form').submit();
               }
            });
        });
    </script>
    @stop
@section('content')
<div id="contact">
	<h4 class="article-title">ส่งข้อความหาเรา</h4>
	
    <form class="form-horizontal" enctype="multipart/form-data" method="post" id="contact-form" action="{{ action('HomeController@postContact') }}">
        <p>
        
        	<i>หากคุณต้องการให้เราติดต่อกลับ กรุณากรอกข้อมูลให้ถูกต้อง</i>
        
        </p>
        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
		<div class="form-group">
			<label id="name" class="col-sm-2 col-xs-12">ชื่อ :</label>
			<div class="col-sm-6">
				<input type="text" name="name" class="form-control" placeholder="Name" required>
			</div>
		</div>
		<div class="form-group">
			<label  class="col-sm-2 col-xs-12">อีเมล์ :</label>
			<div class="col-sm-6">
				<input type="email" name="email" class="form-control" placeholder="E-mail" required>

			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 col-xs-12">เบอร์โทรศัพท์ :</label>
			<div class="col-sm-4">
				<input type="text" name="phone" class="form-control" placeholder="Phone Number">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 col-xs-12">เรื่อง :</label>
			<div class="col-sm-4">
				<input type="text" name="subject" class="form-control" placeholder="Topic" required>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 col-xs-12">รายละเอียด :</label>
			<div class="col-sm-4">
				<textarea class="form-control" name="detail" rows="3" placeholder="Detail" required></textarea>
			</div>
		</div>			
		<div class="form-group">
			<label class="col-sm-2 col-xs-12" for="InputFile">ไฟล์แนบ :</label>
			<div class="col-sm-6">
				<input type="file" name="file" id="InputFile">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-3">
				<button id="send" type="submit" class="btn btn-primary">
					<i class="fa fa-envelope"></i>&nbsp;ส่งข้อความ
				</button>
			</div>
		</div>
	</form>
    {{-- <h4 class="article-title"><i class="fa fa-location-arrow"></i>&nbsp;ที่อยู่</h4>
    <div>
        <p>{{ config('profile.address') }}</p>
    </div>
    <hr/>
    <h4 class="article-title"><i class="fa fa-facebook-square"></i>&nbsp;เฟซบุค</h4> 
    <div>
        <p><a href="{{ config('profile.facebook') }}">{{ config('profile.sitename') }} Thailand</a></p>
    </div>
    --}}
    <hr/>
    <h4 class="article-title">ติดต่อเราโดยตรง</h4>
    <p>
    	<i>{{ config('profile.business-day') }}</i>

    </p>
    <div>
        <p><strong>โทรศัพท์:</strong> {{ config('profile.phone-primary') }}</p>
        <p><strong>อีเมล์:</strong> <a href="mailto:{{ config('profile.email') }}">{{ config('profile.email') }}</a>
        </p>
    </div>
    
    <hr/>
   
    @include('backend.layouts.include.alert')
    
    
</div>
@stop
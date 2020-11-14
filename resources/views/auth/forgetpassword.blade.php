@extends('layouts.full_width')
@section('css')
<style type="text/css">

</style>
@stop
@section('script')
    {{--<script src='https://www.google.com/recaptcha/api.js'></script>--}}
    <script type="text/javascript">

        $(document).ready(function() {
//           $('#send-email').click(function() {
//               $.ajax({
//                   type: "post",
//                   url: $(this).data('url'),
//                   dataType: "json",
//                   success: function (data) {
//                       if(data.success) {
//                           console.log(data);
//
//                           var html = "";
//                           $.each(data.items, function(k, item) {
//                               html += '<tr>';
//                               html += '<td>' + item.product.name + '</td>';
//                               html += '<td>' + item.size + '</td>';
//                               html += '<td><i class="fa fa-stop" style="color: ' + item.product_image.color + '"></i>&nbsp;' + item.product_image.color_name + '</td>';
//                               html += '<td>' + item.qty + '</td>';
//                               html += '</tr>';
//                           });
//
//                           order_list_table.html(html);
//                       } else {
//                           alert(data.message);
//                       }
//                   },
//                   failure: function (errMsg) {
//                       alert(errMsg);
//                   }
//               });
//           }) ;
        });
        var recaptchaCallback = function(response) {
            document.getElementById('send-email').removeAttribute('disabled');
        };
        var onloadCallback = function() {
            grecaptcha.render('g-recaptcha', {
                'sitekey' : '6LcTwwoTAAAAAB1lYatH16JbwrsXGi6jdSuHHkqg',
                'callback' : recaptchaCallback
            });
        };
    </script>
@stop
@section('content')
<div id="forget">
    <form action="{{ action('UserController@postForgotPassword')  }}" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div id="email-box" class="row">
			
			<div class="col-sm-5">
				<h3>ฉันลืมพาสเวิร์ดของฉัน</h3>
				<p>ใส่อีเมล์ที่คุณใช้สมัครสมาชิก เพื่อรับลิงก์สำหรับเปลี่ยนรหัสผ่าน</p>
	            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required>
	        	<div id="key">
	        		<div id="captcha"><br/>
	                    <div id="g-recaptcha" ></div>
	        		</div>
	        	</div>
	        	<input type="submit" class="btn btn-success" id="send-email" disabled value="ยืนยัน" />
			</div>
		</div>
    </form>
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
            async defer>
    </script>
</div>
	

@stop
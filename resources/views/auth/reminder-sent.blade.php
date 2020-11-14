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
                'sitekey' : '6LdZLwcTAAAAAKs2D7rgf213Xn6qR2U2WmilwCpo',
                'callback' : recaptchaCallback
            });
        };
    </script>
@stop
@section('content')
<div id="forget">
	<div id="email-box" class="col-md-12">
		<h3>
            ส่งลิงก์สำหรับเปลี่ยนรหัสผ่านให้ทางอีเมลเรียบร้อยแล้ว <i class="fa fa-check text-success"></i>
        </h3>
</div>
	

@stop
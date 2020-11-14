<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $title }}</title>

    @yield('meta')

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin-lte/dist/css/AdminLTE.css') }} ">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link rel="stylesheet" href="{{ asset('admin-lte/dist/css/skins/_all-skins.min.css') }}">


    
    <link rel="stylesheet" href="{{ asset('jquery-ui/themes/base/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/webfonts/style.css') }}">
    <script src="{{ asset('jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('jquery-ui/jquery-ui.min.js') }}"></script>

    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/backend.js') }}"></script>
    <script src="{{ asset('js/tablesorter.js') }}"></script>
    <script src="{{ asset('js/jquery.circliful.min.js') }}"></script>
    <script src="{{ asset('js/chart.js') }}"></script>
    
     <script src="{{ asset('admin-lte/dist/js/app.js') }}" type="text/javascript"></script>
    <script>
      var AdminLTEOptions = {
        //Enable sidebar expand on hover effect for sidebar mini
        //This option is forced to true if both the fixed layout and sidebar mini
        //are used together
        sidebarExpandOnHover: true,
        //BoxRefresh Plugin
        enableBoxRefresh: true,
        //Bootstrap.js tooltip
        enableBSToppltip: true
      };
    </script>
   

    <script>
        $(document).ready(function() 
        { 
            $(".table-gray").tablesorter(); 
        } 
    );
    </script>
	<style>
	.login-box, .register-box{
		
	}
	.login-box-body{
		padding: 40px;
	}
	</style>
    @yield('css')
    @yield('script')


</head>
<body class="hold-transition login-page">

	<div class="login-box ">
		<div class="login-logo">
			<a href="../../index2.html"><b>Admin</b> Dashboard</a>
		</div><!-- /.login-logo -->
		<div class="login-box-body">
			<p class="login-box-msg">เฉพาะเจ้าหน้าที่เท่านั้น</p>
			<div id="backend-login-form" >
				
			</div>		

			<form id="login-form" action="{{ action('BackendController@postLogin') }}" method="post" class="">
				<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
				<div class="form-group has-feedback">
					<input id="input-backend-username" name="email" type="email" class="form-control" placeholder="Email">
					<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback">
					<input id="input-backend-password" name="password"type="password" class="form-control" placeholder="Password">
					<span class="glyphicon glyphicon-lock form-control-feedback"></span>
				</div>
				<button id="btn-backend-login" type="submit" name="login" class="btn btn-primary  btn-lg btn-block btn-flat">เข้าสู่ระบบ</button>
			
			</form>

		</div><!-- /.login-box-body -->
	</div>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  

</body>

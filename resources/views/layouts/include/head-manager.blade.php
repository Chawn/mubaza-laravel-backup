<link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('jquery-ui/themes/base/jquery-ui.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/webfonts/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/header.css') }}">
<link rel="stylesheet" href="{{ asset('css/footer.css') }}">
<link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">

<link rel="stylesheet" href="{{ asset('css/product.css') }}">
<link rel="stylesheet" href="{{ asset('admin-lte/dist/css/AdminLTE.css') }} ">
<link rel="stylesheet" href="{{ asset('admin-lte/dist/css/skins/skin-custom.css') }}">
<link rel="stylesheet" href="{{ asset('css/bootstrap-mod.css') }}">

<link rel="icon" href="{{asset('images/favicon_32.ico')}}" type="image/x-icon" />

<script src="{{ asset('jquery/dist/jquery.min.js') }}"> </script>
<script src="{{ asset('jquery-ui/jquery-ui.min.js') }}"> </script>
<script src="{{ asset('js/bootstrap.min.js') }}"> </script>
<script src="{{ asset('js/tablesorter.js') }}"></script>
<script src="{{ asset('js/report.js') }}"></script>

<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/locales/th.js') }}"></script>
<script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    
<script src="{{ asset('admin-lte/dist/js/app.js') }}" type="text/javascript"></script>

@if(\Route::currentRouteName()!='campaign-show')
	@include('layouts.include.meta-index')
@endif
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- tag for responsive -->
    <meta name="viewport" content="width=device-width; initial-scale = 1.0; maximum-scale=1.0; user-scalable=no" />
    <title>{{ $title }} : {{ config('profile.sitename') }}</title>
    <base href="{{ url('/') }}" target="_blank, _self, _parent, _top">
    @yield('meta')

    {{--@include('layouts.include.head')--}}
    {{--<link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">--}}
    {{--<link rel="stylesheet" href="{{ asset('css/bootstrap-mod.css') }}">--}}
    {{--<link rel="stylesheet" href="{{ asset('jquery-ui/themes/base/jquery-ui.min.css') }}">--}}
    {{--<link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">--}}
    {{--<link rel="stylesheet" href="{{ asset('css/webfonts/style.css') }}">--}}

{{--    <link rel="stylesheet" href="{{ asset('css/product.css') }}">--}}

    {{--<link rel="icon" href="{{asset('images/favicon-GG7-64.png')}}" type="image/x-icon" />--}}

    {{--<script src="{{ asset('jquery/dist/jquery.min.js') }}"> </script>--}}
    {{--<script src="{{ asset('jquery-ui/jquery-ui.min.js') }}"> </script>--}}
    {{--<script src="{{ asset('js/bootstrap.min.js') }}"> </script>--}}
    {{--<script src="{{ asset('js/header.js') }}"></script>--}}
    {{--<link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">--}}
    {{--<link rel="stylesheet" href="{{ asset('css/bootstrap-mod.css') }}">--}}

    {{--<link rel="stylesheet" href="{{ asset('jquery-ui/themes/base/jquery-ui.min.css') }}">--}}
    {{--<link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">--}}
    {{--<link rel="stylesheet" href="{{ asset('css/webfonts/style.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">

    @yield('css')
    <script src="{{ asset('js/bootstrap.min.js') }}"> </script>
    @yield('script')
</head>
<body>
<div class="container-fulid">
    @yield('content')
</div>
</body>
</html>
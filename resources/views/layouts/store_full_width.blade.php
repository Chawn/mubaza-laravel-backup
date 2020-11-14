<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- tag for responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="google-site-verification" content="CLbC6KkSq653BZtWUFzlQU4y7TuwAb8CTykUdQwvvoc" />
    <title>{{ $title }}</title>

    @yield('meta')
    @include('layouts.include.head')

    <script type="javascript">
        $(document).ready(function () {
            $('#search-input').keyup(function (e) {
                var code = e.which;
                if (code == 13 && $(this).val() != '') {
                    window.location = "{{ url('search') }}/" + $(this).val();
                }
            });
            
        });
    </script>
    <style type="text/css">
        .main {
            padding: 0px;
        }
        .carousel {
            position: static;
        }
        @media(max-width: 480px){
            .col-xs-6{
                padding-left: 8px;
                padding-right: 8px;
            }
        }
    </style>
    @yield('css')
    @yield('script')
</head>
<body>
    @yield('promote-bar')
    <div id="container" class="container-fulid">            
        @include('layouts.include.header')
   
        <div class="main">
            @yield('content')
        </div>
    </div>
    @include('layouts.include.footer-index')
    @yield('script-footer')
</body>
</html>
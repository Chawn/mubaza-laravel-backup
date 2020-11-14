<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $title }}</title>

    @yield('meta')
    
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    {{-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> --}}
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


    <link rel="stylesheet" href="{{ asset('css/bootstrap-mod.css') }}">

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

    @yield('css')
    <style>
    .modal-backdrop, .modal-backdrop.in{
      display: none;
      }
      </style>
    @yield('script')


</head>
<body class="skin-blue sidebar-mini">

<div class="container-fulid">
    <div class="">
            @include('backend.layouts.include.header')
            <aside class="main-sidebar">
                @include('backend.layouts.include.sidebar')
            </aside>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1>
                        {!! isset($icon) ? $icon : '' !!}
                        {!! $title !!} <small>{!! isset($sub_title) ? $sub_title : '' !!}</small>
                    </h1>
                    <ol class="breadcrumb">
                        @if($title!="หน้าแรก")
                            <li><a href="{{ url('backend') }}"><i class="fa fa-dashboard"></i> หน้าแรก</a></li>
                            @if(isset($parent_pages))
                                    <li><a href="{{ $parent_pages['url'] }}">{{ $parent_pages['title'] }}</a></li>
                            @endif
                            <li class="active">{!! $title !!}</li>
                        @endif
                        
                    </ol>
                </section>

                <section class="content">
                    @yield('content')
                </section>
            </div>
        </div>
    </div>
</div>


</div><!-- end container -->

@include('backend.layouts.include.footer')
@yield('script-footer')
</body>
</html>
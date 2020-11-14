
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- tag for responsive -->
    <meta name="viewport" content="width=device-width; initial-scale = 1.0; maximum-scale=1.0; user-scalable=no" />
    <title>{{ $title }} : {{ config('profile.sitename') }}</title>
    @yield('meta')

    @include('layouts.include.head')
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
    <script>
        $(document).ready(function() {
           $('#search-input').keyup(function(e) {
               var code = e.which;
               if(code == 13) {
                   window.location = "{{ url('search') }}/" + $(this).val();
               }
           }) ;

            $(".clickable-row").click(function() {
                window.location = $(this).data("href");
            });
        });
    </script>
    @yield('css')
    @yield('script')
</head>
<body>
<div id="container" class="container-fulid">
	@include('layouts.include.header')
  
	@yield('content')  
</div>
@include('layouts.include.footer')
@yield('script-footer')
</body>
</html>
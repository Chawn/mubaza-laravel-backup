<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- tag for responsive -->
    <meta name="viewport" content="width=device-width; initial-scale = 1.0; maximum-scale=1.0; user-scalable=no" />
    <meta name="google-site-verification" content="CLbC6KkSq653BZtWUFzlQU4y7TuwAb8CTykUdQwvvoc" />
    <title>ggseven.com : ขออภัย ไม่พบหน้าที่คุณต้องการ</title>
    @yield('meta')

    @include('layouts.include.head')
    @yield('css')
    @yield('script')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
           $('#search-input').keyup(function(e) {
               var code = e.which;
               if(code == 13) {
                   window.location = "{{ \Request::url() }}?q=" + $(this).val();
               }
           }) ;

            $(".clickable-row").click(function() {
                window.location = $(this).data("href");
            });
        });
    </script>
    
</head>
<body>
<div id="container" class="container-fulid">
    @include('layouts.include.header')
    @if(in_array(\Request::path(), ['sell', 'sell/set-goal', 'sell/set-detail','order/checkout', 'design', 'design/checkout']) || \Request::is('order/order-success/*'))
    {{--@include('layouts.include.design-breadcrumb')--}}
    @endif
  <div class="container">
    <div class="main">
      @yield('content')
    </div>
  </div>  
</div>

@include('layouts.include.footer')
@yield('script-footer')
</body>
</html>
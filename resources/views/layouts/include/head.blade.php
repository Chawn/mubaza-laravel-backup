<meta name="google-site-verification" content="TWv1bm5JMmj2FxlUQ8qd_KsmNk8rmbsaRelrXnxZ7UU" />
<meta name="viewport" content="width=device-width; initial-scale = 1.0; maximum-scale=1.0; user-scalable=no" />
<link rel="stylesheet" href="{{ asset('css/webfonts/style.css') }}">

<link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('jquery-ui/themes/base/jquery-ui.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}">
<link rel="stylesheet" href="{{ asset('css/header.css') }}">
<link rel="stylesheet" href="{{ asset('css/footer.css') }}">
<link rel="stylesheet" href="{{ asset('css/bootstrap-mod.css') }}">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<link rel="stylesheet" href="{{ asset('whhg-icon/css/whhg.css') }}">


<!--


<link rel="stylesheet" href="{{ asset('css/index.css') }}">



-->
<link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/jquery.bxslider/jquery.bxslider.css') }}">

<link rel="stylesheet" href="{{ asset('css/product.css') }}">

<link rel="icon" href="{{asset('images/favicon.png')}}" type="image/x-icon" />

<script src="{{ asset('jquery/dist/jquery.min.js') }}"> </script>
<script src="{{ asset('jquery-ui/jquery-ui.min.js') }}"> </script>
<script src="{{ asset('js/bootstrap.js') }}"> </script>
<script src="{{ asset('js/tablesorter.js') }}"></script>
<script src="{{ asset('js/report.js') }}"></script>
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/locales/th.js') }}"></script>
<script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('js/cart.js') }}"></script>
<script src="{{ asset('js/store.js') }}"></script>
<script src="{{ asset('js/header.js') }}"></script>
<script src="{{ asset('js/jquery.bxslider/jquery.bxslider.min.js') }}"></script>
<script src="{{ asset('js/notification.js') }}"></script>
@if(\Route::currentRouteName()!='campaign-show')
	@include('layouts.include.meta-index')
@endif

@include('layouts.include.google-analytics')

<!--Start of Zopim Live Chat Script-->
<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
$.src="//v2.zopim.com/?3L54NGTKFa7ow4sZmC5styDar6AIHRgO";z.t=+new Date;$.
type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
</script>
<!--End of Zopim Live Chat Script-->



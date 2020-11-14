<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- tag for responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-site-verification" content="CLbC6KkSq653BZtWUFzlQU4y7TuwAb8CTykUdQwvvoc" />
    <title>{{ $title }} : {{ config('profile.sitename') }}</title>
    @yield('meta')
    @include('manager.layouts.include.head')
    
    @yield('css')
    <style>
        body{
            background: #fff;
        }
        .content-header .title{
            font-weight: bold;
        }
        .content-wrapper{
            width: 100%;
            margin: 0 0 25px 0;
        }
        #main-nav-two{
            box-shadow: 0 0 5px rgba(133, 141, 155, 0.65);
            border-bottom: solid 1px #D2D6DE;
        }
        .main-footer{
            margin-left: 0;
            background: #33383a;
        }
        #main-nav-two{
            background: #fff;
        }
        .font-big{
            font-size: 16px;
            font-weight: bold;    
        }
        #main-content{
            margin-bottom:40px;
            max-height: 100%;
        }
        @media(max-width: 767px){
            #main-nav{
                height: 64px;
            }
            #main-nav .navbar-header{
                margin-left: 0px;
                margin-right: 0px;
            }
        }
    </style>
    @yield('script')
    <script>
    $(document).ready(function() {
        var windowHeight = $(window).height();
        var headerHeight = $('#main-nav-wrapper').height();
        var headerHeight = $('#footer-main').height();

        $('.content').css({
            'min-height' : windowHeight - (headerHeight + headerHeight + 105),
        });
    });
    </script>

</head>
<body>
    <div class="container-fulid">
        <div id="manager">
            <div class="row">
                <div class="col-md-12">
                    @include('manager.layouts.include.header')
                     @yield('cover')
                </div>
            </div>            
           
            <div id="main-container" class="container">
                <div class="row">
                    <div class="col-md-12">
                        @if(\Auth::user()->check())
                            <section class="page-header">     
                                <h3><strong>{{ $title }}</strong></h3>
                            </section>
                        @else
                            @if(\Request::is('associate'))
                                
                            @else
                            <section class="page-header">     
                                <h3><strong>{{ $title }}</strong></h3>
                            </section>
                            @endif
                        @endif
                        <div id="main-content" class="content">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer id="footer-main" class="main-footer no-print">
        <div class="container">
            <strong>
                © 2015 &middot; ggseven.com
            </strong>
            &nbsp;&middot;&nbsp;
            <a href="{{ action('HelpController@getPrivacy_policy') }}">นโยบายความเป็นส่วนตัว</a>
            &nbsp;&middot;&nbsp;
            <a href="{{ action('HelpController@getTerms') }}">ข้อตกลงการใช้งาน</a>
            <div class="pull-right">
                <div id="google_translate_element"></div>
                    <script type="text/javascript">
                        function googleTranslateElementInit() {
                            new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, multilanguagePage: true}, 'google_translate_element');
                        }
                    </script>
                    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
            </div>
        </div>
    </footer>

    @yield('script-footer')
</body>
</html>
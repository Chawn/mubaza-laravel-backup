<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- tag for responsive -->
    <meta name="viewport" content="width=device-width; initial-scale = 1.0; maximum-scale=1.0; user-scalable=no" />
    <title>{{ $title }}</title>

    @yield('meta')
    @include('layouts.include.head')
    <script>
        $(document).ready(function() {
           $('#search-input').keyup(function(e) {
                var code = e.which;
               if(code == 13) {
                   window.location = "{{ url('search') }}/" + $(this).val();
               }
           }) ;

        });

    </script>
    <style type="text/css" media="screen">
        body{
            background: #f5f5f5;
            
        }
       .content{
        font-size: 16px;
        min-height: 500px;
       }
       #help-menu {
        display: none;
       } 
       .breadcrumb{
        padding-left:0px;
       }      
       @media (max-width: 480px){
            #help-menu{
                display: block;
            }
            #btn-help-menu{
                margin-top: 15px;
                width: 100%;
            }
            .sidebar-left{
                display: none;
            }
            .content{
                padding: 0 15px;
            }
            .mobile-hide{
                display: none;
            }
            #help-menu-mobile{
                padding-top: 18px;
            }
            #help-menu-mobile ul li a{
                padding:10px 0 0 10px;
                display: block;
            }
       }
       @media (min-width: 481px) and (max-width: 767px){
        .mobile-hide {
            display: none;
        }
        #help-menu{
            display: block;
        }
        #btn-help-menu{
            width: 100%;
        }
        
       } 
       h4.article-title{
            font-weight: bold!important;
            margin: 25px 0 10px 0;
        }
    </style>
    @yield('css')
    @yield('script')
</head>
<body>
@include('layouts.include.header')
    <div id="container" class="container">
        <div class="main">
            <ol class="breadcrumb">
                @if(\Request::path()=='help')
                    <li class="active">{{ $title }}</li>
                @else
                    <li><a class="link-reset" href="{{url('help')}}">ศูนย์ช่วยเหลือ</a></li>
                    <li class="active">{{ $title }}</li>
                @endif
            </ol>
            <div class="row">
                <div class="col-md-3 help-sidebar">
                    <ul class="list-unstyled">
                        <li>
                            <strong>
                                การสั่งซื้อสินค้า
                            </strong>
                        </li>
                        <li>
                            <a class="reset-link" href="{{ action('HelpController@getHowtopay') }}">
                                {{ \Lang::get("messages.howtopay") }}
                            </a>
                        </li>
                        <li>
                            <a class="reset-link" href="{{ action('HelpController@getShipping') }}">
                                {{ \Lang::get("messages.shipping") }}
                            </a>
                        </li>
                        <li>
                            <a class="reset-link" href="{{ action('HelpController@getWarranty') }}">
                                {{ \Lang::get("messages.warranty") }}
                            </a>
                        </li>
                        <li>
                            <a class="reset-link" href="{{ action('HelpController@getContact') }}">
                                {{ \Lang::get("messages.contact") }}
                            </a>
                        </li>
                        <br>
                        <li>
                            <strong>
                                เริ่มต้นขายเสื้อยืด
                            </strong>
                        </li>
                        <li>
                            <a class="reset-link" href="{{ action('AssociateController@getIndex') }}">
                                ระบบ Associate
                            </a>
                        </li>
                        <li>
                            <a class="reset-link" href="{{ action('AssociateController@getIndex') }}">
                                การจ่ายส่วนแบ่ง Creator
                            </a>
                        </li>
                        <li>
                            <a class="reset-link" href="{{ action('AssociateController@getIndex') }}">
                                การจ่ายส่วนแบ่ง Affiliate
                            </a>
                        </li>
                        <li>
                            <a class="reset-link" href="{{ action('AssociateController@getIndex') }}">
                                ลงทะเบียน
                            </a>
                        </li>
                        <br>
                        <li>
                            <strong>
                                ข้อตกลงการใช้งาน
                            </strong>
                        </li>
                        <li>
                            <a class="reset-link" href="{{ url('help/terms') }}">
                                {{ \Lang::get("messages.terms") }}
                            </a>
                        </li>
                        <li>
                            <a class="reset-link" href="{{ url('help/privacy_policy') }}">
                                {{ \Lang::get("messages.privacy_policy") }}
                            </a>
                        </li>
                        <li>
                            <a class="reset-link" href="{{ action('HelpController@getPayment_terms') }}">
                                เงื่อนไขการชำระเงิน
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-9 help-content">
                    
                    {{-- <h3 class="">
                        <strong class="sidebar-title">{{ $title }}</strong>
                    </h3> 
                    
                    <hr>--}}
                    <h2 class="space-lg-3">{{ $title }}</h2>
                
                    @yield('content')
                    
                    
                </div>
            </div>
        </div>
    </div>
@include('layouts.include.footer')
@yield('script-footer')
</body>
</html>
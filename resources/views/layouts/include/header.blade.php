<div id="main-nav-wrapper">
    <nav id="nav-dismissible" class="alert" role="alert">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class=" media space-top-lg-1">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                        <div class="media-left">
                            <i class="fa fa-pencil-square-o fa-4x"></i>
                        </div>
                        <div class="media-body">
                            <h3 class="media-heading">
                                <strong>
                                    Easy Way to Design & Sell Shirts Online.
                                </strong>
                            </h3>
                            <span class="mobile-hide">
                                ร่วมเป็นส่วนหนึ่งกับเรา ลงทะเบียน Associate ได้แล้ววันนี้
                            </span>
                        </div>
                        <div class="media-right text-center">
                            <a href="{{ action('AssociateController@getIndex') }}" class="btn btn-border btn-default">
                                ลงทะเบียน Associate
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <nav id="main-nav" class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <div id="logo">
                    <a class="logo" href="{{ url('/') }}" title="" style="">
                        <img src="{{ asset('images/mubaza-logo.png') }}" alt="mubaza-logo">
                        <span>
                            <strong style="font-size:14px;">Beta</strong>
                        </span>
                    </a>
                    @if(\Auth::user()->check())
                        <button class="mobile-btn navbar-toggle collapsed btn-slide-right">
                            <div class="profile-circle">
                                <span class="profile-image"
                                      style="background-image:url('{{ asset(Auth::user()->user()->avatar) }}')"></span>
                            </div>
                        </button>
                    @else
                        <button id="btn-main" class="btn-menu-mobile toggle-mobile navbar-toggle collapsed btn-slide-right">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar top-bar"></span>
                            <span class="icon-bar middle-bar"></span>
                            <span class="icon-bar bottom-bar"></span>
                        </button>
                    @endif
                    <!--                    
                    <a id="mobile-btn-cart" data-toggle="modal" href="#modal-cart"
                       class="desktop-hidden mobile-show toggle-mobile collapsed navbar-right">
                        <span class="fa fa-shopping-basket"></span>
                        <span class="badge badge-primary cart_item_count">
                           0
                        </span>
                    </a>
                    -->
                </div>
            </div>
            <form class="navbar-form navbar-left searchbar" role="search" action="{{ url('search') }}">
                <div class="input-group">
                    <input id="search-input" type="text" class="form-control" name="q"
                           value="{{ isset($keyword) ? $keyword : '' }}" placeholder="ค้นหาเสื้อยืดตัวใหม่">

                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-default btn-bright" data-href="{{url('new-search')}}">
                            &nbsp;<i class="fa fa-search"></i>&nbsp;
                        </button>
                    </div>
                </div>
            </form>
            <div id="main-nav-collapse">
                <ul id="menu-desktop" class="nav navbar-nav navbar-right collapse navbar-collapse" role="menu">
                    <li class="mobile-hide">
                        <a id="btn-cart" data-toggle="modal" href="#modal-cart">
                            <i class="fa fa-plusx fa-shopping-basket"></i>
                            <span class="badge badge-danger cart_item_count">
                               0
                            </span>
                        </a>
                    </li>
                    @if(\Auth::user()->check())
                    <li class="mobile-hide dropdown">
                        <a id="btn-notification" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-plusx fa-bell-o"></i>
                            @if($unread_notification_count>0)
                                <span class="badge badge-danger">
                                   {{ $unread_notification_count }}
                                </span>
                            @endif
                        </a>
                        <div id="dropdown-notification" class="dropdown-menu list-group notification">
                            <div class="notification-header">
                                 การแจ้งเตือน
                            </div>
                            <div class="notification-body">
                                @forelse($user_notifications as $notify)
                                    <a href="{{ $notify->url ? $notify->url : 'javascript:void(0)' }}" class="list-group-item" style="background: {{ $notify->is_read ? '#fff' : '#f5f5f5' }}">
                                        {{ $notify->message }}<span class="pull-right" style="color: #aaa">{{ $notify->created_at->format('j/n/Y H:i') }}</span></a>
                                @empty
                                    <a href="javascript:void(0)" class="list-group-item">ไม่มีการแจ้งเตือน</a>
                                @endforelse
                            </div>
                            <div class="notification-footer">
                                <div class="text-center"><a href="javascript:void(0)">ดูทั้งหมด</a></div>
                            </div>                           
                            
                        </div>
                    </li>
                    @endif
                    @if(\Auth::user()->check())
                        <!-- Desktop Login แล้ว-->
                        <li>
                            <a id="a-profile" href="#" class="dropdown-toggle" data-toggle="dropdown" >
                                <div class="profile-circle">
                                    <span class="profile-image"
                                          style="background-image:url('{{ asset(Auth::user()->user()->avatar) }}')"></span>
                                </div>
                                <span>{{ is_null(Auth::user()->user()->username) ? Auth::user()->user()->full_name : Auth::user()->user()->username }}</span> 
                                <span class="caret"></span>
                            </a>
                            <ul id="user-dropdown" class="ul-style-1 dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ action('UserController@getIndex', \Auth::user()->user()->getID())}}">
                                        <i class="fa fa-user"></i> แดชบอร์ดของฉัน
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ action('UserController@getOrderHistory', \Auth::user()->user()->getID()) }}">
                                        <i class="fa fa-file-text-o"></i> ประวัติการสั่งซื้อ</a>
                                </li>
                                <li>
                                    <a href="{{ action('UserController@getWishlist', \Auth::user()->user()->getID()) }}">
                                        <i class="fa fa-heart-o"></i> 
                                        รายการที่ชื่นชอบ
                                    </a>
                                </li>
                                @if(\Auth::user()->user()->is_designer || \Auth::user()->user()->is_affiliate)
                                    <li>
                                        <a href="{{ action('AssociateController@getIndex')}}">
                                            <i class="fa fa-flag"></i> ระบบสมาชิก Associate
                                        </a>
                                    </li>
                                @endif
                                <li><a class=''
                                       href="{{ action('UserController@getLogout', \Auth::user()->user()->getID()) }}">
                                       <i class="fa fa-sign-out"></i> {{ Lang::get('messages.logout') }}</a>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="mobile-hide">
                            <a data-toggle="modal" href="#modal-login">
                                <i class="fa fa-plusx fa-user"></i> เข้าสู่ระบบ/สมัครสมาชิก
                            </a>
                        </li> 
                    @endif
                    
                </ul>
            </div>

            <div class="slide-menu right">
                <div class="slide-dialog">
                    <div class="slide-content">
                        <button type="button" class="close-slide"><span aria-hidden="true">&times;</span></button>
                        <div id="mobile-login-menu" class="mobile-menu nav-mobile-collapse">
                            <ul class="list-group">
                                @if(\Auth::user()->check())
                                    <!-- Mobile Login แล้ว-->
                                    <li class="li-user">
                                        <a href="{{ action('UserController@getIndex', \Auth::user()->user()->getID())}}"
                                           id="user-link">
                                            <div class="profile-circle">
                                                <span class="profile-image"
                                                      style="background-image:url('{{ asset(Auth::user()->user()->avatar) }}')"></span>
                                            </div>
                                            {{ is_null(Auth::user()->user()->username) ? Auth::user()->user()->full_name : Auth::user()->user()->username }}
                                        </a>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="{{ url('/') }}">
                                            <i class="fa fa-home"></i> กลับไปหน้าแรก
                                        </a>
                                    </li>
                                    @if(\Auth::user()->user()->is_designer || \Auth::user()->user()->is_affiliate)
                                        <li class="list-group-item">
                                            <a href="{{ action('AssociateController@getIndex')}}">
                                                <i class="fa fa-flag"></i> หน้าสำหรับ Associate
                                            </a>
                                        </li>
                                    @endif
                                    <li class="list-group-item">
                                        <a href="{{ action('UserController@getIndex', \Auth::user()->user()->getID())}}">
                                            <i class="fa fa-dashboard"></i> แดชบอร์ดของฉัน
                                        </a>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="{{ action('UserController@getProfile', \Auth::user()->user()->getID())}}">
                                            <i class="fa fa-user"></i> บัญชีผุ้ใช้
                                        </a>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="{{ url('help') }}">
                                            <i class="fa fa-info-circle"></i> ศูนย์ช่วยเหลือ
                                        </a>
                                    </li>
                                    <li class="list-group-item"><a class=''
                                           href="{{ action('UserController@getLogout', \Auth::user()->user()->getID()) }}">
                                           <i class="fa fa-sign-out"></i> {{ Lang::get('messages.logout') }}</a>
                                    </li>
                                @else
                                    <!-- Mobile ยังไม่ได้ Login-->
                                    <li class="list-group-item">
                                        <a data-toggle="modal" href="#modal-login">
                                            <i class="fa fa-user"></i> เข้าสู่ระบบ/สมัครสมาชิก
                                        </a>
                                    </li> 
                                @endif

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</div>

<div id="modal-login" class="modal modal-mobile-full fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <h4 class="modal-title" id="myModalLabel">เข้าสู่ระบบ</h4>
            </div>
            <div class="modal-body">
                <div id="login-wrapper">
                    <div class="social-auth-links text-center">
                        <div class="row">
                            <div class="col-sm-12">
                                <p>
                                    <a href="{{ action('UserController@getSocialLogin', 'facebook') }}?return={{ \Request::path() }}"
                                       class="btn btn-block btn-social btn-facebook btn-lg" id="facebook">
                                        <i class="fa fa-facebook"></i>
                                        เข้าสู่ระบบด้วย Facebook
                                    </a>
                                </p>
                            </div>
                            <div class="col-sm-12">
                                <p>
                                    <a href="{{ action('UserController@getSocialLogin', 'google') }}?return={{ \Request::path() }}"
                                       class="btn btn-block btn-social btn-google btn-lg" id="google">
                                        <i class="fa fa-google-plus fa-2x"></i>
                                        เข้าสู่ระบบด้วย Google
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <h4 class="text-center">- หรือ - </h4>
                    <div id="login-row">
                        <form role="form" method="POST" action="{{ action('UserController@postLogin') }}?return={{ \Request::path() }}"
                              id="form-login">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group has-feedback">
                                <input type="email" name="email" id="email" class="form-control" placeholder="อีเมล"
                                       required>
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                            </div>

                            <div class="form-group has-feedback">
                                <input type="password" name="password" id="password" class="form-control"
                                       placeholder="รหัสผ่าน" required>
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <p class="text-left">
                                        <input type="checkbox" name="keep_login" id="keep_login">
                                        <label for="keep_login">ให้ฉันอยู่ในระบบต่อไป</label>
                                    </p>
                                </div>
                                <div class="col-xs-6">
                                    <p class="text-right">
                                        <a href="{{ url('user/forgot-password') }}" title="ลืมรหัสผ่าน">
                                            ลืมรหัสผ่าน?
                                        </a>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="submit" id="btn-login" class="btn btn-success btn-block btn-lg">
                                        เข้าสู่ระบบ
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12">
                            <p class="text-center">
                                ยังไม่ได้เป็นสมาชิก?&nbsp;
                                <a href="{{action('UserController@getSignup')}}" id="newsignup">สมัครสมาชิก</a>
                            </p>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
          </div>

    </div>
</div>


<div id="modal-cart" class="modal  fade modal-cart">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">สินค้าในรถเข็นของคุณ</h4>
            </div>
            <div class="modal-body" id="cart-wrapper">
            </div>
            <div class="modal-footer">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <button type="button" class="btn btn-bright btn-default pull-left" data-dismiss="modal">
                        <i class="fa fa-angle-double-left"></i>&nbsp;เลือกซื้อสินค้าต่อ
                    </button>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <a href="{{ action('OrderController@getCheckout') }}" class="btn btn-success" id="checkout-btn" target="_self">
                        ชำระเงิน &nbsp;<i class="fa fa-angle-double-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="main-nav-wrapper">    
    <nav id="main-nav" class="navbar navbar-default" >
        <div class="container">
            @if(\Auth::user()->check())
                <div class="navbar-header">                      
                    <div id="logo">
                        <a class="logo" href="{{ action('AssociateController@getIndex') }}" title="">
                            <img src="{{ asset('images/mubaza-logo.png') }}">
                            <img class="associate-logo" src="{{ asset('images/associate.png') }}" alt="">
                        </a>
                        <button class="mobile-btn navbar-toggle collapsed btn-slide-right">
                            <div class="profile-circle">
                                <span class="profile-image"
                                      style="background-image:url('{{ asset(Auth::user()->user()->avatar) }}')"></span>
                            </div>
                        </button>
                        <div class="slide-menu right">
                            <div class="slide-dialog">
                                <div class="slide-content">
                                    <button type="button" class="close-slide"><span aria-hidden="true">&times;</span></button>
                                    <div id="mobile-login-menu" class="mobile-menu nav-mobile-collapse" style="text-align:left;">
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
                                                <li class="list-group-item">
                                                    <a href="{{ action('OrderController@getUpdatePayment', \Auth::user()->user()->getID()) }}">
                                                        <i class="fa fa-pencil-square-o"></i> แจ้งชำระเงิน
                                                    </a>
                                                </li>
                                                <li class="list-group-item">
                                                    <a href="{{ action('AssociateController@getIndex', \Auth::user()->user()->getID())}}">
                                                        <i class="fa fa-flag"></i> หน้าสำหรับ Associate
                                                    </a>
                                                </li>

                                                <li class="list-group-item">
                                                    <a href="{{ action('UserController@getIndex', \Auth::user()->user()->getID())}}">
                                                        <i class="fa fa-dashboard"></i> แดชบอร์ดของฉัน
                                                    </a>
                                                </li>
                                                
                                                {{-- <li>
                                                    <a >
                                                        <i class="fa fa-envelope-o"></i> ข้อความแจ้งเตือน</a>
                                                </li>   --}}                                  
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
                                                <li class="list-group-item">
                                                    <a class=''
                                                       href="{{ action('UserController@getLogout', \Auth::user()->user()->getID()) }}">
                                                       <i class="fa fa-sign-out"></i> {{ Lang::get('messages.logout') }}
                                                    </a>
                                                </li>
                                            @else
                                                <!-- Mobile ยังไม่ได้ Login-->
                                                <li class="list-group-item">
                                                    <a href="{{ action('OrderController@getUpdatePayment') }}">
                                                        <i class="fa fa-pencil-square-o"></i> แจ้งชำระเงิน
                                                    </a>
                                                </li>
                                                <li class="list-group-item">
                                                    <a href="{{ action('HelpController@getHowtopay') }}">
                                                        <i class="fa fa-credit-card"></i> วิธีการชำระเงิน
                                                    </a>
                                                </li>                                                    
                                                <li class="list-group-item">
                                                    <a href="{{ action('HelpController@getContact') }}">
                                                        <i class="fa fa-phone-square"></i> 
                                                        ติดต่อเรา
                                                    </a>
                                                </li>
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
                </div>
            @else
                <div class="navbar-header">
                    <button id="btn-main" class="btn-menu-rotate navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#menu-desktop" aria-expanded="false" aria-controls="#menu-desktop">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar top-bar"></span>
                        <span class="icon-bar middle-bar"></span>
                        <span class="icon-bar bottom-bar"></span>
                    </button>
                    
                    <div id="logo">
                        <a class="logo" href="{{ action('AssociateController@getIndex') }}" title="">
                            <img src="{{ asset('images/mubaza-logo.png') }}">
                            <img class="associate-logo" src="{{ asset('images/associate.png') }}" alt="">
                        </a>
                    </div>                       
                </div>
            @endif
            
            <ul id="menu-desktop" class="nav navbar-nav navbar-right collapse navbar-collapse" role="menu">              
                @if(\Auth::user()->check())
                    @if(\Auth::user()->user()->isAssociate())
                        <li>
                            <a href="#" title="">
                                Affiliate id: {{ Auth::user()->user()->affiliate->id }}
                            </a>
                        </li>
                    @endif
                    <li>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" >
                            <div class="profile-circle">
                                <span class="profile-image"
                                style="background-image:url('{{ asset(Auth::user()->user()->avatar) }}')"></span>
                            </div>
                            {{ is_null(Auth::user()->user()->username) ? Auth::user()->user()->full_name : Auth::user()->user()->username }} 
                            <span class="caret"></span>
                        </a>
                        <ul id="user-dropdown" class="dropdown-menu ul-style-1" role="menu">
                            <li>
                                <a href="{{ url('/') }}">
                                    <i class="fa fa-home"></i>&nbsp;กลับสู่หน้าแรก
                                </a>
                            </li>
                            <li>
                                <a href="{{url('guide/create-art')}}">
                                    <i class="fa fa-book"></i>&nbsp;คู่มือออกแบบลาย
                                </a>
                            </li>
                            <li>
                                <a href="{{url('associate/creator')}}">
                                    <i class="fa fa-info-circle"></i>&nbsp;คำแนะนำเบื้องต้นสำหรับ Creator
                                </a>
                            </li>
                            <li>
                                <a href="{{url('associate/affiliate')}}">
                                    <i class="fa fa-info-circle"></i>&nbsp;คำแนะนำเบื้องต้นสำหรับ Affiliate
                                </a>
                            </li>
                            <li>
                                <a 
                                href="{{ action('UserController@getLogout', \Auth::user()->user()->getID()) }}">
                                    <i class="fa fa-sign-out"></i>
                                    {{ Lang::get('messages.logout') }}</a>
                            </li>
                        </ul>
                     </li>
                @else
                    <li>
                        <a href="{{url('/')}}">
                            <i class="fa fa-home"></i> กลับไปหน้าแรก
                        </a>
                    </li> 
                    
                    <li class="">
                        <a data-toggle="modal" href="#modal-login">
                            <i class="fa fa-user"></i>
                            เข้าสู่ระบบ
                        </a>
                    </li>
                @endif
            </ul>
            
        </div>  
    </nav>
    @if(\Request::is('store-create'))
                                
    @else
        @if(\Auth::user()->check() && \Auth::user()->user()->isAssociate())
            <nav id="main-nav-tool" class="navbar navbar-primary">
                <div class="container">
                    <div class="navbar-header">
                        <ul class="nav navbar-nav">
                            @if(\Auth::user()->check())
                            <li class="dropdown">
                                <button class="btn-menu-rotate toggle-mobile navbar-toggle collapsed"
                                type="button" id="associate-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    {{ $title }}
                                    <div class="pull-right btn-toggle">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar top-bar"></span>
                                        <span class="icon-bar middle-bar"></span>
                                        <span class="icon-bar bottom-bar"></span>
                                    </div>                                    
                                </button>
                                <ul class="dropdown-menu list-group" aria-labelledby="associate-dropdown">
                                        <li class="dropdown-title">
                                            <p>การออกแบบ</p>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="{{ action('AssociateController@getCreate') }}">
                                                สร้างสินค้าใหม่
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="{{ action('AssociateController@getDesign') }}">
                                                
                                                สินค้าที่ฉันออกแบบ
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="{{ url('store-create') }}">                                                
                                                สร้างสโตร์
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="{{ url('manager-store') }}">                                                
                                                สโตร์ของฉัน
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="{{ asset('resources/GG7-Art-Template.psd') }}">
                                                
                                                ดาวน์โหลด Art Template
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="{{ asset('resources/GG7-Mockup.psd') }}">
                                                
                                                ดาวน์โหลด Mockup Template
                                            </a>
                                        </li>
                                    <li class="dropdown-title">
                                        <p>แชร์</p>
                                    </li>
                                    <li class="list-group-item">
                                       <a href="{{ action('AssociateController@getGenerateLink') }}" class="subnav-item" >
                                            สร้างลิงค์สินค้า
                                        </a>
                                    </li>
                                    <li class="dropdown-title">
                                        <p>รายได้</p>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="{{ action('AssociateController@getCurrentCommission') }}">
                                            รายได้ปัจจุบัน
                                        </a>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="{{ action('AssociateController@getSellReport') }}">
                                            ส่วนแบ่ง Creator
                                        </a>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="{{ action('AssociateController@getAffiliateReport') }}">
                                            ส่วนแบ่ง Affiliate
                                        </a>
                                    </li>
                                    <li class="dropdown-title">
                                        <p>ตั้งค่า</p>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="{{ action('AssociateController@getBankAccount') }}">
                                            บัญชีธนาคาร
                                        </a>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="{{ action('AssociateController@getProfileSetting') }}">
                                            โปรไฟล์
                                        </a>
                                    </li>                                
                                    <li class="dropdown-title">
                                        <p>ช่วยเหลือ</p>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="{{url('guide/create-art')}}">
                                            คู่มือออกแบบลาย
                                        </a>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="{{url('associate/creator')}}">
                                            คำแนะนำเบื้องต้นสำหรับ Creator
                                        </a>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="{{url('associate/affiliate')}}">
                                            คำแนะนำเบื้องต้นสำหรับ Affiliate
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            @endif
                        </ul>
                    </div>
                    @if(\Auth::user()->check())                      
                        <div id="navbar2" class="navbar-collapse collapse">
                            <ul class="nav navbar-nav navbar-header" role="menu">        
                                <li>
                                    <a href="#" class="subnav-item dropdown-toggle" data-toggle="dropdown"
                                        aria-selected="{{ (\Request::is('associate/design') || \Request::is('associate/create') ? 'true' : 'false') }}">
                                        <i class="fa fa-edit"></i> การออกแบบ <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="{{ action('AssociateController@getCreate') }}">
                                                สร้างสินค้าใหม่
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ action('AssociateController@getDesign') }}">
                                                สินค้าที่ฉันออกแบบ
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ asset('resources/GG7-Art-Template.psd') }}">
                                                ดาวน์โหลด Art Template
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ asset('resources/GG7-Mockup.psd') }}">
                                                ดาวน์โหลด Mockup Template
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#" class="subnav-item dropdown-toggle" data-toggle="dropdown"
                                    aria-selected="{{ (\Request::is('associate/sell-report') || \Request::is('associate/share') ? 'true' : 'false') }}">
                                        <i class="fa fa-share-square-o"></i> แชร์ <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li class="subnav-item">
                                           <a href="{{ action('AssociateController@getGenerateLink') }}" >
                                                สร้างลิงค์สินค้า
                                            </a>
                                        </li>
                                        <li class="subnav-item">
                                            <a href="{{ url('manager-store') }}">        
                                                สโตร์ของฉัน
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#" class="subnav-item dropdown-toggle" data-toggle="dropdown"
                                    aria-selected="{{ (\Request::is('associate/profit') ? 'true' : 'false') }}">
                                        <i class="fa fa-money"></i> รายได้ <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li class="subnav-item">
                                            <a href="{{ action('AssociateController@getCurrentCommission') }}">
                                                รายได้ปัจจุบัน
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ action('AssociateController@getBankAccount') }}" class="subnav-item "
                                            aria-selected="{{ (\Request::is('associate/profit') ? 'true' : 'false') }}">
                                               บัญชีธนาคาร
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#" class="subnav-item dropdown-toggle" data-toggle="dropdown"
                                    aria-selected="{{ (\Request::is('associate/sell-report') || \Request::is('associate/affiliate-report') ? 'true' : 'false') }}">
                                        <i class="fa fa-bar-chart"></i> รายงาน <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li class="subnav-item">
                                            <a href="{{ action('AssociateController@getSellReport') }}">
                                                ยอดขาย Creator
                                            </a>
                                        </li>
                                        <li class="subnav-item">
                                            <a href="{{ action('AssociateController@getAffiliateReport') }}">
                                                ยอดขาย Affiliate
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                
                                
                                {{-- <li class="">

                                    <a class="subnav-item" href="{{ action('AssociateController@getMessage') }}" >
                                   ข้อความเจ้งเตือน</a>
                                </li> --}}
                                <li>
                                    <a class="subnav-item" href="{{ action('AssociateController@getProfileSetting') }}" 
                                    aria-selected="{{ (\Request::is('associate/profile-setting') ? 'true' : 'false') }}">
                                        <i class="fa fa-user"></i> โปรไฟล์
                                    </a>
                                </li>
                            </ul>
                        </div>
                    
                    
                </div>
            </nav>
        @endif
    @endif
</div> <!-- END main-nav-wrapper-->
@endif

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
                                <div class="col-sm-12">
                                    <button type="submit" id="btn-login" class="btn btn-success btn-block btn-lg">
                                        เข้าสู่ระบบ
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <p>
                                <a href="{{ url('user/forgot-password') }}" title="ลืมรหัสผ่าน" class="link-reset">
                                    ลืมรหัสผ่าน?
                                </a>
                            </p>
                            <p>
                                <a href="{{action('UserController@getSignup')}}" id="newsignup"
                                   class="link-reset">
                                    สมัครสมาชิกด้วยอีเมล
                                </a>
                            </p>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
          </div>

    </div>
</div>

<div id="modal-cart" class="modal modal-mobile-full fade modal-cart">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h2 class="modal-title">ตะกร้าสินค้า</h2>
            </div>
            <div class="modal-body" id="cart-wrapper">
            </div>
            <div class="modal-footer">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <button type="button" class="btn btn-link pull-left" data-dismiss="modal">
                        <i class="fa fa-angle-double-left"></i>&nbsp;เลือกซื้อสินค้าต่อ
                    </button>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <a href="{{ action('OrderController@getCheckout') }}" class="btn btn-success" id="checkout-btn">ดำเนินการต่อ</a>
                </div>
            </div>
        </div>
    </div>
</div>
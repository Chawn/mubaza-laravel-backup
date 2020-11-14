<div id="section-slide" class="carousel slide" data-ride="carousel" style="position:relative;">
    <!--
    <ol class="carousel-indicators">
        <li data-target="#section-slide" data-slide-to="0" class="active"></li>
        <li data-target="#section-slide" data-slide-to="1"></li>
        <li data-target="#section-slide" data-slide-to="2"></li>
    </ol>-->
    <div class="carousel-inner" role="listbox" style="height: 200px">
        
        <div class="bg-carousel item active" style="background:url('{{ asset('images/hero-header/1.jpg') }}'); background-size:cover;background-position:center center;background-repeat: no-repeat;">
            <div class="hero-warp-1"></div>
            <div class="container  fixnonslide">        
                <div class="jumbotron">
                    <div class="group-hero-header hero-1">
                        <div class="hero-head text-center" >
                            <h2 style="text-shadow:0 2px 5px #555">
                                <strong>
                                    Easy way to Design & Sell Shirts Online.
                                </strong>
                            </h2>
                            <h4 style="text-shadow:0 2px 5px #555">
                                ออกแบบและจำหน่ายเสื้อยืดออนไลน์ที่นี่ ไม่มีค่าใช้จ่ายใดๆ ทั้งสิ้น
                            </h4>
                            <p class="description"></p>
                            <div id="group-startbutton">
                                <a href="{{ action("AssociateController@getIndex") }}" class="btn btn-success" title="">
                                    เกี่ยวกับ Associate
                                </a>
                                &nbsp;
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
<div id="footer-index">
    <div class=" container" >
        <div class="row mobile-hide">
            <div class="col-md-3 col-sm-3 col-xs-12">
                <ul>
                    <li class="footer-title">ช่วยเหลือ</li>
                    <li>
                        <a href="{{ action('HelpController@getHowtopay') }}">
                            {{ \Lang::get("messages.howtopay") }}
                        </a>
                    </li>
                    <li>
                        <a class="text-grey" href="{{ action('HelpController@getShipping') }}">
                            {{ \Lang::get("messages.shipping") }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ action('HelpController@getWarranty') }}">
                            {{ \Lang::get("messages.warranty") }}
                        </a>
                    </li>{{-- 
                    <li>
                        <a href="{{ action('HelpController@getValue') }}">
                            สั่งซื้อจำนวนมาก
                        </a>
                    </li> --}}
                    <li>
                        <a class="text-grey" href="{{ action('HelpController@getIndex') }}">
                            {{ \Lang::get("messages.faq") }}
                        </a>
                    </li>

                    <li>
                        <a class="text-grey" href="{{ action('HelpController@getContact') }}">
                            {{ \Lang::get("messages.contact") }}
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <ul>
                    <li class="footer-title">เริ่มต้นขายเสื้อยืด</li>
                    <!--
                    <li>
                        <a href="{{ url('start-campaign') }}">
                            เริ่มสร้างแคมเปญ
                        </a>
                    </li>
                    -->
                    <li>
                        <a href="{{ action('AssociateController@getIndex') }}" >
                            ระบบ Associate คืออะไร
                        </a>
                    </li>
                    <li>
                        <a href="{{ action('AssociateController@getIndex') }}" >
                            เข้าสู่ระบบ
                        </a>
                    </li>
                    <li>
                        <a href="{{ action('AssociateController@getRegister') }}" class="btn btn-primary btn-sm" style="color:#fff;">
                            ลงทะเบียน ฟรี!
                        </a>
                    </li>

                </ul>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <div id="org-left" class="text-left">
                    <ul>
                        <li class="footer-title">เชื่อมต่อกับเรา</li>
                        <li>
                            <a href="">
                                <i class="fa fa-facebook-official"></i> Facebook
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <i class="fa fa-instagram"></i> Instagram
                            </a>
                        </li>
                    </ul>
                </div>{{-- 
                <div id="org-right" class="pull-right">
                    <img src="{{ asset('images/org3.jpg') }}">
                </div> --}}
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <ul>
                    <li class="footer-title">ฝ่ายบริการลูกค้า</li>
                    <li>
                        <a href="#">
                            <i class="fa fa-phone"></i>&nbsp;{{ config('profile.phone-primary') }}
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-envelope"></i>&nbsp;{{ config('profile.email') }}
                        </a>
                    </li>
                    <li>
                        <a href="#" title="">
                            จันทร์ - ศุกร์ 8:30 - 18:00 น.
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="row mobile-hide">
            <div class="col-sm-12">
                <br>
                <div class="text-center">
                    <strong>คู่ค้าที่เราไว้วางใจ</strong>
                    
                    <img class="img-icon-footer" src="{{ asset('images/icon/2.jpg') }}" alt="">
                    <img class="img-icon-footer" src="{{ asset('images/icon/3.png') }}" alt="">
                    <img class="img-icon-footer" src="{{ asset('images/icon/4.png') }}" alt="">
                    <img class="img-icon-footer" src="{{ asset('images/icon/5.jpg') }}" alt="">
                    <img class="img-icon-footer" src="{{ asset('images/icon/6.png') }}" alt="">
                </div>
                <br>
            </div>
        </div>
        
        

        <div class="col-sm-12 col-xs-12">
            <div id="mobile-footer">
                <div class="navbar-toggle collapsed">
                    <ul class="nav navbar-nav">                        
                        <li>
                            <div  id="footer-social">
                                <div id="group-social">
                                    <a class="btn-footer-social" target="_blank"
                                        href="{{ config('profile.facebook') }}">
                                        <i class="fa fa-facebook"></i>
                                    </a>
                                    <a class="btn-footer-social" target="_blank"
                                        href="https://instagram.com/mubazathailand">
                                        <i class="fa fa-instagram"></i>
                                    </a>
                                    
                                </div>
                            </div>
                        </li>
                        <li  class="text-center">
                            <div id="hotline">
                                <span class="footer-title contact">
                                    ฝ่ายบริการลูกค้า
                                </span>
                                <div class="footer-service">
                                   <i class="fa fa-phone"></i>&nbsp;{{ config('profile.phone-primary') }}
                                </div>
                                <div class="footer-service">
                                   <i class="fa fa-facebook-square"></i>&nbsp;fb.com/ggseven.th
                                </div>
                                <div class="footer-service">
                                   ทุกวัน 8:30 - 17:30 น.
                                </div>
                            </div>                                
                        </li>
                        <li>
                            <button class="collapsed footer-title" data-toggle="collapse" href="#footer-help-collapse" aria-expanded="false" aria-controls="footer-help-collapse">
                                ช่วยเหลือ
                                <span ><i class="glyphicon glyphicon-chevron-down"></i></span>
                            </button>
                            <div class="collapse collapse-footer" id="footer-help-collapse">
                                <ul class="nav navbar-nav">
                                    <li>
                                        <a href="{{ action('HelpController@getHowtopay') }}">
                                            {{ \Lang::get("messages.howtopay") }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ action('HelpController@getShipping') }}">
                                            {{ \Lang::get("messages.production_time") }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ action('HelpController@getWarranty') }}">
                                            {{ \Lang::get("messages.warranty") }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ action('HelpController@getSizing') }}">
                                            ตารางเปรียบเทียบขนาดเสื้อ  
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ action('HelpController@getValue') }}">
                                            สั่งซื้อจำนวนมาก
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ action('HelpController@getIndex') }}">
                                            {{ \Lang::get("messages.help_center") }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <button class="collapsed footer-title" data-toggle="collapse" href="#footer-about-collapse" aria-expanded="false" aria-controls="footer-about-collapse">
                            ร่วมธุรกิจ 
                                <span ><i class="glyphicon glyphicon-chevron-down"></i></span>       
                            </button>
                            <div class="collapse collapse-footer" id="footer-about-collapse">
                                <ul class="nav navbar-nav">
                                    <li>
                                        <a href="{{ action('AssociateController@getRegister') }}">
                                            ลงทะเบียน Associate
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ action('AssociateController@getIndex') }}">
                                            เข้าสู่ระบบ Associate
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        
                    </ul>
                </div>
            </div>
        </div>
        
        <!--
        <div id="footer-social">
            <div id="group-social">
                <a class="btn-footer-social" target="_blank"
                    href="{{ config('profile.facebook') }}">
                    <i class="fa fa-facebook"></i>
                </a>
                <a class="btn-footer-social" target="_blank"
                    href="https://twitter.com/mubazathailand">
                    <i class="fa fa-twitter"></i>
                </a>
                <a class="btn-footer-social" target="_blank"
                    href="https://www.pinterest.com/mubazathailand/">
                    <i class="fa fa-pinterest"></i>
                </a>
                <a class="btn-footer-social" target="_blank"
                   href="https://www.youtube.com/channel/UC3nC72N2fJOlbYOcglMrG1g">
                    <i class="fa fa-youtube"></i>
                </a>
                <a class="btn-footer-social" target="_blank"
                    href="https://plus.google.com/u/0/104168738643463861834/posts">
                    <i class="fa fa-google-plus"></i>
                </a>
            </div>
        </div>
        -->

    </div><!-- end container FOOTER -->
    <div id="footer-main">
        <div class="container" >
            <p class="copyright text-center">
                <a href="{{ url('help/about') }}">
                    เกี่ยวกับเรา
                </a>
                &nbsp;&nbsp;
                <a href="{{ url('help/terms') }}">
                    {{ \Lang::get("messages.terms") }}
                </a>
                &nbsp;&nbsp;
                สงวนลิขสิทธิ์ทุกประการ &copy; 2015 &middot; {{ config('profile.sitename') }}
            </p>
        </div><!-- end container FOOTER -->
        

    </div><!-- end FOOTER -->
</div><!-- end FOOTER -->



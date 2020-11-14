@extends('manager.layouts.master')
@section('script')
    <script src="{{ asset('js/hashids.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var deviceWidth = $(window).width();
            var deviceHeight = $(window).height();

            if (deviceWidth < 767){
                $('#about .container').addClass('container-fullid');
                $('#about .container').removeClass('container');
            }            
        });
    </script>
@stop
@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('css/associate.css')}}">
    <style type="text/css" media="screen">
        body{
            background: #e9edf2;
        }
       .main{
        padding-top: 0px;
        margin-top:0px;
       }
        .page-header{
            height:54px;
            width:245px;
            display:inline-block;
            margin: 15px 0 25px 0;
            background:#223240;
            color: #fff;
        }
    </style>
@stop
@section('content')
<section id="hero-associate" class="hero">
    <div class="container">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div id="hero-header">
                <img src="{{ asset('images/associate/advertise3.png') }}" >
            </div>
        </div>
        <div id="regist-group">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="jumbotron text-center">
                    <h1 class="title text-center">
                        จะดีกว่าไหม หากงานของคุณ จะสร้างรายได้ให้คุณตลอดไป
                    </h1>
                    <p class="text-center">ไม่มีขั้นต่ำ ไม่หักค่าใช้จ่าย ไม่มีวันหมดอายุ รับรายได้ทันทีที่เกิดการสั่งซื้อ</p>
                    <div class="col-sm-6 col-xs-12">
                        <a href="{{url('new-affiliate')}}" class="btn btn-block btn-lg btn-blue">
                        ลงทะเบียนAffiliate
                        </a>

                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <a href="{{url('new-artist')}}" class="btn btn-block btn-lg btn-blue">
                        ลงทะเบียนครีเอเตอร์
                        </a>
                    </div>
                </div>
                    
            </div>
        </div>
    </div>
</section>
<section id="about">
    <div class="container">
        <div class="col-md-3 col-sm-3 col-xs-12 pull-right">
            <div id="what-new" class="box border-top">
                <div class="title text-center">
                    <h2 class="">What's New</h2>
                </div>
                    
                <div class="list-group">
                    <a href="#" class="list-group-item">
                        <h3 class="list-title">7 สัปดาห์ 700 ตัว เปิดใจ เคล็ดลับของจ่าสิบเอกประเสริฐ</h3>
                        <span class="small">09 ธันวา 58</span>
                    </a>
                    @for ($i=0;$i<8; $i++)
                    <a href="#" class="list-group-item">
                        <h3 class="list-title">โปรโมชั่นเดือนธันวาคม</h3>
                        <span class="small">09 ธันวา 58</span>
                    </a>
                    @endfor
                </div>
                <a href="#" class="see-more">อ่านเพิ่มเติม<i class="fa fa-angle-double-right"></i></a>
            </div>
        </div>
        <div class="col-md-9 col-sm-9 col-xs-12">
            <div id="artist" class="box border-top">
                <div class="title text-center">
                    <a href="{{url('associate-artist')}}">
                    <h2 class="page-header">
                        Artist
                    </h2></a>
                </div>
                <div class="detail">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="thumbnail text-center">
                                <div class="icon">
                                   <img src="{{ asset('images/associate/tshirt-design.png') }}">
                                </div>
                                <div class="caption text-center">
                                    <h3 class="title">Design</h3>
                                    <p>ออกแบบลายเสื้อ เพื่อสร้างเป็นสินค้าใหม่ ๆ ตามสไตล์คุณ</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="thumbnail text-center">
                                <div class="icon">
                                    <img src="{{ asset('images/associate/shared2.png') }}">
                                    <!--
                                    <i class="fa fa-3x fa-share-alt"></i>
                                    -->
                                </div>
                                <div class="caption text-center">
                                    <h3 class="title">Share</h3>
                                    <p>แชร์การออกแบบของคุณให้โลกรู้ ไม่ว่าจะเป็นทางโซเชียลมีเดีย หรือบล็อคส่วนตัวของคุณ</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="thumbnail text-center">
                                <div class="icon">
                                    <img src="{{ asset('images/associate/money-bag2.png') }}">
                                </div>
                                <div class="caption text-center">
                                    <h3 class="title">Profit</h3>
                                    <p>รับรายได้จากสินค้าของคุณทุการสั่งซื้อ ทันที ไม่มีขั้นต่ำ </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <a class="see-more" href="{{url('associate-artist')}}">อ่านรายละเอียดเพิ่มเติม<i class="fa fa-angle-double-right"></i></a>
                        </div>
                    </div>
                        
                </div>
            </div>
            <div id="affiliate" class="box border-top">
                <div class="title text-center">
                    <a href="{{url('associate-affiliate')}}">
                        <h2 class="page-header">Affiliate</h2>
                    </a>
                </div>
                <div class="detail text-cernter">
                     <div class="row">
                         <div class="col-sm-4">
                            <div class="thumbnail text-center">
                                <div class="icon">
                                    <img src="{{ asset('images/associate/choose-design2.png') }}">
                                </div>
                                    
                                <div class="caption text-center">
                                    <h3>Choose Design</h3>
                                    <p>เลือกสินค้าที่คุณต้องการ จากคลังสินค้าของเรา ซึ่งออกแบบโดยครีเอเตอร์จากทั่วประเทศ</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="thumbnail text-center">
                                <div class="icon">
                                    <img src="{{ asset('images/associate/speaker2.png') }}" alt="">
                                  
                                </div>
                                    
                                <div class="caption text-center">
                                    <h3>Advertise</h3>
                                    <p>นำสินค้าที่คุณเลือกนั้น ไปโฆษณาประชาสัมพันธ์ ไม่ว่าจะเป็นทางโซเชียลมีเดีย หรือ เว็บไซต์ ก็ได้ทั้งนั้น</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="thumbnail text-center">
                                <div class="icon">
                                    <img src="{{ asset('images/associate/moneys2.png') }}" alt="">
                                  
                                </div>
                                    
                                <div class="caption text-center">
                                    <h3>Earn</h3>
                                    <p>รับรายได้ทันทีที่มีการสั่งซื้อสินค้า โดยไม่หักค่าใช้จ่ายใด ๆ ไม่ีขั้นต่ำ ได้รายได้ทุก ๆ การสั่งซื้อ</p>
                                </div>
                            </div>
                        </div>
                     </div>  
                     <div class="row">
                        <div class="col-md-12">
                            <a class="see-more" href="{{url('associate-affiliate')}}">อ่านรายละเอียดเพิ่มเติม<i class="fa fa-angle-double-right"></i></a>
                        </div>
                    </div> 
                </div>
            </div>
            <div id="join">
                    <div class="well square base well-block">
                        <div class="title text-center">
                            <h2>ถ้า Mubaza คือคำตอบที่ใช่ของคุณ</h2>
                            <h4>ลงทะเบียนเพื่อร่วมงานกับเรา ตามแนวทางทึ่คุณถนัด เพื่อรับส่วนแบ่งที่น่าพอใจ ...</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <a href="{{url('new-affiliate')}}" class="btn btn-lg btn-block btn-blue border">
                                    ลงทะเบียน Affiliate
                                </a>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <a href="{{ url('new-artist') }}" class="btn btn-lg btn-block btn-blue border">
                                    ลงทะเบียนครีเอเตอร์
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</section>
        


<!--
<section id="about">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="thumbnail">
                    <img src="{{ asset('images/associate/join.png') }}">
                    <div class="caption text-center">
                        <h3 class="title">ร่วมงานกับเรา ง่าย ไม่มีค่าใช้จ่าย</h3>
                        <p>เพียงเลือกทางของคุณ ไม่ว่าจะเป็นAffiliate หรือครีเอเตอร์ ก็สามารถสร้างรายได้ที่ Mubaza ได้ ไม่มีการหักค่านายหน้า !!!</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="thumbnail">
                    <img src="{{ asset('images/associate/money.png') }}">
                    <div class="caption text-center">
                        <h3 class="title">รับส่วนแบ่งสูงสุดถึง 30%</h3>
                        <p>เพียงเลือกทางของคุณ ไม่ว่าจะเป็นAffiliate หรือครีเอเตอร์ ก็สามารถสร้างรายได้ที่ Mubaza ได้ ไม่มีการหักค่านายหน้า !!!</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="thumbnail">
                    <img src="{{ asset('images/associate/support.png') }}">
                    <div class="caption text-center">
                        <h3 class="title">บริการช่วยเหลือ</h3>
                        <p>เพียงเลือกทางของคุณ ไม่ว่าจะเป็นAffiliate หรือครีเอเตอร์ ก็สามารถสร้างรายได้ที่ Mubaza ได้ ไม่มีการหักค่านายหน้า !!!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="affiliate" class="associates">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="well eee well-block">
                        <div class="title text-right">
                            <h1>Affiliate คืออะไร?</h1>
                        </div>
                        <div class="see-more text-right">
                            <a href="#">อ่านเพิ่มเติม<i class="fa fa-angle-double-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="artist" class="associates">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="well ced well-block">
                        <div class="title">
                            <h1>ครีเอเตอร์คือใคร?</h1>
                        </div>
                        <div class="see-more text-right">
                            <a href="#">อ่านเพิ่มเติม<i class="fa fa-angle-double-right"></i></a>
                        </div>
                    </div>                        
                </div>
            </div>
        </div>
    </div>
</section>
<section id="final">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="join">
                    <div class="well base well-block">
                        <div class="title text-center">
                            <h2>ถ้า Mubaza คือคำตอบที่ใช่ของคุณ</h2>
                            <h4>ลงทะเบียนเพื่อร่วมงานกับเรา ตามแนวทางทึ่คุณถนัด เพื่อรับส่วนแบ่งที่น่าพอใจ ...</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{url('new-affiliate')}}" class="btn btn-lg btn-block btn-blue border">
                                    ลงทะเบียน Affiliate
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ url('new-artist') }}" class="btn btn-lg btn-block btn-blue border">
                                    ลงทะเบียนครีเอเตอร์
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                    
            </div>
        </div>
    </div>
</section>
-->




<!--
    <div class="box-create">
        <div class="box-header">
            <h1 class="box-title">เริ่มสร้างแคมเปญ</h1>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <table>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                    <p>บลา ๆ ๆ ๆ ...</p>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <a href="{{ url('manager/create') }}" class="btn btn-success btn-lg">
                        <i class="fa fa-thumbs-up"></i> เริ่มออกแบบ
                    </a> 
                    <a href="{{ url('new-artist') }}" class="btn btn-primary btn-lg">
                        <i class="fa fa-user-plus"></i> ลงทะเบียน
                    </a>
                </div>
            </div>
        </div>
    </div>
-->
@stop
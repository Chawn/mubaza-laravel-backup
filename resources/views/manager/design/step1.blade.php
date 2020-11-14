@extends('manager.layouts.master')
@section('script')
    <script src="{{ asset('js/hashids.min.js') }}"></script>
    <script>
    $(function(){
        $(".box-step").hide();

        $("#step1").show();

        $(".next").click(function(){
            var target = $(this).attr('data-target');
            $(".box-step").hide();
            $("#step"+target).show();
            $(".nav-step.active").addClass('disabled');
            $(".nav-step.active").toggleClass('active');
            $("#nav-"+target).addClass('active')
        });

        $( "#slider" ).slider({
          value:295,
          min: 249,
          max: 349,
          step: 1,
          slide: function( event, ui ) {
            $( "#price" ).val( "$" + ui.value );
        }
    });
        $( "#price" ).val( "$" + $( "#slider" ).slider( "value" ) );
    });
    </script>
@stop
@section('css')
    <style type="text/css" media="screen">

       .create-nav .navbar-nav li a{
           font-weight: 700;
       }
       .create-nav .navbar-nav li.active > a{
           font-weight: 800;
           background-color: #F0AD4E;
           color: #eee;
       }
       .breadcrumb-design{
        margin-top: -30px;
       }
    </style>
@stop
@section('content')
    <nav class="navbar navbar-design-step navbar-default navbar-static-top">
        <ul class="nav navbar-nav">
            <li id="nav-1" class="nav-step active">
                <a href="#">
                    <strong>1. อัพโหลดรูปลาย <i class="fa fa-chevron-right"></i></strong>
                </a>
            </li>
            <li id="nav-2" class="nav-step disabled">
                <a href="#">
                    <strong>2. อัพโหลดรูปเสื้อ <i class="fa fa-chevron-right"></i></strong>
                </a>
            </li>
            <li id="nav-3" class="nav-step disabled">
                <a href="#">
                    <strong>3. ใส่รายละเอียด <i class="fa fa-chevron-right"></i></strong>
                </a>
            </li>
            <li id="nav-4" class="nav-step disabled">
                <a href="#">
                    <strong>4. เสร็จ <i class="fa fa-chevron-right"></i></strong>
                </a>
            </li>
        </ul>
    </nav>
    <div id="step1" class="box-step box-create">
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="box-image">
                                <img src="{{ asset('images/upload-art.jpg') }}" alt="" class="thumbnail img-responsive">
                                <h4 class="text-center">ด้านหน้า</h4>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <p class="box-image ">
                                <img src="{{ asset('images/upload-art.jpg') }}" alt="" class="thumbnail img-responsive">
                                <h4 class="text-center">ด้านหลัง</h4>
                            </p>

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box-set">
                        <label class="title">เพื่อผลลัพธ์การพิมพ์เสื้อที่ดีที่สุด</label>
                        <ul class="list-group">
                            <li class="list-group-item"><strong class="text-info">ขนาดสูงสุด</strong>: 5MB</li>
                            <li class="list-group-item"><strong class="text-info">ประเภทไฟล์</strong>: .png<br></li>
                            <li class="list-group-item"><strong class="text-info">ความละเอียดต่ำสุด</strong>: <strong class="text-danger">กว้าง 2400px สูง 3200px</strong></li>
                            <li class="list-group-item">
                                <strong class="text-info">เครื่องมือออกแบบลาย</strong>:
                                &nbsp;
                                <a href="/SF-Art-Template.png" target="new" class="btn btn-default btn-sm">
                                    <i class="fa fa-download"></i> ดาวน์โหลดรูปเสื้อ
                                </a>
                                &nbsp;
                                <a href="{{ url('design') }}" target="new" class="btn btn-default btn-sm">
                                    <i class="glyphicon glyphicon-globe"></i> ออกแบบบนเว็บ
                                </a>
                            </li>
                        </ul>
                        <label class="title">อัพโหลดลาย</label>
                        <p class="">
                            <label for="front-art" class="btn btn-primary btn-lg">        อัพโหลดลายด้านหน้า
                            </label>
                            <input id="front-art" type="file" name="front-art" style="display:none;">
                            <label for="back-art" class="btn btn-primary btn-lg">        อัพโหลดลายด้านหลัง
                            </label>
                            <input id="back-art" type="file" name="back-art" style="display:none;">
                        </p>
                        <p>
                            <strong class="text-danger">หากมีลายทั้ง 2 ด้าน</strong> ราคาเริ่มต้นจะคิดค่าบริการเพิ่ม 50 บาท
                        </p>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-6">
                            <button data-target="2" class="next btn-control btn btn-success btn-lg btn-block">
                                ต่อไป <i class="fa fa-arrow-circle-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div id="step2" class="box-step box-create">
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="box-image">
                                <img src="{{ asset('images/blank-mockup-front.jpg') }}" alt="" class="thumbnail img-responsive">
                                <h4 class="text-center">ด้านหน้า</h4>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <p class="box-image ">
                                <img src="{{ asset('images/blank-mockup-back.jpg') }}" alt="" class="thumbnail img-responsive">
                                <h4 class="text-center">ด้านหลัง</h4>
                            </p>
                        </div>
                    </div>
                </div>
                 <div class="col-md-6">
                    <div class="box-set">
                        <label class="title">ทำรูปเสื้อ (Mockup)</label>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <p>
                                <strong class="text-primary">
                                1. ออกแบบ</strong><br>
                                <a class="btn btn-default btn-sm" href="/SF-Tee.zip">
                                    <i class="fa fa-download"></i> ดาวน์โหลดรูปเสื้อ และไฟล์ .psd
                                </a>
                            &nbsp;
                                <a href="{{ url('design') }}" target="new" class="btn btn-default btn-sm">
                                    <i class="glyphicon glyphicon-globe"></i> ออกแบบบนเว็บ
                                </a>
                                </p>
                                <p>
                                    <strong class="text-primary">2.วางลายให้ตรง</strong> บริเวณตำแหน่งสำหรับพิมพ์เสื้อ
                                </p>
                                <p>
                                <strong class="text-primary">3. บันทึก</strong> เป็นไฟล์ JPG
                                </p>
                            </li>
                        </ul>

                        <br>
                        <div class="form-group">
                            <label  class="title"for="">อัพโหลดรูปเสื้อ</label>
                            <br>
                            <p class="">
                                <label for="front-art" class="btn btn-primary btn-lg">        อัพโหลดรูปเสื้อด้านหน้า
                                </label>
                                <input id="front-art" type="file" name="front-art" style="display:none;">
                                <label for="back-art" class="btn btn-primary btn-lg">        อัพโหลดรูปเสื้อด้านหลัง
                                </label>
                                <input id="back-art" type="file" name="back-art" style="display:none;">
                            </p>
                            <p>
                                <strong class="text-danger">หากมีลายทั้ง 2 ด้าน</strong> ราคาเริ่มต้นจะคิดค่าบริการเพิ่ม 50 บาท
                            </p>
                            <br>

                            <label class="title"for="ProductName">เลือกเสื้อที่ต้องการขาย</label>
                            <select id="ProductName" name="ProductName" class="form-control">
                                <option value="Original">Original T-Shirt</option>
                                <option value="Premium">Premium  T-Shirt</option>
                                <option value="Hybrid">Hybrid  T-Shirt</option>
                            </select>
                            <br>
                            <label class="title" for="ProductColor">เลือกสีเสื้อ</label>
                            <select id="ProductColor" name="ProductColor" class="form-control">
                                <option value="">เลือกสี</option>

                                <option value="White">ขาว</option>

                                <option value="SportsGrey">เทาท็อปดราย</option>

                                <option value="Black">ดำ</option>

                            </select>
                            <br>
                            <p>
                              <label class="title" for="price">ราคา:</label>
                              <input type="text" id="price" readonly style="border:solid 1px #ddd;border-radius:4px;padding:5px;">
                            </p>
                            <div class="row">
                                <div class="col-sm-6">
                                    <strong class="text-warning" style="color:#f6931f;">
                                        ฿249
                                    </strong>
                                </div>
                                <div class="col-sm-6">
                                    <strong class="text-warning pull-right" style="color:#f6931f;">
                                        ฿349
                                    </strong>
                                </div>
                            </div>
                            <div id="slider"></div>
                            <br>

                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-6">
                            <button data-target="1" class="next btn btn-default-shadow btn-lg btn-block">
                                <i class="fa fa-arrow-circle-left"></i> ย้อนกลับ
                            </button>
                        </div>
                        <div class="col-sm-6">
                            <button data-target="3" class="next btn btn-success btn-lg btn-block">
                                ต่อไป <i class="fa fa-arrow-circle-right"></i>
                            </button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <div id="step3" class="box-step box-create">
        <div class="box-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="box-image">
                        <img src="{{ asset('images/exam-mockup.png') }}" alt="" class="thumbnail img-responsive">
                        <h4 class="text-center">ด้านหน้า</h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <p class="box-image ">
                        <img src="{{ asset('images/exam-mockup-back.png') }}" alt="" class="thumbnail img-responsive">
                        <h4 class="text-center">ด้านหลัง</h4>
                    </p>
                </div>
                <div class="col-md-6">
                    <div class="box-set">
                        <label class="title" for="title">หัวข้อ</label>
                        <input id="title" name="title" class="form-control" required>
                        <p><small>สรุปหัวข้อของคุณใน 40 ตัวอักษรหรือน้อยกว่า</small></p>

                        <br>
                        <label class="title" for="category">หมวดหมู่</label>
                        <select id="category" name="category" class="form-control" required>
                            <option value="0">เลือกหมวดหมู่สินค้า</option>

                            <option value="52">Automotive</option> <option value="51">Camping</option> <option value="78">Drinking</option> <option value="26">Faith</option> <option value="50">Fishing</option> <option value="61">Fitness</option> <option value="19">Funny</option> <option value="24">Geek-Tech</option> <option value="35">Holidays</option> <option value="30">Hunting</option> <option value="43">LifeStyle</option> <option value="12">Movies</option> <option value="71">Music</option> <option value="62">Pets</option> <option value="17">Political</option> <option value="27">Sports</option> <option value="34">TV Shows</option> <option value="13">Video Games</option> <option value="11">Zombies</option>

                        </select>
                        <br>
                        <label class="title" for="description">รายละเอียด</label><br>
                        <textarea name="description" id="description" class="form-control description" rows="3" required></textarea>
                        <p><small>บอกเรื่องราว ที่มา หรือความหมาย เพื่อเพิ่มความน่าสนใจให้กับสินค้า</small></p>
                        <script>
                            CKEDITOR.replace('description');
                        </script>
                        <br>
                        <label class="title" for="tags">แท็ก</label>
                        <input type="text" class="form-control" id="tags" name="tags" required>
                        <p><small>สามารถใส่ได้สูงสุด 5 แท็ก ขั้นแต่ละคำด้วย "," (คอมม่า) เช่น แมว, แมวสีขาว, Cat, White Cat
                            <br><strong class="">ใช้คำที่เกี่ยวข้องกับลาย</strong> จะช่วยให้ลูกค้าค้นหาเจอได้ง่ายขึ้นบนเว็บของเรา และจากเว็บค้นหาอื่นๆ </small></p>
                        <hr>


                    </div>
                    <br>
                    <label class="title">ตัวเลือก</label>
                        <div class="panel panel-default" style="min-height:240px;">
                            <div class="panel-heading">
                                <h4 class="panel-title">กำหนดวันสิ้นสุด</h4>
                            </div>
                            <div class="panel-body">
                                <div class="checkbox">
                                    <p>
                                    <label>
                                         <input type="radio" name="LimitTime" value="1" checked> ปิดการใช้งาน
                                    </label>
                                    </p>
                                    <p>
                                    <label>
                                         <input type="radio" name="LimitTime" value="1"> เปิดใช้งานวันสิ้นสุด <span class="text-danger">*</span>
                                    </label>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <label>เลือกวันสิ้นสุด</label>
                                    <input class="form-control" id="endDate" type="text" name="endDate" value="">
                                </div>

                                <small><strong class="text-danger">* การกำหนดวันสิ้นสุด</strong> หมายถึง สินค้าของคุณจะเปิดขายเพียงช่วงระยะเวลาหนึ่ง เมื่อถึงระยะเวลาสิ้นสุดที่คุณกำหนด การขายจะถูกปิดลงโดยอัตโนมัติ</small>
                            </div>
                        </div>

                    <p>
                            <label class="title">
                                <input  type="checkbox" id="agree-tos" required>
                                &nbsp;ฉันได้อ่านและยอมรับ<a href="{{ url('help/terms') }}">ข้อตกลงการใช้งาน</a>
                            </label>
                        </p>
                    <div class="row">
                        <div class="col-sm-6">
                            <button data-target="2" class="next btn btn-default-shadow btn-lg btn-block">
                                <i class="fa fa-arrow-circle-left"></i> ย้อนกลับ
                            </button>
                        </div>
                        <div class="col-sm-6">
                            <button data-target="4" class="next btn btn-success btn-lg btn-block">
                                ต่อไป <i class="fa fa-arrow-circle-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div id="step4" class="box-step box-create">
        <div class="box-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="box-image">
                        <img src="{{ asset('images/exam-mockup.png') }}" alt="" class="thumbnail img-responsive">
                        <h4 class="text-center">ด้านหน้า</h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <p class="box-image ">
                        <img src="{{ asset('images/exam-mockup-back.png') }}" alt="" class="thumbnail img-responsive">
                        <h4 class="text-center">ด้านหลัง</h4>
                    </p>
                </div>
                <div class="col-md-6">
                    <a href="" class="btn btn-success btn-block btn-lg">
                        หน้าแสดงสินค้า <i class="fa fa-arrow-circle-right"></i>
                    </a>
                    <br>
                    <a href="" class="btn btn-warning btn-block btn-lg">
                        <i class="fa fa-pencil-square-o"></i> แก้ไขเพิ่มเติม
                    </a>
                    <br>

                    <br>
                </div>
            </div>
            
        </div>
    </div>
@stop
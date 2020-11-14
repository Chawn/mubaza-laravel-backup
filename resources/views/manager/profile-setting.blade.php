
@extends('manager.layouts.master')
@section('script')
    <script src="{{ asset('js/hashids.min.js') }}"></script>
    <script>
    </script>
@stop
@section('css')
    <style type="text/css" media="screen">
       .product-img img{
        max-width: 100px;
       }
       .tab-content{
        padding:25px;
       }
       .nav-tabs > li > a{
        border-radius: 0;
       }
       .navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > .active > a:focus{
        color: #555;
  background-color: #E7E7E7;
       }
       
    </style>
@stop
@section('content')
<div class="box-blank">
    <div class="box-body">
        <div class="row">
            <div class="col-md-6 col-sm-10 col-xs-12">                
                <form>
                    <div class="form-group">
                        <label for="full_name">ชื่อและนามสกุล</label>
                        <input type="text" class="form-control" id="full_name" placeholder="Name Lastname" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">นามปากกา (ใช้แสดงผล)</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Display Name" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">เบอร์โทรศัพท์</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Phone" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">อีเมล</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" required>
                    </div>
                    <hr>
                    <p class="text-center">
                        <a type="submit" href="#" class="btn btn-success btn-lg btn-block">บันทึก</a>
                    </p>
                </form>

            </div>
            <div class="col-md-6 col-sm-10 col-xs-12">
                <img src="{{asset('images/associate/OpenDoor.jpg')}}" alt="">
            </div>
        </div>
    
    </div>
</div>
@stop


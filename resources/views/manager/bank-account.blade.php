
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
                @if(\Session::has('message'))
                    <div class="alert alert-success"><i class="fa fa-check-circle"></i>&nbsp;{{ \Session::get('message') }}</div>
                @endif
                <form method="post" action="{{ action('AssociateController@postSaveBankAccount') }}">
                    {{ csrf_field() }}
                    <b>คำอธิบาย</b>
                    <ul>
                        <li>บริษัทจะดำเนินการโอนเงินไปยังบัญชีธนาคารนี้เท่านั้น</li>
                        <li>หากข้อมูลบัญชีธนาคารไม่ถูกต้อง บริษัทจะไม่สามารถโอนเงินให้คุณได้</li>
                    </ul>
                    <hr>
                    <div class="form-group">
                        <label for="name">ชื่อบัญชีธนาคาร</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="ชื่อบัญชีธนาคาร" value="{{ $user->bank_account == null ? '' : $user->bank_account->name }}"required>
                    </div>
                    <div class="form-group">
                        <label for="no">เลขบัญชีธนาคาร</label>
                        <input type="text" class="form-control" id="no" name="no" placeholder="xxx-x-xxxxx-x" value="{{ $user->bank_account == null ? '' : $user->bank_account->no }}"required>
                    </div>
                    <div class="form-group">
                        <label for="bank_name">ชื่อธนาคาร</label>
                        <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="ธนาคาร.." value="{{ $user->bank_account == null ? '' : $user->bank_account->bank_name }}"required>
                    </div>
                    <div class="form-group">
                        <label for="branch">ชื่อสาขาธนาคาร</label>
                        <input type="text" class="form-control" id="branch" name="branch" placeholder="ชื่อสาขาธนาคาร" value="{{ $user->bank_account == null ? '' : $user->bank_account->branch }}"required>
                    </div>
                    <hr>
                    <p class="text-center">
                        <button type="submit" href="#" class="btn btn-success btn-lg btn-block">บันทึก</button>
                    </p>
                </form>

            </div>
        </div>
    
    </div>
</div>
@stop


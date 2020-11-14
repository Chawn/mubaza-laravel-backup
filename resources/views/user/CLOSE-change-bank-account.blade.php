@extends('user.layouts.master')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/user-account.css') }}">
<style>
.form-control{
    max-width: 350px;
    margin-bottom: 15px;
}
.btn-submit{
    min-width: 100px;
}
.control-label{
    text-align: right;
}
#user-header{
    display: none;
}
#user-sub-account-menu-mobile {
    display: none;
}
@media (max-width: 480px){
    #user-sub-account-menu{
        display: none;
    }
    #user-sub-account-menu-mobile {
        display: block;
    }
}

select {
	border: 1px solid transparent;
	}
</style>

<script>
$(document).ready(function(){
    
    
		$("#profit-collapse").hide();
        $("#a-profit").click(function () {
			$("#profit-collapse").show("slow");
			$("#profit-click-hide").hide();
        });
		$("#a-profit-collapse").click(function () {
			$("#profit-collapse").hide();
			$("#profit-click-hide").show("slow");
        });
		$("#a-profit-collapse2").click(function () {
			$("#profit-collapse").hide();
			$("#profit-click-hide").show("slow");
        });
    
	
	
      $('[data-toggle="tooltip"]').tooltip();
   
        /* For zebra striping */
        $("table tr:nth-child(odd)").addClass("odd-row");

});

</script>

@stop
@section('content')
<div class="user-account">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-nonpadding">
            @include('user_dashboard.profile-menu')
        </div>
        @if(\Auth::user()->check())
            <input name="_token" type="hidden" id="token" value="{{ csrf_token() }}"/>
            <input name="user_id" type="hidden" id="user-id" value="{{ \Auth::user()->user()->id }}"/>
        @endif
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="box">
                @if($user->is_social && is_null($user->password))
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="alert alert-warning text-center ">
                                <h4><i class="fa fa-exclamation-circle"></i>&nbsp;คุณยังไม่ได้กำหนดรหัสผ่านเพื่อความปลอดภัย&nbsp;<a
                                            href="{{ action('UserController@getSecure', $user->getID()) }}">คลิ๊กที่นี่</a>&nbsp;เพื่อกำหนดรหัสผ่าน</h4>
                            </div>
                        </div>
                    </div>
                    
                @else

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        @if(is_null($bank_account))
                            <h4>เพิ่มบัญชีธนาคาร</h4>
                        @else
                            <div id="bank-detail">
                                <h4>บัญชีธนาคารปัจจุบันของคุณคือ</h4>
                                <div class="text-indent well">
                                    <p>ชื่อบัญชี <strong>{{ $bank_account->name }}</strong></p>
                                    <p>ธนาคาร <strong>{{ $bank_account->bank_name }}</strong></p>
                                    <p>สาขา <strong>{{ $bank_account->branch }}</strong></p>
                                    <p>เลขที่บัญชี <strong>{{ $bank_account->no }}</strong></p>
                                </div>
                            </div>
                            <h4>เปลี่ยนแปลงบัญชีธนาคาร</h4>
                        @endif

                        <div id="bank-detail">
                            {!! Form::model($bank_account, ['action' => ['UserController@postSaveBankAccount', $user->getID()], 'method' => 'POST' ]) !!}
                            <form class="form-horizontal">
                                <div class="form-group">
                                    <label for="name" class="col-sm-3 control-label">ชื่อบัญชี</label>
                                    <div class="col-sm-9">
                                        {!! Form::input('text', 'name', null, ['class' => 'form-control', 'placeholder' => 'ชื่อเจ้าของบัญชี', 'required' => 'required']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bankname" class="col-sm-3 control-label">ชื่อธนาคาร</label>
                                    <div class="col-sm-9">
                                         {!! Form::input('text', 'bank_name', null, ['class' => 'form-control', 'placeholder' => 'เช่น กรุงไทย กสิกรไทย ไทยพาณิชย์', 'required' => 'required']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="branch" class="col-sm-3 control-label">สาขา</label>
                                    <div class="col-sm-9">
                                         {!! Form::input('text', 'branch', null, ['class' => 'form-control', 'placeholder' => 'สาขาของธนาคาร', 'required' => 'required']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="no" class="col-sm-3 control-label">เลขที่บัญชี</label>
                                    <div class="col-sm-9">
                                         {!! Form::input('text', 'no', null, ['class' => 'form-control', 'placeholder' => 'เลขที่บัญชีธนาคาร', 'required' => 'required']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="col-sm-3 control-label">รหัสผ่าน</label>
                                    <div class="col-sm-9">
                                        <input type="password" name="password" class="form-control" required
                                            placeholder="โปรดใส่รหัสผ่านบัญชีผู้ใช้เพื่อยืนยันการเปลี่ยนแปลง">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-9 col-sm-offset-3">
                                        <button type="submit" class="btn-submit btn btn-primary">บันทึก</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <h4>ทำไมต้องมีบัญชีธนาคาร ?</h4>
                        <ol>
                            <li>เพื่อรับเงินคืน ในกรณีที่แคมเปญที่คุณสั่งซื้อไม่ได้รับการผลิต</li>
                            <li>เพื่อรับรายได้จากการขาย เมื่อแคมเปญของคุณมียอดขายมากพอและได้รับการผลิต คุณจะได้รับรายได้ของคุณผ่านทางบัญชีธนาคารนี้</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>                
    </div>           
</div>
@stop
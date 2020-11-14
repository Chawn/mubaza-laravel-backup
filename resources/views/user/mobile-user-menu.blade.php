@extends('user.layouts.master')
@section('css')
<style>
	#user-header,
	#user-mobile-menu {
		display: none;
	}
</style>
@stop
@section('content')
<div id="mobile-user-menu">
	@if(\Auth::user()->check())
    	@if(\Auth::user()->user()->isOwner($user->id))
		<div class="col-xs-4 col-mobile-menu">
			<div class="mobile-sub-menu" 
				onclick="location.href='{{ action('UserController@getOrderHistory', $user->getID()) }}';">
				<img src="{{asset('images/submenu/shopcart.png')}}">
	            <p>ประวัติการซื้อ</p>
			</div>
		</div>
		<div class="col-xs-4 col-mobile-menu">
			<div class="mobile-sub-menu" 
				onclick="location.href='{{ action('UserController@getCampaign', $user->getID()) }}';">
				<img src="{{asset('images/submenu/tshirt.png')}}">
	            <p>แคมเปญ</p>
			</div>
		</div>
		<div class="col-xs-4 col-mobile-menu">
			<div class="mobile-sub-menu" 
				onclick="location.href='{{ action('UserController@getFinance', $user->getID()) }}';">
				<img src="{{asset('images/submenu/bank.png')}}">
	            <p>ประวัติด้านการเงิน</p>
			</div>
		</div>
		<div class="col-xs-4 col-mobile-menu">
			<div class="mobile-sub-menu" 
				onclick="location.href='{{ action('UserController@getBankAccount', $user->getID()) }}';">
				<img src="{{asset('images/submenu/file.png')}}">
	            <p>บัญชีธนาคาร</p>
			</div>
		</div>
		<div class="col-xs-4 col-mobile-menu">
			<div class="mobile-sub-menu" 
				onclick="location.href='{{ action('UserController@getFollower', $user->getID()) }}';">
				<img src="{{asset('images/submenu/star.png')}}">
	            <p>การติดตาม</p>
			</div>
		</div>
		<div class="col-xs-4 col-mobile-menu">
			<div class="mobile-sub-menu" 
				onclick="location.href='{{ action('UserController@getFavorite', $user->getID()) }}';">
				<img src="{{asset('images/submenu/heart.png')}}">
	            <p>รายการที่ชอบ</p>
			</div>
		</div>
		<div class="col-xs-4 col-mobile-menu">
			<div class="mobile-sub-menu" 
				onclick="location.href='{{ action('UserController@getProfile', $user->getID()) }}';">
				<img src="{{asset('images/submenu/setting.png')}}">
	            <p>การตั้งค่าบัญชี</p>
			</div>
		</div>
		@else
    	<div class="col-xs-4 col-mobile-menu">
    		<div class="mobile-sub-menu" 
				onclick="location.href='{{ action('UserController@getListCampaign', $user->getID()) }}';">
				<img src="{{asset('images/submenu/tshirt.png')}}">
	            <p>แคมเปญ</p>
			</div>
		</div>
		<div class="col-xs-4 col-mobile-menu">
			<div class="mobile-sub-menu" 
				onclick="location.href='{{ action('UserController@getProfile', $user->getID()) }}';">
				<img src="{{asset('images/submenu/user.png')}}">
	            <p>เกี่ยวกับผู้ใช้</p>
			</div>
		</div>
		<div class="col-xs-4 col-mobile-menu">
			<div class="mobile-sub-menu" 
				onclick="location.href='{{ action('UserController@getFollower', $user->getID()) }}';">
				<img src="{{asset('images/submenu/star.png')}}">
	            <p>ผู้ติดตาม</p>
			</div>
		</div>
		<div class="col-xs-4 col-mobile-menu">
			<div class="mobile-sub-menu" 
				onclick="location.href='{{ action('UserController@getFavorite', $user->getID()) }}';">
				<img src="{{asset('images/submenu/heart.png')}}">
	            <p>รายการที่ชอบ</p>
			</div>
    	</div>
		@endif
    @else
    	<div class="col-xs-4 col-mobile-menu">
    		<div class="mobile-sub-menu" 
				onclick="location.href='{{ action('UserController@getListCampaign', $user->getID()) }}';">
				<img src="{{asset('images/submenu/tshirt.png')}}">
	            <p>แคมเปญ</p>
			</div>
		</div>
		<div class="col-xs-4 col-mobile-menu">
			<div class="mobile-sub-menu" 
				onclick="location.href='{{ action('UserController@getProfile', $user->getID()) }}';">
				<img src="{{asset('images/submenu/user.png')}}">
	            <p>เกี่ยวกับผู้ใช้</p>
			</div>
		</div>
		<div class="col-xs-4 col-mobile-menu">
			<div class="mobile-sub-menu" 
				onclick="location.href='{{ action('UserController@getFollower', $user->getID()) }}';">
				<img src="{{asset('images/submenu/star.png')}}">
	            <p>ผู้ติดตาม</p>
			</div>
		</div>
		<div class="col-xs-4 col-mobile-menu">
			<div class="mobile-sub-menu" 
				onclick="location.href='{{ action('UserController@getFavorite', $user->getID()) }}';">
				<img src="{{asset('images/submenu/heart.png')}}">
	            <p>รายการที่ชอบ</p>
			</div>
    	</div>
    @endif
</div>
@stop
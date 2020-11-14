@extends('layouts.help')
@section('css')
<style>
	
</style>
@stop
@section('script')
	
@stop
@section('content')

<div class="row">	
	<div class="col-md-3 col-sm-3 col-xs-6">
		<a class="thumbnail" href="{{ action('HelpController@getHowtopay') }}">
			<i class="text-blue fa fa-money fa-3x "></i>
			<div class="caption">
				<p>{{ \Lang::get("messages.howtopay") }}</p>
			</div>
		</a>
	</div>
	<div class="col-md-3 col-sm-3 col-xs-6">
		<a class="thumbnail" href="{{ action('HelpController@getShipping') }}">
			<i class="text-blue fa fa-truck fa-3x"></i>
			<div class="caption">
				<p>{{ \Lang::get("messages.shipping") }}</p>
			</div>
		</a>
	</div>
	<div class="col-md-3 col-sm-3 col-xs-6">
		<a class="thumbnail" href="{{ action('HelpController@getWarranty') }}">
			<i class="text-blue fa fa-thumbs-o-up fa-3x"></i>
			<div class="caption">
				<p>{{ \Lang::get("messages.warranty") }}</p>
			</div>
		</a>
	</div>
	<div class="col-md-3 col-sm-3 col-xs-6">
		<a class="thumbnail" href="{{ action('HelpController@getSizing') }}">
			<i class="text-blue fa fa-table fa-3x"></i>
			<div class="caption">
				<p>ตารางขนาดเสื้อ</p>
			</div>
		</a>
	</div>
	<div class="col-md-3 col-sm-3 col-xs-6">
		<a class="thumbnail" href="{{ action('HelpController@getValue') }}">
			<i class="text-blue fa fa-cart-plus fa-3x"></i>
			<div class="caption">
				<p>สั่งซื้อจำนวนมาก</p>
			</div>
		</a>
	</div> 
	<div class="col-md-3 col-sm-3 col-xs-6">
		<a class="thumbnail" href="{{ action('HelpController@getContact') }}">
			<i class="text-blue fa fa-comment fa-3x"></i>
			<div class="caption">
				<p>ติดต่อเรา</p>
			</div>
		</a>
	</div>
	
</div>
<!-- end PAGE -->
@stop


@extends('manager.layouts.master')
@section('content')

<div class="row">
	<div class="col-xs-12 text-right">
		<a href="{{ url('store-create') }}" class="btn btn-primary">  
			<i class="fa fa-plus-circle"></i> สร้างใหม่
		</a>
	</div>
</div>

<div class="row">
	@for($i=1;$i<=25;$i++)
	<div class="col-sm-6 col-xs-12">
		<a class="product-box" href="{{ url('store') }}">
			<div class="product-img">
				<img src="{{ asset('images/hero-hoodie.jpg') }}" alt="">
			</div>
			<div class="product-detail">
	            <div class="product-name text-center">
	                Store Name
	            </div>
	            <div class="product-description ">
	                <span>
	                    จำนวนสินค้า : 25 ชิ้น
	                </span>
	                <span class="pull-right">
	                	<a class="btn btn-xs btn-default" href="{{ url('store-create') }}">
	                		<i class="fa fa-pencil"></i> แก้ไข
	                	</a>
	                </span>	                                                    
	            </div>
	        </div>
		</a>
	</div>
	@endfor
</div>
@stop
@extends('layouts.campaign')
@section('script')
<script>
	$("#surprise-btn").click(function() {
		$.ajax({
			type: "POST",
			url: "/campaign/surprise",
			data: {
				category_id: $("#category").val(),
				product_id: $("#product").val(),
				color: $("#color").val()
			},
			dataType: "json",
			success: function (data) {
				if (data.success) {
					console.log(data);
					showSurprise(data);
				}
			},
			failure: function (errMsg) {
				alert(errMsg);
			}
		});
	});

	function showSurprise(data) {
		var element = $(".surprise-result");
		element.find(".price").html(data.product.price)
	}
</script>
@stop
@section('content')
	<section id="surprise">
		<div class="container">
			<h3><strong>{{ $title }}</strong></h3>
			<hr>
				
			<div class="row">
				<div class="col-md-3 sol-sm-6 col-md-offset-2">
					<div class="product-box">
						<a href="">
							<div class="product-img">
								<img src="{{ asset('images/mockup/sample-tee.png') }}">
							</div>
						</a>
						<div class="product-detail">
							<div class="product-name text-center">
								<small>Campaign Name</small>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-sm-6 col-md-offset-1">
					<label for="">เลือกหมวดหมู่ที่คุณสนใจ</label>
					<select name="category" id="category" class="form-control">
						<option value="">ทั้งหมด</option>
						@foreach(\App\CampaignCategory::all() as $category)
							<option value="{{ $category->id }}">{{ $category->detail }}</option>
						@endforeach
					</select>
					<br>
					<label for="">สินค้า</label>
					<select name="product" id="product" class="form-control">
						<option value="">ทุกแบบ</option>
						@foreach(\App\Product::all() as $product)
							<option value="{{ $product->id }}">{{ $product->name }}</option>
						@endforeach
					</select>
					<br>
					<label for="">สีเสื้อ</label>
					<select name="color" id="color" class="form-control">
						<option value="">ทุกสี</option>
						@foreach(\App\ProductColor::allColor()->get() as $color)
							<option value="{{ $color->color_name }}">{{ $color->color_name }}</option>
						@endforeach
					</select>
					<br>
					<button class="btn btn-success btn-block btn-xl" id="surprise-btn">
						<i class="fa fa-refresh"></i> ดูผลลัพธ์ 
					</button>
					<br>
				</div>
			</div>
		</div>
	</section>
@stop
@extends('manager.layouts.master')
@section('script')
<script>
	function copyToClipboard(element) {
		var $temp = $("<input>");
		$("body").append($temp);
		$temp.val($(element).text()).select();
		document.execCommand("copy");
		$temp.remove();
	}
	$(document).ready(function() {
		$(function () {
		  $('[data-toggle="tooltip"]').tooltip()
		});
		$('.btn-copy').click(function() {
			$(this).text('copies!!!');
			setTimeout(function() {
				$('.btn-copy').text('copy');
			},1000);
		});

		$('.a-collapse').click(function(){
		    $(this).text(function(i,old){
		        return old=='ย่อการดูเพิ่มเติม' ?  'ดูเพิ่มเติม' : 'ย่อการดูเพิ่มเติม';
		    });
		});
		
	});
</script>
@stop
@section('css')
<style>
	.main{
		padding-top: 0px;
        margin-top:0px;
	}
	.box{
		margin-bottom: 0px !important;
	}
	#generator{
		border-bottom: 1px solid #ddd;
	}

	.description{
		padding: 20px 0;
		margin-bottom: 25px;
	}
	#generated{
		background: #fff;
	}
	.btn-copy{
		position: relative;
		top: 0px;
		right: 0px;
	}
	.well.base.border{
		border:2px solid;
	}
	.box-link .head{
		margin-bottom: 30px;
	}
	.box-link .head span{
		color:#163b69;
	}
	.well .col-md-6:first-child {
		border-right: 2px solid;
	}
	@media(max-width: 767px){
		.well .col-md-6:first-child {
			border-right: none;
		}
		#generator h2{
			font-size: 32px;
		}
	}
</style>
@stop
@section('content')
<section id="generator">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<form class="form-inline form-search">
					<h2 class="text-center title thin">สร้างลิ้งค์สินค้าของคุณ</h2>
					<div class="form-group">
						<div class="input-group col-sm-8 col-xs-12">
							<input type="text" class="form-control input-xl" id="URL" placeholder="Paste Link to Create Product">
						</div>
						<button id="btn-gen" class="btn btn-blue btn-xl">Create</button>
					</div>					
				</form>
			</div>	
		</div>
	</div>
</section>
<section id="generate">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-link">
					<div class="box-header">
						<h4 class="text-center mid-line head"><span>สำเร็จ!! นี่คือลิงค์สินค้าของคุณ</span></h4>
					</div>
					<div class="box-detail">
						<button class="btn btn-base border btn-copy pull-right" onclick="copyToClipboard('#affiliate-url')">
							copy
						</button>
						<div class="well base border square">							
							<div class="detail">
								<p id="affiliate-url">http://localhost/mubaza-laravel/public/affiliate-createurl</p>
							</div>
						</div>
					</div>
				</div>
				<div class="box box-link">
					<div class="box-header">
						<h4 class="text-center head"><span>iframe</span></h4>
					</div>
					<div class="box-detail">
						<button class="btn btn-base border btn-copy pull-right" onclick="copyToClipboard('#affiliate-iframe')">
							copy
						</button>						
						<div class="well base border square">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="product-box">
								<a href="">
									<div class="product-img">
										<img src="{{ asset('images/mockup/img3.jpg') }}">
									</div>
								</a>
								<div class="product-detail">
									<div class="product-name text-center">
										Campaign Name
									</div>
								</div>
							</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">															
									<div class="detail">
										<p id="affiliate-iframe">iframe affiliate-createurl</p>
									</div>					
								</div>
							</div>												
						</div>								
					</div>
				</div>
			</div>
		</div>
	</div>	
</section>
@stop
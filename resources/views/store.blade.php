@extends('layouts.store_full_width')
@section('css')
<style>
	.main{
		margin-top: 0px;
	}
	#cover,#cover-change{
	    height: 450px;
	    width: 100%;
	    background-size: cover;
	    background-position: center center;
	}
	#group-input-cover{
		overflow: hidden;
    	position: relative;
	}
	#cover-btn{
		display: none;
	}
	#group-input-cover,#cover-btn{
		margin-top: 5px;
	}
	#group-input-cover [type=file]{
		cursor: inherit;
	    display: block;
	    font-size: 999px;
	    filter: alpha(opacity=0);
	    min-height: 100%;
	    min-width: 100%;
	    opacity: 0;
	    position: absolute;
	    right: 0;
	    text-align: right;
	    top: 0;
	}

	.product-box .border-checked{
		border:4px solid transparent;
	}
	.product-box.checked .border-checked{
		border:4px solid #0bacff;
	}
	.product-box.checked:hover .product-img img{
		transform: scale(1,1);

	}
	.check-group{
		position: absolute;
		top: 4px;
		left: 19px;
		z-index: 2;
	}
	.check-group input[type="checkbox"],.check-group label {
	    display:none;
	}

	.check-group input[type="checkbox"]:checked + label {
	    display: inline-block;
	    font-size: 28px;
	    color: #fff;
	    background: #0bacff;
	    width: 35px;
	    height: 35px;
	    text-align: center;
	    padding-top: 2px;    
	}
	#store-detail{
		position: absolute;
		top: 0px;
		margin-top: 50px;
		text-shadow: 0 0 3px rgba(0,0,0,0.8);
		color: #fff;
	}
</style>
@stop
@section('script')
<script>
	$(document).ready(function() {
		$('#cover-change').css('background-image','none');
		function readURL(input) {
	        if (input.files && input.files[0]) {
	            var reader = new FileReader();
	            
	            reader.onload = function (e) {
	                $('#cover-change').css({
	                	'background-image' : 'url('+e.target.result+')',
	                	'background-color' : '#fff'
	                });
	            }
	            
	            reader.readAsDataURL(input.files[0]);
	        };
	        
	    }
	    
	    $('#cover-btn').hide();
	    $("#cover-input").change(function(){
	        readURL(this);
	        var CoverInput = $('#cover-input').val();
	        console.log(CoverInput);

	        if (CoverInput != 'none'){
	        	$('#group-input-cover').hide();
	        	$('#cover-btn').show();
	        }else{
	        	$('#group-input-cover').show();
	        	$('#cover-btn').hide();
	        }
	    });
	    $('#image-preview-clear').click(function() {
		    	$('#cover-change').css({
		    		'background-image' : 'none',
		    		'background-color' : 'transparent'
		    	});
		    	$('#cover-input').val("");
		    	$('#group-input-cover').show();
	        	$('#cover-btn').hide();
		});
		var windowWidth = $(window).width();
	    $('#store-detail').width(windowWidth);
	   
        var headerHeight = $('#main-nav-wrapper').height();
	    var footerHeight = $('#footer-main').height();
	    var contentHeight = $(window).height() - (headerHeight + footerHeight + 50);

	    $('#main-container').css({
	    	'min-height' : contentHeight,
	    });

	    $('.product-box').click(function () {
	    	if ($(this).find('input:checkbox[name=productCheckbox]').is(":checked")) {
	    		$(this).find('input:checkbox[name=productCheckbox]').attr("checked", false);
	    		$(this).removeClass('checked');
	    	}
	    	else {
	    		$(this).find('input:checkbox[name=productCheckbox]').prop("checked", true);
	    		$(this).addClass('checked');
	    	}

	    });
	    $('input[type=checkbox]').click(function (e) {
	    	e.stopPropagation();
	    });
	});
</script>
@stop
@section('content')
<div class="container-fulid">
	<div class="row">
		<div class="col-md-12">
			<div id="cover" style="background-image:url({{ asset('images/org3.jpg') }})">
				<form id="cover-change">
					<div class="container">
						<div id="group-input-cover" class="btn btn-default">
							<span><i class="fa fa-camera"></i> อัพเดทภาพหน้าปก</span>
							<input type="file" id="cover-input">
						</div>
						<div id="cover-btn">
							<button id="image-preview-clear" class="btn btn-default">ยกเลิก</button>
							<button class="btn btn-info">
								บันทึกภาพหน้าปก
							</button>
						</div>
						<button class="btn btn-border btn-danger" data-toggle="modal" data-target="#modal-addproduct">อัพเดทสินค้า</button>
					</div>
				</form>
				<div id="store-detail">
					<div class="container">
						<h2>เอ้เพลินเพลินคอลเ็กชั่นหน้าร้อน</h2>
						<h4>sfasdfasdfsadfsfdsadfasdfsdfsfdsdfasfdsadfsfdsfd</h4>	
						<button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-detail">
							แก้ไขรายละเอียด
						</button>	
					</div>						
				</div>
			</div>					
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="wrapper">
					@for($i=1;$i<=8;$i++)
	                    <div class="col-sm-3">
	                        <div class="product-box">	                        	
	                            <span>
	                                <div class="product-img" style="height: 200px;">
	                                    <img src="http://localhost/mubaza-laravel/public/images/mockup/img2.jpg">
	                                </div>
	                            </span>
	                            <div class="product-detail">
	                                <div class="product-name text-center">
	                                    Campaign Name
	                                </div>
	                                <div class="product-description ">
	                                    <span class="price">
	                                        ฿399
	                                    </span>
	                                    <span class="wish pull-right">
	                                        
	                                        <a class="btn-add-cart" data-toggle="modal" href="#modal-cart">
	                                            <i class="fa fa-close"></i>&nbsp;
	                                        </a>
	                                    </span>                    
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                @endfor
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-addproduct" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="modal-addproductLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modal-addproductLabel">เพิ่มสินค้าเข้าสโตร์</h4>
			</div>
			<div class="modal-body">
				<div class="row tab-content">
					<ul class="nav nav-tabs nav-justified" role="tablist">
						<li role="presentation" class="active">
							<a href="#own" aria-controls="own" role="tab" data-toggle="tab">สินค้าของคุณ</a>
						</li>
	    				<li role="presentation">
	    					<a href="#product-url" aria-controls="product-url" role="tab" data-toggle="tab">ค้นหาด้วย URL</a>
	    				</li>
					</ul>
					<div role="tabpanel" class="tab-pane wrapper active" id="own">
						@for($i=1;$i<=8;$i++)
		                    <div class="col-sm-3 col-xs-6">
		                        <div class="product-box">
		                        	<div class="border-checked">
			                        	<div class="check-group">
			                        		<input type="checkbox" class="product-checkbox" name="productCheckbox">
			                        		<label for="product-checkbox">
			                        			<i class="fa fa-check"></i>
			                        		</label>
			                        	</div>	                        	
			                            <span>
			                                <div class="product-img" style="height: 200px;">
			                                    <img src="http://localhost/mubaza-laravel/public/images/mockup/img1.jpg">
			                                </div>
			                            </span>
			                            <div class="product-detail">
			                                <div class="product-name text-center">
			                                    Campaign Name
			                                </div>
			                                <div class="product-description ">
			                                    <span class="price">
			                                        ฿399
			                                    </span>
			                                    <span class="wish pull-right">
			                                        
			                                        <a class="btn-add-cart" data-toggle="modal" href="#modal-cart">
			                                            <i class="fa fa-close"></i>&nbsp;
			                                        </a>
			                                    </span>                    
			                                </div>
			                            </div>
			                        </div>
		                        </div>
		                    </div>
		                @endfor
					</div>
					<div role="tabpanel" class="tab-pane wrapper" id="product-url">
						
					</div>
				</div>
					
			</div>
			<div class="modal-footer text-center">
				<nav>
					<ul class="pagination">
						<li>
							<a href="#" aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
							</a>
						</li>
						<li><a href="#">1</a></li>
						<li><a href="#">2</a></li>
						<li><a href="#">3</a></li>
						<li><a href="#">4</a></li>
						<li><a href="#">5</a></li>
						<li>
							<a href="#" aria-label="Next">
								<span aria-hidden="true">&raquo;</span>
							</a>
						</li>
					</ul>
				</nav>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
				<button type="button" class="btn btn-success">บันทึก</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="modal-detailtLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modal-addproductLabel">แก้ไขรายละเอียดสโตร์</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" action="">
					<div class="form-group">
					<label for="store-name" class="col-sm-2 control-label">ชื่อสโตร์</label>
						<div class="col-sm-8">
						<input type="text" class="form-control" id="store-name" placeholder="ชื่อสโตร์">
						</div>
					</div>				
					<div class="form-group">
					<label for="store-detail" class="col-sm-2 control-label">รายละเอียดสโตร์</label>
						<div class="col-sm-8">
							<textarea class="form-control" rows="5"></textarea>
							
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
				<button type="button" class="btn btn-info">บันทึก</button>
			</div>
		</div>
	</div>
</div>
@stop
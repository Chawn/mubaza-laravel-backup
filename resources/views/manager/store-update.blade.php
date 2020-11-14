@extends('manager.layouts.master')
@section('css')
<style>
	.btn-file {
	  	width: 100%;
	    height: 80px;
	    line-height: 66px;
	    position: relative;
	    overflow: hidden;
	    padding-bottom: 8px;
	    display: block;
	    background: #fefefe;
	    color: #989898;
	    border: 2px dashed #ddd;
	    margin-bottom: 15px;
	}
	.btn-file:hover{
		background-color: #fdfdfd;
	}
	.btn-file input[type=file] {
	  position: absolute;
	  top: 0;
	  right: 0;
	  min-width: 70%;
	  min-height: 70%;
	  font-size: 70px;
	  text-align: right;
	  filter: alpha(opacity=0);
	  opacity: 0;
	  background: red;
	  cursor: inherit;
	  display: block;
	}
	input[readonly] {
	  background-color: transparent !important;
	  cursor: text !important;
	  height: 36px;
	  border:none;
	  box-shadow: none;
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
		top: 0px;
		left: 19px;
		z-index: 2;
	}
	.check-group input[type="checkbox"],.check-group label {
	    display:none;
	}

	.check-group input[type="checkbox"]:checked + label {
	    display: inline-block;
	    font-size: 40px;
	    color: #0bacff;
	    width: 35px;
	    height: 35px;
	    text-align: center;
	    padding-top: 2px;	    
	}
	.form-horizontal{
		margin-top: 25px;
	}
	#modal-addproduct .modal-body{
		padding:0px;
	}
	#modal-addproduct .tab-pane{
		
	}
	.nav-tabs{
		background-color: #f5f5f5;
		color: #444;
		margin-top: -1px;
	}
	.nav-tabs > li > a{
		color: #444;
		border-radius: 0 2px 0 0;
		border-top: 1px solid #ddd;
		background-color: #f5f5f5;
	}
	.nav-tabs > li > a:hover{
		background-color: #fafafa;
		border-top: 1px solid #ddd;
	}
	.nav-tabs > li a:first-child{
		border-radius: 2px 0 2px 0;
	}
	.nav-tabs > li.active > a,
	.nav-tabs > li.active > a:hover,
	.nav-tabs > li.active > a:focus{
		background-color: #fff;
		border-bottom :1px solid;
		border-bottom-color:transparent !important;
	}
	.tab-pane{
		overflow-y: scroll;
	}
	.modal-body{
		overflow-x:hidden;
	}
	.icon{
		width: 15px;

	}
	#find-product .media-left{
		width: 20%		
	}
	#find-product .media-left img{
		width: 100%		
	}
	.btn-remove{
		position: absolute;
		top: -10px;
		right: 5px;
		z-index: 1;
		width: 26px;
		height: 26px;
		font-size: 16px;
		border-radius: 50%;
		background-color: rgba(0,0,0,0.7);
		color: #fff;
		text-align: center;
		padding:4px 0;
	}
	.panel-heading h4{
		margin-top: 5px;
	}
</style>
@stop
@section('script')
<script>
	$(document).on('change', '.btn-file :file', function() {
  		var input = $(this),
      	numFiles = input.get(0).files ? input.get(0).files.length : 1,
      	label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
  		input.trigger('fileselect', [numFiles, label]);
	});

	$(document).ready( function() {
		// input file
	    $('.btn-file :file').on('fileselect', function(event, numFiles, label) {	        
	        var input = $('#store-cover'),
	            log = numFiles > 1 ? numFiles + ' files selected' : label;	        
	        if( input.length ) {
	            input.val(log);
	        } else {
	            if( log ) alert(log);
	        }	        
	    });

	    var selectHeight = $('.product-choose .product-box').height();

	    $('.choose-box').css({
	    	'height' : selectHeight,
	    });
	    /*
	    $('.product-choose').on( "mouseenter", function() {
	    	$(this).children('.choose-box').slideDown();
	    	})
	    	.on( "mouseleave", function(){
	    		$(this).children('.choose-box').slideUp();
	    });
	    */
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
	    var windowHeight = $(window).height();
	    var modalHeader = $('.modal-header').height();
	    var tapHeader = $('.nav.nav-tabs').height();
	    var modalFooter = $('.modal-footer').height();

	    $('.tab-pane').height( windowHeight - ( modalHeader + tapHeader + modalFooter + 60 + 44 + 245) )
	});
</script>
@stop
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-sm-9">
						<h4>รายละเอียดสโตร์</h4>
					</div>
					<div class="col-sm-3">
						<button class="btn btn-default btn-half">
								ยกเลิก
						</button>
						<button class="btn btn-info btn-half">
							บันทึก
						</button>
					</div>
				</div>	
			</div>
			<div class="panel-body">
				<form action="" class="form-horizontal">
					<div class="form-group">
						<label for="store-name" class="col-sm-2 control-label">ชื่อสโตร์</label>
						<div class="col-sm-7">
							<input type="text" class="form-control" id="store-name" placeholder="ชื่อสโตร์">
						</div>
					</div>
					<div class="form-group">
						<label for="store-detai" class="col-sm-2 control-label">รายละเอียด</label>
						<div class="col-sm-7">
							<textarea name="store-detai" id="store-detai" class="form-control" rows="5">
								
							</textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="store-url" class="col-sm-2 control-label">URL สโตร์</label>
						<div class="col-sm-7">
							<input type="text" class="form-control" id="store-url" placeholder="URL สโตร์">
							<p class="help-block">*ใช้ได้เฉพาะภาษาอังกฤษ เท่านั้น</p>
						</div>
					</div>
					<div class="form-group">
						<label for="store-cover" class="col-sm-2 control-label">หน้าปก</label>
						<div class="col-sm-7">
							<span class="btn btn-file">
								เลือกไฟล์
								<input type="file" id="input-file">
							</span>
							<input id="store-cover" type="text" class="form-control" readonly>
						</div>
					</div>
				</form>
			</div>				
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-sm-9">
						<h4>สินค้าในสโตร์ (25 ชิ้น)</h4>
					</div>
					<div class="col-sm-3 text-right">
						<button class="btn btn-default btn-half" data-toggle="modal" data-target="#modal-addproduct">
						เพิ่มสินค้า</button>
					</div>
				</div>	
			</div>
			<div class="panel-body">
					@for($i=1;$i<=25;$i++)
	                    <div class="col-sm-3">
	                        <div class="product-box">
	                        	<span class="btn-remove">	                                        
                                    <i class="fa fa-times"></i>
                                </span>	                        	
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
				<div class="tab-content">
					<ul class="nav nav-tabs nav-justified" role="tablist">
						<li role="presentation" class="active">
							<a href="#own" aria-controls="own" role="tab" data-toggle="tab">สินค้าของคุณ</a>
						</li>
	    				<li role="presentation">
	    					<a href="#product-url" aria-controls="product-url" role="tab" data-toggle="tab">ค้นหาด้วย URL</a>
	    				</li>
					</ul>
					<div role="tabpanel" class="tab-pane row wrapper active" id="own">
						@for($i=1;$i<=24;$i++)
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
			                                </div>
			                            </div>
			                        </div>
		                        </div>
		                    </div>
		                @endfor
					</div>
					<div role="tabpanel" class="tab-pane row wrapper" id="product-url">
						<div class="col-md-12">
							<div class="input-group">
								<input type="text" class="form-control" placeholder="วาง URL สินค้าที่คุณต้องการค้นหา">
								<span class="input-group-btn">
									<button class="btn btn-default" type="button">ค้นหา</button>
								</span>
							</div>
							<hr>
							<div id="find-product" class="media">
								<div class="media-left">
									<img src="{{ asset('images/mockup/img1.jpg') }}" alt="">
								</div>
								<div class="media-body">
									<h4>UNLOCK</h4>
									<p>รหัสสินค้า : 00225</p>
									<p>ราคา 320 บาท</p>
									<button class="btn btn-success" data-dismiss="modal">เพิ่มเข้าสโตร์</button>
								</div>
							</div>
						</div>
					</div>
				</div>
					
			</div>
			<!--
			<div class="modal-footer text-center">
				<div class="col-md-12">
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
				
			</div>-->
			<div class="modal-footer">
				<div class="row">
					<div class="col-sm-4 col-sm-offset-8 text-right">
						<button class="btn btn-info btn-half" data-dismiss="modal">
							เสร็จ
						</button>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>
<!--
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<ul class="nav nav-tabs nav-justified" role="tablist">
					<li role="presentation" class="active">
						<a href="#own" aria-controls="own" role="tab" data-toggle="tab">สินค้าของคุณ</a>
					</li>
    				<li role="presentation">
    					<a href="#product-url" aria-controls="product-url" role="tab" data-toggle="tab">ค้นหาด้วย URL</a>
    				</li>
				</ul>
			</div>				
			<div class="panel-body tab-content">
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
					@for($i=1;$i<=8;$i++)
	                    <div class="col-sm-3">
	                        <div class="product-box">
	                        	<div class="check-group">
	                        		<input type="checkbox" class="product-checkbox" name="productCheckbox">
	                        		<label for="product-checkbox">
	                        			<i class="fa fa-check"></i>
	                        		</label>
	                        	</div>	                        	
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
			<div class="panel-footer">
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
		</div>
	</div>
</div>
<!--
<div class="row">
	<div class="col-md-4 col-sm-4 col-xs-12 pull-right">
		<div class="panel panel-primary">
			<div class="panel-heading">เมนู</div>
			<div class="panel-body bg-default">
				<ul class="list-group list-group-menu list-group-default">
					<li class="list-group-title">
						<button class="btn btn-half btn-default">
							ยกเลิก
						</button>
						<button class="btn btn-half btn-success">
							บันทึก
						</button>
					</li>
					<li class="list-group-item">
						<a id="btn-store-detail" href="#">รายละเอียดสโตร์</a>
					</li>
					<li class="list-group-item">
						<a id="btn-store-product" class="active" href="#">สินค้า</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="col-md-8 col-sm-8 col-xs-12">
		<div id="store-detail" class="panel panel-default">
			<div class="panel-heading">รายละเอียดสโตร์</div>
			<div class="panel-body">
				<form action="" class="form-horizontal">
					<div class="form-group">
						<label for="store-name" class="col-sm-2 control-label">ชื่อสโตร์</label>
						<div class="col-sm-7">
							<input type="email" class="form-control" id="store-name" placeholder="ชื่อสโตร์">
						</div>
					</div>
					<div class="form-group">
						<label for="store-detail" class="col-sm-2 control-label">รายละเอียด</label>
						<div class="col-sm-7">
							<input type="email" class="form-control" id="store-detail" placeholder="รายละเอียด">
						</div>
					</div>
					<div class="form-group">
						<label for="store-cover" class="col-sm-2 control-label">หน้าปก</label>
						<div class="col-sm-7">
							<div class="input-group">
								<input id="store-cover" type="text" class="form-control" readonly>
								<span class="input-group-btn">
									<span class="btn btn-primary btn-file">
										เลือกไฟล์
										<input type="file" id="input-file">
									</span>
								</span>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div id="store-product" class="panel panel-default">
			<div class="panel-heading">เลือกสินค้า</div>
			<div class="panel-body">
				<ul class="nav navbar-nav navbar-default">
					<li class="dropdown">						
						<select name="category" id="category" class="form-control">
                            <option value="">ทั้งหมด</option>
                            @foreach(\App\CampaignCategory::active()->get() as $category)
                                <option value="{{ $category->id }}" {{ isset($selected_category) && $selected_category->id == $category->id ? 'selected' : '' }}>{{ $category->detail }}</option>
                            @endforeach
                        </select>
					</li>
					<li>
						<select name="sort" id="sort" class="form-control">
                            <option value="">มาใหม่</option>
                            <option value="">ยอดนิยม</option>
                            <option value="">ขายดี</option>
                        </select>
					</li>
					<li>
						<a href="#">ใหม่ล่าสุด</a>
					</li>
				</ul>
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Search for...">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button">Go!</button>
					</span>
				</div>
			</div>
			<div class="panel-body">
				@for($i=1;$i<=12;$i++)
                    <div class="col-sm-4">
                        <div class="surprise-result product-box">
                            <a href="">
                                <div class="product-img" style="height: 200px;">
                                    <img src="http://localhost/mubaza-laravel/public/images/mockup/img1.jpg">
                                </div>
                            </a>
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
			<div class="panel-body">
				<table>
					<thead>
						<tr>
							<th>
								<select name="category" id="category" class="form-control">
		                            <option value="">ทั้งหมด</option>
		                            @foreach(\App\CampaignCategory::active()->get() as $category)
		                                <option value="{{ $category->id }}" {{ isset($selected_category) && $selected_category->id == $category->id ? 'selected' : '' }}>{{ $category->detail }}</option>
		                            @endforeach
		                        </select>
							</th>
							<th>
								<select name="sort" id="sort" class="form-control">
		                            <option value="">มาใหม่</option>
		                            <option value="">ยอดนิยม</option>
		                            <option value="">ขายดี</option>
		                        </select>
							</th>
							<th>
								<a href="#">ใหม่ล่าสุด</a>
							</th>
							<th>
								<div class="input-group">
									<input type="text" class="form-control" placeholder="Search for...">
									<span class="input-group-btn">
										<button class="btn btn-default" type="button">Go!</button>
									</span>
								</div>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="4">
								@for($i=1;$i<=24;$i++)
				                    <div class="col-sm-4">
				                        <div class="surprise-result product-box">
				                            <a href="">
				                                <div class="product-img" style="height: 200px;">
				                                    <img src="http://localhost/mubaza-laravel/public/images/mockup/img1.jpg">
				                                </div>
				                            </a>
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
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
-->
@stop
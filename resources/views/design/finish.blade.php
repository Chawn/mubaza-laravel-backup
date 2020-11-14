@extends('layouts.full_width')

@section('script')
	<script src="{{ asset('js/jquery.flip.js') }}"></script>
    <script src="{{ asset('js/countdown/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('js/jquery.uploadPreview.js') }}"></script>
	<script>
	$(document).ready(function() {
		$('.flipper').flip({
                trigger: 'manual'
            });
            $('#flip .front').hide();
            $('#flip').click(function () {
                $('.flipper').flip('toggle');
                $('#flip .back').toggle();
                $('#flip .front').toggle();
            });

            $('#btn-zoomin').click(function () {
                $('.zoomTarget').addClass('dragzoom');
                $('.zoomTarget').draggable({
                    disabled: false
                });
            });
            $('#btn-zoomout').click(function () {
                 $('.zoomTarget').removeClass('dragzoom');
                $('.zoomTarget').css({
                    'width': '75'+'%',
                    'position': 'absolute',
                    'left' : '0',
                    'right' : '0',
                    'top' : '0'
                });
                $('.zoomTarget').draggable({
                    disabled: true
                });
            }); 
            $('.zoomTarget').load(function() {
                var campaignShow = $('#campaign-select-show .zoomTarget').height();
                var imgCarousel = $('#carousel-campaign-related .product-img img').height();
                if ($(window).width() > 992) {
                    $('#campaign-select-show').css({
                        'height': campaignShow+30 + 'px'
                    });
                    $('#carousel-campaign-related .product-img').css({
                        'height': imgCarousel * 70 / 100 + 'px'
                    });
                } else {
                    $('#campaign-select-show').css({
                        'height': campaignShow+30 + 'px'
                    });
                    $('#carousel-campaign-related .product-img').css({
                        'height': imgCarousel * 70 / 100 + 'px'
                    });
                }
            });

        });    
	</script>
	

@stop
@section('css')
	<link rel="stylesheet" href="{{ asset('css/campaign-show.css') }}">

    <link rel="stylesheet" href="{{ asset('css/color.css') }}">
    <link rel="stylesheet" href="{{ asset('css/btn-social.css') }}">

    <style>
		section{
			padding-top: 0px;
		}

		.input-size input{
			height: 40px;
		}
		.input-size button{
			height: 40px;
		}
		label h4{
			margin:0px;
		}
		.dragzoom{
            width: auto !important;
            cursor: move;
        }
        .control-label h2{
        	margin: 0px;
        }
        .btn-buy{
        	width: 210px;
        }
        .pricetag{
        	width: 260px;
		    height: 50px;
		    text-align: center;
		    font-size: 30px;
		    vertical-align: middle;
		    line-height: 50px;
		    margin-bottom: 10px;
        }
        .pricetag span{
        	padding: 0 15px;
        }
        .btn-block{
        	margin-bottom: 10px;
        	width: 260px;
        	font-size: 18px;
        	height: 50px;
        	line-height: 36px;
        }
    </style>
@stop
@section('content')
<section id="campaign-select" class="section">
    <div class="container container-mobile">
        <div id="title-group" class="col-md-12 col-sm-12 col-xs-12">
            <h1 class="campaign-title">เสื้อยืด คอกลม มาตรฐาน สีดำ</h1>
        </div>
        <div class="col-md-7 col-sm-6 col-xs-12">
            <div id="campaign-select-show">
                <div class="flip-container">
                    <div class="flipper">
                        <div class="front select-img ">
                            <img class="zoomTarget tshirt" id="image-front"
                                 src="{{ asset('images/mockup/img5.jpg') }}">
                        </div>
                        <div class="back select-img">
                            <img class="zoomTarget" id="image-back"
                                 src="{{ asset('images/mockup/img4.jpg') }}">
                        </div>
                    </div>
                </div>
                <div id="box-tool" class="select-box">
                    <a id="btn-zoomin" class="tools zoom-in">
                        <i class="fa fa-plus"></i>
                    </a>
                    <a id="btn-zoomout" class="tools zoom-out">
                        <i class="fa fa-minus"></i>
                    </a>
                </div>
                <div id="flip-tool" class="img-box">
                    <a id="flip" class="tools">
                        <span>
                            <img class="back" src="{{ asset('images/mockup/img4.jpg') }}">
                            <img class="front" src="{{ asset('images/mockup/img5.jpg') }}">
                            <p class="back">ด้านหลัง</p>
                            <p class="front">ด้านหน้า</p>
                        </span>                            
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-5 col-sm-6 col-xs-12">
            <div id="campaign-select-option">
                <div id="box-select" class="campaign-select-group">
                    <h4 class="campaign-sub-title">เลือกขนาดและจำนวนที่ต้องการ</h4>
					<form class="form-horizontal">
						<div class="form-group">
							<label for="s" class="col-sm-2 control-label">
								<h4>S</h4>
							</label>
							<div class="col-sm-4">
                        		<div class="input-group spinner-none input-size">
                        			<span class="input-group-btn">
                        				<button class="btn btn-default btn-number" type="button" data-type="minus" data-field="quant[1]"><i class="fa fa-minus"></i></button>
                        			</span>
                        			<input name="quant[1]" type="text" class="form-control input-number" value="0" min="0" max="999">
                        			<span class="input-group-btn">
							        	<button class="btn btn-default btn-plus" type="button" data-type="plus" data-field="quant[1]"><i class="fa fa-plus"></i></button>
							      	</span>
                        		</div>
                        	</div>
						</div>
						<div class="form-group">
							<label for="s" class="col-sm-2 control-label">
								<h4>M</h4>
							</label>
							<div class="col-sm-4">
                        		<div class="input-group spinner-none input-size">
                        			<span class="input-group-btn">
                        				<button class="btn btn-default btn-number" type="button" data-type="minus" data-field="quant[1]"><i class="fa fa-minus"></i></button>
                        			</span>
                        			<input name="quant[1]" type="text" class="form-control input-number" value="0" min="0" max="999">
                        			<span class="input-group-btn">
							        	<button class="btn btn-default btn-plus" type="button" data-type="plus" data-field="quant[1]"><i class="fa fa-plus"></i></button>
							      	</span>
                        		</div>
                        	</div>
						</div>
						<div class="form-group">
							<label for="s" class="col-sm-2 control-label">
								<h4>L</h4>
							</label>
							<div class="col-sm-4">
                        		<div class="input-group spinner-none input-size">
                        			<span class="input-group-btn">
                        				<button class="btn btn-default btn-number" type="button" data-type="minus" data-field="quant[1]"><i class="fa fa-minus"></i></button>
                        			</span>
                        			<input name="quant[1]" type="text" class="form-control input-number" value="0" min="0" max="999">
                        			<span class="input-group-btn">
							        	<button class="btn btn-default btn-plus" type="button" data-type="plus" data-field="quant[1]"><i class="fa fa-plus"></i></button>
							      	</span>
                        		</div>
                        	</div>
						</div>
						<div class="form-group">
							<label for="s" class="col-sm-2 control-label">
								<h4>XL</h4>
							</label>
							<div class="col-sm-4">
                        		<div class="input-group spinner-none input-size">
                        			<span class="input-group-btn">
                        				<button class="btn btn-default btn-number" type="button" data-type="minus" data-field="quant[1]"><i class="fa fa-minus"></i></button>
                        			</span>
                        			<input name="quant[1]" type="text" class="form-control input-number" value="0" min="0" max="999">
                        			<span class="input-group-btn">
							        	<button class="btn btn-default btn-plus" type="button" data-type="plus" data-field="quant[1]"><i class="fa fa-plus"></i></button>
							      	</span>
                        		</div>
                        	</div>
						</div>
						<div class="form-group">
							<label for="s" class="col-sm-2 control-label">
								<h4>XXL</h4>
							</label>
							<div class="col-sm-4">
                        		<div class="input-group spinner-none input-size">
                        			<span class="input-group-btn">
                        				<button class="btn btn-default btn-number" type="button" data-type="minus" data-field="quant[1]"><i class="fa fa-minus"></i></button>
                        			</span>
                        			<input name="quant[1]" type="text" class="form-control input-number" value="0" min="0" max="999">
                        			<span class="input-group-btn">
							        	<button class="btn btn-default btn-plus" type="button" data-type="plus" data-field="quant[1]"><i class="fa fa-plus"></i></button>
							      	</span>
                        		</div>
                        	</div>
						</div>
						<div class="form-group">
							<label for="s" class="col-sm-2 control-label">
								<h4>XXXL</h4>
							</label>
							<div class="col-sm-4">
                        		<div class="input-group spinner-none input-size">
                        			<span class="input-group-btn">
                        				<button class="btn btn-default btn-number" type="button" data-type="minus" data-field="quant[1]"><i class="fa fa-minus"></i></button>
                        			</span>
                        			<input name="quant[1]" type="text" class="form-control input-number" value="0" min="0" max="999">
                        			<span class="input-group-btn">
							        	<button class="btn btn-default btn-plus" type="button" data-type="plus" data-field="quant[1]"><i class="fa fa-plus"></i></button>
							      	</span>
                        		</div>
                        	</div>
						</div>
					</form>		                        
                </div>
                <div id="box-help" class="campaign-select-group">
                    <p>
                        <a data-toggle="modal" href="#modal-tshirt-size">ตารางเปรียบเทียบขนาดเสื้อ</a>
                    </p>
                </div>
                <div class="buy">
                	<div class="pricetag">
                		0<span>฿</span>
                	</div>
                	<a href="#" class="btn btn-block btn-success">หยิบลงตะกร้า</a>
                	<a href="#" class="btn btn-block btn-default">กลับไปหน้าออกแบบ</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!--
<section id="buy" class="">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div id="list-text">
                    <a class="btn btn-lg btn-default"><i class="fa fa-angle-double-left"></i>&nbsp;กลับไปหน้าออกแบบ</a>

                    
                </div>
            </div>
            <div class="col-md-6">
            	<div class="form-horizontal">
            		<div class="form-group">
            			<label class="col-sm-3 control-label">
            				<h2 class="total">฿<span id="price">128900</span></h2>
            			</label>
            			<div class="col-sm-9">
            				<button class="btn btn-lg btn-success btn-buy" id="add-to-cart" data-campaign-id="">หยิบลงตะกร้า
			                </button>
            			</div>
            		</div>
            	</div>			                
            </div>
        </div>
    </div>
</section>
-->
<div id="modal-tshirt-size" class="modal fade modal-fullscreen" tabindex="-1" role="dialog"
         aria-labelledby="qrcodeline" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: 1px	solid #ddd;">
                    <h4 class="modal-title">ตารางเปรียบเทียบขนาดเสื้อ</h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-4 col-sm-4 mobile-hidden">
                        <img width="100%" src="{{asset('images/default/t-size.png')}}">
                    </div>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <table class="table-form">
                            <thead>
                            <tr>
                                <th>ขนาด</th>
                                <th>รอบอก(นิ้ว)</th>
                                <th>ความยาว(นิ้ว)</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>S</td>
                                <td>32</td>
                                <td>32</td>
                            </tr>
                            <tr>
                                <td>M</td>
                                <td>32</td>
                                <td>32</td>
                            </tr>
                            <tr>
                                <td>L</td>
                                <td>32</td>
                                <td>32</td>
                            </tr>
                            <tr>
                                <td>XL</td>
                                <td>32</td>
                                <td>32</td>
                            </tr>
                            <tr>
                                <td>XXL</td>
                                <td>32</td>
                                <td>32</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer" style="background: #fff;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>
@stop
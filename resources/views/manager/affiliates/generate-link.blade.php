@extends('manager.layouts.master')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
			var iframeHeight = $('.detail .left').height();

			$(function () {
				$('[data-toggle="tooltip"]').tooltip()
			});
			$('.btn-copy').click(function() {
				$(this).text('copies!!!');
				setTimeout(function() {
					$('.btn-copy').text('copy');
				},1000);
			});

			$('.detail .right').height(iframeHeight);

			$('.a-collapse').click(function(){
				$(this).text(function(i,old){
					return old=='ย่อการดูเพิ่มเติม' ?  'ดูเพิ่มเติม' : 'ย่อการดูเพิ่มเติม';
				});
			});

            $("#generate-btn").click(function() {
                var product_url = $("#product-url");
                if(product_url.val() != "") {
                    generate_link(product_url.val());
                }
            });

            function generate_link(url) {
                $.ajax({
                    type: "POST",
                    url: "/associate/generate-link",
                    data: {
                        url: url
                    },
                    dataType: "json",
                    success: function (data) {
                        if(data.success) {
                            $("#affiliate-url").text(data.affiliate_link);
                            $("#affiliate-iframe").text(data.affiliate_iframe_code);
                            $("#preview-iframe").attr("src", data.affiliate_iframe_url);
                            $("#generate").css({"visibility":"visible"});
                        } else {
                            alert(data.message);
                        }
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            }

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
        #generate {
            visibility: hidden;
        }
        #generate-btn{
        	width: 150px;
        }
		.btn-copy{
			position: relative;
			top: 0px;
			right: 0px;
			border: 2px solid #3D464D;
		}
		.well.base.border{
			border:2px solid;
		}
		.box-link .head{
			margin-bottom: 30px;
		}
		.iframe-wrapper{
			border-right: 2px solid;
		}
        .box-link .head span{
            color:#163b69;
        }
        iframe{
        	margin:auto;
        	display: block;
        }
        @media(max-width: 767px){
        	.iframe-wrapper{
				border-right: none;
			}
        }
	</style>
@stop
@section('content')
	<section id="generator">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="form-search">
						<h2 class="text-center title thin">สร้างลิ้งค์สินค้าของคุณ</h2>
						<div class="form-group">
							<div class="col-sm-8 col-sm-offset-1 col-xs-12">
								<input type="url" class="form-control input-lg" id="product-url" placeholder="Paste Link to Create Product">
							</div>
							<button id="generate-btn" class="btn btn-primary btn-lg">สร้าง</button>
						</div>
					</div>
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
							<button class="btn btn-info border btn-copy pull-right" onclick="copyToClipboard('#affiliate-url')">
								copy
							</button>
							<div class="well base border square">
								<div class="detail">
									<p id="affiliate-url" style="word-break:break-all;"></p>
								</div>
							</div>
						</div>
					</div>
					<div class="box box-link">
						<div class="box-header">
							<h4 class="text-center head"><span>iframe</span></h4>
						</div>
						<div class="box-detail">
							<button class="btn btn-info border btn-copy pull-right" onclick="copyToClipboard('#affiliate-iframe')">
								copy
							</button>
							<div class="well base border square">
								<div class="row">
									<div class="col-md-6 col-sm-6 col-xs-12 iframe-wrapper">
                                            <iframe src="" id="preview-iframe"
                                                    frameborder="0" width="300", height="426"></iframe>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<div class="detail">
											<p id="affiliate-iframe" style="word-break:break-all;"></p>
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
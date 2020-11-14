@extends('layouts.index_full_width')
@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@stop
@section('script')
	<script type="text/javascript">
		$(document).ready(function () {

			$('.product-thmb').hover(function () {
				if($(this).find('img').attr('data-default') == 'front')
				{
					$(this).find('img').attr('src', $(this).find('img').attr('data-back'));
				}
				else
				{
					$(this).find('img').attr('src', $(this).find('img').attr('data-front'));
				}
			}, function () {
				if($(this).find('img').attr('data-default') == 'front')
				{
					$(this).find('img').attr('src', $(this).find('img').attr('data-front'));
				}
				else
				{
					$(this).find('img').attr('src', $(this).find('img').attr('data-back'));
				}
			});
			
			$('#guide-group-tap').click(function() {
				$('#guide-group-tap').toggleClass('active');
				$('.guide-box.active').not(this).removeClass('active');
				$('#guide-group').toggleClass('show');
				$('#guide-campaign').removeClass('show');
			});
			$('#guide-campaign-tap').click(function() {
				$('#guide-campaign-tap').toggleClass('active');
				$('.guide-box.active').not(this).removeClass('active');
				$('#guide-campaign').toggleClass('show');
				$('#guide-group').removeClass('show');
			});
			$('#btn-design-buy').hide('500');
			$('#btn-create-campaign').hide('500');
			$('#guide-group-mobile').click(function(){
				$('.box-group-mobile').toggleClass('highlight');
				$(this).children('.guide-detail').slideToggle('500');
				$('#btn-design-buy').slideToggle('500');				
				$(this).children('.span-chevron').toggleClass('rotate');
				
			});
			$('#guide-campaign-mobile').click(function(){
				$('.box-campaign-mobile').toggleClass('highlight');
				$(this).children('.guide-detail').slideToggle('500');
				$('#btn-create-campaign').slideToggle('500');
				$(this).children('.span-chevron').toggleClass('rotate');
			});
		});
	</script>
@stop
@section('content')
<div class="modal fade" id="video-modal" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="myModalLabel" >
	<div class="modal-dialog" >
		<iframe id="video" width="900" height="540" data-dismiss="modal" src="{{ config('constant.youtube_campaign_embed') }}?rel=0&amp;enablejsapi=1&amp;vq=hd720&amp;start=0" frameborder="0" allowfullscreen></iframe>
		<div class="row modal-button-wrapper">
			<br>
			<a class="btn btn-success btn-lg" href="{{ action('SellController@getIndex') }}" title="{{ Lang::get('messages.create_campaign') }}">
				{{ Lang::get('messages.create_campaign') }} 
			</a>
			<button aria-hidden="true" id="close-video" class="btn btn-inverse btn-lg"  data-dismiss="modal">
				ปิดหน้าต่างนี้
			</button>
		</div>
	</div>
</div>

<section id="guide">
	<div class="container">	
		<div class="row">
			<div class="col-md-10">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">มาใหม่ยอดนิยม</h3>
					</div>
					<div class="box-body">
						<div class="row">
				<div class="product-row">
					@foreach($hot_campaigns as $campaign)
		            	<div class="col-md-4 col-sm-6 col-xs-6 col-mobile">
							<a class="product-box {{ $campaign->design->block_front_count > 0 && $campaign->design->block_back_count > 0 ? 'product-thmb' : '' }}" href="{{ action('SellController@showCampaign', $campaign->url) }}">
								<div class="product-img">
									<img src="{{ $campaign->back_cover ? $campaign->design->image_back_preview : $campaign->design->image_front_preview }}"
										 data-default="{{ $campaign->back_cover ? 'back' : 'front' }}"
										 data-front="{{ $campaign->design->image_front_preview }}"
										 data-back="{{ $campaign->design->image_back_preview }}">
								</div>
								<div class="product-detail">
									<div class="product-name text-left">
										{{ $campaign->title}}
									</div>
									<div class="product-description">
										<div class="goal">
											<div class="progress">
												<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:{{ ($campaign->getSoldNumber()*100)/$campaign->goal }}%;">
													<span class="sr-only">{{ $campaign->getSold() }}</span>
												</div>
											</div>
											<div class="row">
											
												<div class="col-md-6 col-xs-12 pull-right">
													<div class="sold text-center">
														ขายแล้ว {{ $campaign->getSoldNumber() }}/{{ $campaign->goal }}
													</div>
												</div>
												<div class="col-md-6 col-xs-12">
													<div class="timeout">เหลือ {{ $campaign->getShortRemainTime() }}</div>
													
												</div>
											</div>
										</div>
									</div>
								</div>
							</a>
						</div>
		            @endforeach
				</div>
			</div>
					</div>
				</div>
			</div>
			<div class="col-md-2">
				<h4>หมวดหมู่ทั้งหมด</h4>
				<ul class="">
                    <li><a href="https://www.sunfrog.com/Best-Sellers/">Best Sellers</a></li>

                    <li><a href="https://www.sunfrog.com/Automotive/">Automotive</a></li>

                    <li><a href="https://www.sunfrog.com/Camping/">Camping</a></li>

                    <li><a href="https://www.sunfrog.com/Drinking/">Drinking</a></li>

                    <li><a href="https://www.sunfrog.com/Faith/">Faith</a></li>

                    <li><a href="https://www.sunfrog.com/Fishing/">Fishing</a></li>

                    <li><a href="https://www.sunfrog.com/Fitness/">Fitness</a></li>

                    <li><a href="https://www.sunfrog.com/Funny/">Funny</a></li>

                    <li><a href="https://www.sunfrog.com/Geek-Tech/">Geek-Tech</a></li>

                    <li><a href="https://www.sunfrog.com/Holidays/">Holidays</a></li>

                    <li><a href="https://www.sunfrog.com/Hunting/">Hunting</a></li>

                    <li><a href="https://www.sunfrog.com/LifeStyle/">LifeStyle</a></li>

                    <li><a href="https://www.sunfrog.com/Movies/">Movies</a></li>

                    <li><a href="https://www.sunfrog.com/Music/">Music</a></li>

                    <li><a href="https://www.sunfrog.com/Pets/">Pets</a></li>

                    <li><a href="https://www.sunfrog.com/Political/">Political</a></li>

                    <li><a href="https://www.sunfrog.com/Sports/">Sports</a></li>

                    <li><a href="https://www.sunfrog.com/TV Shows/">TV Shows</a></li>

                    <li><a href="https://www.sunfrog.com/Video Games/">Video Games</a></li>

                    <li><a href="https://www.sunfrog.com/Zombies/">Zombies</a></li>
                                
                        
				</ul>
				
			</div>
		</div>
	</div>
</section>
<section id="guide">
	<div class="container">		
		<div class="wrapper guide-wrapper">	
			<p class="topic-title font-title">
				ง่าย สะดวก ไม่มีความเสี่ยงใดๆ ทั้งสิ้น
			</p>
		</div>
		<div id="guide-campaign" class="bg-grey box-border  collapse-guide mobile-hidden">
			<div class="row">
				<div class="col-md-4 col-sm-4 col-xs-4 text-center">
					<img src="{{asset('images/guide/campaign/HowToCampaign01.png')}}">
					<p class="sub-title">
						<b>สร้างแคมเปญ</b>
					</p>
					<p>ออกแบบลายเสื้อ ตั้งเป้าการขาย ราคาสินค้า ระยะเวลา และใส่รายละเอียดแคมเปญ</p>
				</div>
				<div class="col-md-4 col-sm-4 col-xs-4 text-center">
					<img src="{{asset('images/guide/campaign/HowToCampaign02.png')}}">
					<p class="sub-title">
						<b>โปรโมท</b>
					</p>
					<p>ประชาสัมพันธ์ไปยังกลุ่มลูกค้า เช่น กลุ่ม ชมรม เพื่อน แฟนคลับของคุณ</p>
				</div>
				<div class="col-md-4 col-sm-4 col-xs-4 text-center">
					<img src="{{asset('images/guide/campaign/HowToCampaign03.png')}}">
					<p class="sub-title">
						<b>สำเร็จ!</b>
					</p>
					<p>เมื่อแคมเปญได้รับการผลิต คุณจะได้รับรายได้จากการขายทันที ไม่มีเงื่อนไขใดๆ ทั้งสิ้น!</p>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-6">
					<a href="{{ url('help/create') }}">ดูขั้นตอนอย่างละเอียด</a>
				</div>
				<div class="col-md-6">
					<div class="text-right">
						<a class="btn btn-default" href="{{ url('help/faq') }}">คำถามที่พบบ่อย</a>
						&nbsp;
						<a href="{{ action('SellController@getIndex') }}" class="btn btn-success" title="{{ Lang::get('messages.create_campaign') }}">
							เริ่มสร้างแคมเปญ
						</a>
					</div>
				</div>
			</div>
			
		</div>
		<div id="guide-menu-mobile" class="row desktop-hidden mobile-show">
			<div class="col-sm-6 col-xs-12 col-mobile">
				<div class="bg-grey box-border guide-box box-campaign-mobile">
					<a id="guide-campaign-mobile" class="text-center guide-mobile" href="#collapse-carousel-campaign" data-toggle="collapse" aria-expanded="false">
						<span class="span-chevron">
							<i class="fa fa-chevron-down"></i>
						</span>
						<img src="{{asset('images/guide/campaign/HowToCampaign.png')}}">
						<h3 class="text-title">สร้างแคมเปญขายเสื้อยืดง่ายๆ </h3>
						<p class="guide-detail">
							ไม่มีค่าใช้จ่าย ไม่มีขาดทุน ไม่มีความเสี่ยงใดๆทั้งสิ้น
						</p>
						
					</a>
					<p id="btn-create-campaign" class="create-campaign text-center">
						<a href="{{ action('SellController@getIndex') }}" class="btn btn-success btn-lg">เริ่มสร้างแคมเปญ</a>
					</p>
					<div class="row">
						<div class="col-xs-12">
							<div id="collapse-carousel-campaign" class="collapse">
								<div id="carousel-campaign" class="carousel slide">
									<div class="carousel-inner text-center" role="listbox">
										<div class="item active">
											<div class="col-xs-12">
												<img src="{{asset('images/guide/campaign/HowToCampaign01.png')}}">



									        	<p class="sub-title">
													สร้างแคมเปญ
												</p>
												<p>
													ออกแบบ ตั้งเป้าการขาย และใส่รายละเอียดแคมเปญ ง่ายและไม่มีค่าใช้จ่ายใดๆ ทั้งสิ้น
												</p>
											</div>
										</div>
										<div class="item">
											<div class="col-xs-12">
												<img src="{{asset('images/guide/campaign/HowToCampaign02.png')}}">
												<p class="sub-title">
													โปรโมท
												</p>
												<p>
													ประชาสัมพันธ์ไปยังกลุ่มลูกค้า เช่น กลุ่มหรือชมรม เพื่อนในที่ทำงาน แฟนคลับของคุณ
												</p>
											</div>								
										</div>
										<div class="item">
											<div class="col-xs-12">
												<img src="{{asset('images/guide/campaign/HowToCampaign03.png')}}">
												<p class="sub-title">
													สำเร็จ!
												</p>
												<p>
													เมื่อแคมเปญได้รับการผลิต คุณจะได้รับรายได้จากการขายทันที ไม่มีเงื่อนไขใดๆ ทั้งสิ้น!
												</p>	
											</div>						
										</div>
									</div>

									<a class="left carousel-control" href="#carousel-campaign" role="button" data-slide="prev">
										<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
										<span class="sr-only">Previous</span>
									</a>
									<a class="right carousel-control" href="#carousel-campaign" role="button" data-slide="next">
										<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
										<span class="sr-only">Next</span>
									</a>
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



<section id="section-popular" class="section-product">
	<div id="product-popular">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-xs-8">
					<p class="topic-title font-title text-left">แคมเปญยอดนิยม</p>
				</div>
				<div class="col-md-4 col-xs-4">
					<a class="pull-right btn btn-default" href="https://www.{{ config('profile.sitename') }}/search?q=">
							ดูทั้งหมด
					</a>
				</div>
			</div>
			<div class="row">
				<div class="product-row">
					@foreach($hot_campaigns as $campaign)
		            	<div class="col-md-4 col-sm-6 col-xs-6 col-mobile">
							<a class="product-box {{ $campaign->design->block_front_count > 0 && $campaign->design->block_back_count > 0 ? 'product-thmb' : '' }}" href="{{ action('SellController@showCampaign', $campaign->url) }}">
								<div class="product-img">
									<img src="{{ $campaign->back_cover ? $campaign->design->image_back_preview : $campaign->design->image_front_preview }}"
										 data-default="{{ $campaign->back_cover ? 'back' : 'front' }}"
										 data-front="{{ $campaign->design->image_front_preview }}"
										 data-back="{{ $campaign->design->image_back_preview }}">
								</div>
								<div class="product-detail">
									<div class="product-name text-left">
										{{ $campaign->title}}
									</div>
									<div class="product-description">
										<div class="goal">
											<div class="progress">
												<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:{{ ($campaign->getSoldNumber()*100)/$campaign->goal }}%;">
													<span class="sr-only">{{ $campaign->getSold() }}</span>
												</div>
											</div>
											<div class="row">
											
												<div class="col-md-6 col-xs-12 pull-right">
													<div class="sold text-center">
														ขายแล้ว {{ $campaign->getSoldNumber() }}/{{ $campaign->goal }}
													</div>
												</div>
												<div class="col-md-6 col-xs-12">
													<div class="timeout">เหลือ {{ $campaign->getShortRemainTime() }}</div>
													
												</div>
											</div>
										</div>
									</div>
								</div>
							</a>
						</div>
		            @endforeach
				</div>
			</div>
		</div>
		<div class="container">
	<div class="row">
		<div class="col-md-12">
			<p class="tag-hit text-center">
				แท็กยอดนิยม:
				<a href="{{ url('search') }}?q=แม่">แม่</a>,
				<a href="{{ url('search') }}?q=Halloween">Halloween</a>,
				<a href="{{ url('search') }}?q=ทหาร">ทหาร</a>,
				<a href="{{ url('search') }}?q=ตำรวจ">ตำรวจ</a>,
				<a href="{{ url('search') }}?q=หมอ">หมอ</a>,
				<a href="{{ url('search') }}?q=พยาบาล">พยาบาล</a>,
				<a href="{{ url('search') }}?q=มหาวิทยาลัย">มหาวิทยาลัย</a>,
				<a href="{{ url('search') }}?q=แมว">แมว</a>,
				<a href="{{ url('search') }}?q=หมา">หมา</a>,
				<a href="{{ url('search') }}?q=ความรัก">ความรัก</a>,
				<a href="{{ url('search') }}?q=Hipster">Hipster</a>,
				<a href="{{ url('search') }}?q=ตลก">ตลก</a>,
				<a href="{{ url('search') }}?q=คำคม">คำคม</a>
			</p>
		</div>
	</div>
</div>
	</div>
</section>



<section id="section-review" class="">
	<div class="review-wrapper">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-xs-6">
					<p class="topic-title font-title text-left">ความคิดเห็นจากผู้ใช้</p>
				</div>
				<div class="col-md-6 col-xs-6">
					<a class="pull-right btn btn-primary" href="{{url('help/contact')}}?q=">
						ส่งคำแนะนำติชมถึงเรา
					</a>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="review-box">
						<p class="comment">
							Mubaza เป็นระบบที่เอื้อประโยชน์ให้กับครีเอเตอร์ และนักอยากออกแบบทั้งหลายมากเลย
						</p>
						<div class="author">
							-
							<span class="author-name">Fung Davin Fony</span>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="review-box">
						<p class="comment">
							ผมสามารถออกแบบและขายเสื้อได้โดยไม่ต้องมีหน้าร้าน ไม่ต้องใช้เงินทุน ผ่านมูบาซ่า
						</p>
						<div class="author">
							-
							<span class="author-name">Soranan Boonmaprasit</span>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="review-box">
						<p class="comment">
							มูบาซ่าช่วยให้ใครๆ ก็สามารถขายเสื้อยืดได้ ไม่จำเป็นต้องขายอย่างจริงๆ จังๆ อาจจะแค่ขายให้เพื่อนๆ หรือสร้างแคมเปญเฉพาะกิจ เช่น นำรายได้ไปช่วยเหลือผู้ประสบภัยหนาว โครงการช่วยเหลือสังคมอื่นๆ
						</p>
						<div class="author">
							-
							<span class="author-name">Chawput Nawakalanyu</span>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="review-box">
						<p class="comment">
							บริการดีจริงๆ เลย
						</p>
						<div class="author">
							-
							<span class="author-name">Pattama Sukthes</span>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</section>





<div id="section-start-campaign" style="background:url('{{ asset('images/vdo-bg.jpg') }}'); background-position: center; background-size: cover;">
	<div id="vdo-mask">
		<div class="container">
			<div class="jumbotron hero-video-footer" >
				<h1 class="jumbo-head text-white">รับชมวิดีโอแนะนำมูบาซ่า</h1>
				<a id="open-video" class="open-video btn-start-campaign fa-stack" href="#" data-toggle="modal" data-target="#video-modal"><i class="fa fa-2x fa-play"></i></a>
			</div>
		</div>
	</div>
</div>
<script>
	$('.open-video').click(function(){
		new_src = $("#video").attr('src')+"&amp;autoplay=1";
		$("#video").attr('src',new_src);
	    toggleVideo();
	})
	$('#close-video').click(function(){
		toggleVideo('hide');
	})
	$('#video-modal').on('hidden.bs.modal', function () {
	    toggleVideo('hide');
	});

	function toggleVideo(state) {

	    var div = document.getElementById("video-modal");
	    var iframe = div.getElementsByTagName("iframe")[0].contentWindow;
	    div.style.display = state == 'hide' ? 'none' : '';
	    func = state == 'hide' ? 'stopVideo' : 'playVideo';
	    iframe.postMessage('{"event":"command","func":"' + func + '","args":""}','*');
	}
</script>

@stop
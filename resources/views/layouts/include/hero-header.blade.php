 
<div id="section-slide" class="carousel slide" data-ride="carousel" style="position:relative;">
	<!--
	<ol class="carousel-indicators">
    	<li data-target="#section-slide" data-slide-to="0" class="active"></li>
    	<li data-target="#section-slide" data-slide-to="1"></li>
    	<li data-target="#section-slide" data-slide-to="2"></li>
  	</ol>-->
	<div class="carousel-inner" role="listbox">
		
		<div class="bg-carousel item active" style="background:url('{{ asset('images/hero-header/0.jpg') }}'); background-size:cover;background-position:center center;background-repeat: no-repeat;">
			<div class="hero-warp-2"></div>
			<div class="container fixnonslide">		
				<div class="jumbotron">
					<div class="group-hero-header hero-0">
						<div class="hero-head space-top-lg-3">
							<h1 class="text-center" style="text-shadow:0 2px 5px #555">
								<strong>Shirts for every moment.</strong>
							</h1>
							<!-- <div class="row">
							    <div class="col-sm-10 col-sm-offset-1">
							        <div class="input-group">
							            <input type="text" class="form-control input-lg" placeholder="Search for...">
							            <span class="input-group-btn">
							                <button class="btn btn-primary btn-lg" type="button">
							                    <i class="fa fa-search"></i> ค้นหา
							                </button>
							            </span>
							        </div>
							    </div>
							</div>
							<h3 class="text-center" style="text-shadow:0 2px 5px #555">
								
							</h3> -->
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="bg-carousel item active" style="background:url('{{ asset('images/hero-header/1.jpg') }}'); background-size:cover;background-position:center center;background-repeat: no-repeat;">
			<div class="hero-warp-1"></div>
			<div class="container  fixnonslide">		
				<div class="jumbotron">
					<div class="group-hero-header hero-1">
						<div class="hero-head" >
							<h1 style="text-shadow:0 2px 5px #555">
								<strong>
									Easy way to Design & Sell Shirts Online.
								</strong>
							</h1>
							<h3 style="text-shadow:0 2px 5px #555">อยากขายเสื้อยืดออนไลน์ ไม่ใช่เรื่องยากอีกแล้ว</h3>
							<p class="description"></p>
							<div id="group-startbutton">
								<a href="{{ action('AssociateController@getIndex') }}" class="btn btn-info btn-lg" title="">
									เรียนรู้เพิ่มเติม
								</a>
								&nbsp;
								<a href="{{ url('signup') }}" class="btn btn-success btn-lg" title="">
									ลงทะเบียน
								</a>
								&nbsp;
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- fixnonslide -->
			
	<!-- Controls -->
	<a class="left carousel-control" href="#section-slide" role="button" data-slide="prev">
	    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
	    <span class="sr-only">Previous</span>
	</a>
	<a class="right carousel-control" href="#section-slide" role="button" data-slide="next">
	    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
	    <span class="sr-only">Next</span>
	</a>

</div><!-- section-slide --> 

<div id="modal-line" class="modal modal-square fade ">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-body text-center">
				<h4>Line ID&nbsp;:&nbsp;<b>{{ config('profile.sitename') }}</b></h4>

                <p>Line QR Code&nbsp;:&nbsp;</p>

                <p><img width="60%" src="{{asset('images/mubazaQR.png')}}"></p>
			</div>
			<div class="modal-footer">
				<a href="{{asset('images/mubazaQR.png')}}" type="button" class="btn btn-primary" download="{{asset('images/mubazaQR.png')}}">บันทึก QR Code นี้</a>
				<button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
        		
			</div>
		</div>
	</div>
</div>
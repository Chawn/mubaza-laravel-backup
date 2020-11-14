@extends('backend.layouts.master')
@section('css')
<style>
.count {
	font-family: 'supermarket';
	font-size: 36px;
	color: #e67e22;
	margin: 0px;
}

.media {
	background: #f1f1f1;
	padding: 10px;
	box-shadow: 2px 2px 0px #989898;
	margin-bottom: 15px;
}
.media-circle {
	width: 50px;
	height: 50px;
	border-radius: 50%;
	background: #fff;
	display: inline-block;
}
.media-object {
	height: 38px;
	width: 38px;	
	margin: 6px;

}
.media-body {
	text-align: center;
}
.media-title {
	font-family: 'supermarket';
	font-size: 16px;
	color: #555;
	margin: 0px;
}
.media-here {
	background: #1abc9c;
	color: #fff;
	box-shadow: 0px 0px 0px;
}
.media-here p {
	color: #f1f1f1;
}
.media-here h2 {
	color: #f1f1f1;
}


</style>
@stop
@section('script')
<script>
	$(document).ready(function () {
            $(".media").click(function() {
                $(".media.media-here").removeClass("media-here");
                $(this).addClass("media-here");
            });
        });
	jQuery(document).ready(function($) {
            $(".clickable-row").click(function() {
                window.location = $(this).data("href");
            });
        });
	$(document).ready(function () {
                    $("#group-campaign-must").hide();
                    $("#group-mail").hide();
                    $("#group-payment").hide();
                    $("#group-report").hide();
                    $("#menu-wait").click(function () {
                        $("#group-campaign-wait").show();
                        $("#group-campaign-must").hide();
	                    $("#group-mail").hide();
	                    $("#group-payment").hide();
	                    $("#group-report").hide();
                    });
                    $("#menu-most").click(function () {
                        $("#group-campaign-wait").hide();
                        $("#group-campaign-must").show();
	                    $("#group-mail").hide();
	                    $("#group-payment").hide();
	                    $("#group-report").hide();
                    });
                    $("#menu-mail").click(function () {
                        $("#group-campaign-wait").hide();
                        $("#group-campaign-must").hide();
	                    $("#group-mail").show();
	                    $("#group-payment").hide();
	                    $("#group-report").hide();
                    });
                    $("#menu-payment").click(function () {
                        $("#group-campaign-wait").hide();
                        $("#group-campaign-must").hide();
	                    $("#group-mail").hide();
	                    $("#group-payment").show();
	                    $("#group-report").hide();
                    });
                    $("#menu-report").click(function () {
                        $("#group-campaign-wait").hide();
                        $("#group-campaign-must").hide();
	                    $("#group-mail").hide();
	                    $("#group-payment").hide();
	                    $("#group-report").show();
                    });
                });

</script>
@stop
@section('content')
<div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>150</h3>
                  <p>การแจ้งชำระเงินใหม่</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="{{ url('backend/payment') }}" class="small-box-footer">ดูข้อมูล <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3>53</h3>
                  <p>การร้องขอรับรายได้ใหม่</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{ url('backend/profit') }}" class="small-box-footer">ดูข้อมูล <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3>44</h3>
                  <p>ผู้ใช้ใหม่</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="{{ url('backend/users') }}" class="small-box-footer">ดูข้อมูล <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3>65</h3>
                  <p>ผู้เข้าชมรายใหม่</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="{{ url('backend/statistic') }}" class="small-box-footer">ดูข้อมูล <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
          </div>

          <div class="row">
          	<div class="col-md-8">
          		<div class="box box-info">
          			<div class="box-header with-border">
          				<h3 class="box-title">Latest Orders</h3>
          				<div class="box-tools pull-right">
          					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          					<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          				</div>
          			</div><!-- /.box-header -->
          			<div class="box-body">
          				<div class="table-responsive">
          					<table class="table no-margin">
          						<thead>
          							<tr>
          								<th>Order ID</th>
          								<th>Item</th>
          								<th>Status</th>
          								<th>Popularity</th>
          							</tr>
          						</thead>
          						<tbody>
          							<tr>
          								<td><a href="pages/examples/invoice.html">OR9842</a></td>
          								<td>Call of Duty IV</td>
          								<td><span class="label label-success">Shipped</span></td>
          								<td><div class="sparkbar" data-color="#00a65a" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div></td>
          							</tr>
          							<tr>
          								<td><a href="pages/examples/invoice.html">OR1848</a></td>
          								<td>Samsung Smart TV</td>
          								<td><span class="label label-warning">Pending</span></td>
          								<td><div class="sparkbar" data-color="#f39c12" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div></td>
          							</tr>
          							<tr>
          								<td><a href="pages/examples/invoice.html">OR7429</a></td>
          								<td>iPhone 6 Plus</td>
          								<td><span class="label label-danger">Delivered</span></td>
          								<td><div class="sparkbar" data-color="#f56954" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div></td>
          							</tr>
          							<tr>
          								<td><a href="pages/examples/invoice.html">OR7429</a></td>
          								<td>Samsung Smart TV</td>
          								<td><span class="label label-info">Processing</span></td>
          								<td><div class="sparkbar" data-color="#00c0ef" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div></td>
          							</tr>
          							<tr>
          								<td><a href="pages/examples/invoice.html">OR1848</a></td>
          								<td>Samsung Smart TV</td>
          								<td><span class="label label-warning">Pending</span></td>
          								<td><div class="sparkbar" data-color="#f39c12" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div></td>
          							</tr>
          							<tr>
          								<td><a href="pages/examples/invoice.html">OR7429</a></td>
          								<td>iPhone 6 Plus</td>
          								<td><span class="label label-danger">Delivered</span></td>
          								<td><div class="sparkbar" data-color="#f56954" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div></td>
          							</tr>
          							<tr>
          								<td><a href="pages/examples/invoice.html">OR9842</a></td>
          								<td>Call of Duty IV</td>
          								<td><span class="label label-success">Shipped</span></td>
          								<td><div class="sparkbar" data-color="#00a65a" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div></td>
          							</tr>
          						</tbody>
          					</table>
          				</div><!-- /.table-responsive -->
          			</div><!-- /.box-body -->
          			<div class="box-footer clearfix">
          				<a href="javascript::;" class="btn btn-sm btn-primary btn-flat pull-left">Place New Order</a>
          				<a href="javascript::;" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
          			</div><!-- /.box-footer -->
          		</div>
          	</div>
          	<div class="col-md-4">
          		<div class="box box-info">
          			<div class="box-header with-border">
          				<h3 class="box-title">Latest Orders</h3>
          				<div class="box-tools pull-right">
          					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          					<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          				</div>
          			</div><!-- /.box-header -->
          			<div class="box-body">
          				<div class="table-responsive">
          					<table class="table no-margin">
          						<thead>
          							<tr>
          								<th>Order ID</th>
          								<th>Item</th>
          								<th>Status</th>
          								<th>Popularity</th>
          							</tr>
          						</thead>
          						<tbody>
          							<tr>
          								<td><a href="pages/examples/invoice.html">OR9842</a></td>
          								<td>Call of Duty IV</td>
          								<td><span class="label label-success">Shipped</span></td>
          								<td><div class="sparkbar" data-color="#00a65a" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div></td>
          							</tr>
          							<tr>
          								<td><a href="pages/examples/invoice.html">OR1848</a></td>
          								<td>Samsung Smart TV</td>
          								<td><span class="label label-warning">Pending</span></td>
          								<td><div class="sparkbar" data-color="#f39c12" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div></td>
          							</tr>
          							<tr>
          								<td><a href="pages/examples/invoice.html">OR7429</a></td>
          								<td>iPhone 6 Plus</td>
          								<td><span class="label label-danger">Delivered</span></td>
          								<td><div class="sparkbar" data-color="#f56954" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div></td>
          							</tr>
          							<tr>
          								<td><a href="pages/examples/invoice.html">OR7429</a></td>
          								<td>Samsung Smart TV</td>
          								<td><span class="label label-info">Processing</span></td>
          								<td><div class="sparkbar" data-color="#00c0ef" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div></td>
          							</tr>
          							<tr>
          								<td><a href="pages/examples/invoice.html">OR1848</a></td>
          								<td>Samsung Smart TV</td>
          								<td><span class="label label-warning">Pending</span></td>
          								<td><div class="sparkbar" data-color="#f39c12" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div></td>
          							</tr>
          							<tr>
          								<td><a href="pages/examples/invoice.html">OR7429</a></td>
          								<td>iPhone 6 Plus</td>
          								<td><span class="label label-danger">Delivered</span></td>
          								<td><div class="sparkbar" data-color="#f56954" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div></td>
          							</tr>
          							<tr>
          								<td><a href="pages/examples/invoice.html">OR9842</a></td>
          								<td>Call of Duty IV</td>
          								<td><span class="label label-success">Shipped</span></td>
          								<td><div class="sparkbar" data-color="#00a65a" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div></td>
          							</tr>
          						</tbody>
          					</table>
          				</div><!-- /.table-responsive -->
          			</div><!-- /.box-body -->
          			<div class="box-footer clearfix">
          				<a href="javascript::;" class="btn btn-sm btn-primary btn-flat pull-left">Place New Order</a>
          				<a href="javascript::;" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
          			</div><!-- /.box-footer -->
          		</div>
          	</div>
          </div>
<div id="index-menu">
	<div class="col-md-3">
		<div id="menu-wait" class="media btn media-here">
			<div class="media-left media-middle">
				<a class="media-circle" href="#">
					<img class="media-object " src="{{asset('images/icon/backend/uwait_38.png')}}">
				</a>
			</div>
			<div class="media-body">
				<p class="media-title">แคมเปญรอการผลิต</p>
				<h2 class="count">{{ count($waiting_produces) }}</h2>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div id="menu-most" class="media btn">
			<div class="media-left media-middle">
				<a class="media-circle" href="#">
					<img class="media-object" src="{{asset('images/icon/backend/uicon_38.png')}}">
				</a>
			</div>
			<div class="media-body">
				<p class="media-title">แคมเปญที่กำลังเดินการผลิต</p>
				<h2 class="count">{{ $producings->total() }}</h2>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div id="menu-payment" class="media btn">
			<div class="media-left media-middle ">
				<a class="media-circle" href="#">
					<img class="media-object" src="{{asset('images/icon/backend/ubank_38.png')}}">
				</a>
			</div>
			<div class="media-body">
				<p class="media-title">แจ้งการชำระเงิน</p>
				<h2 class="count">{{ $orders->total() }}</h2>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div id="menu-report" class="media btn">
			<div class="media-left media-middle ">
				<a class="media-circle" href="#">
					<img class="media-object " src="{{asset('images/icon/backend/utalk_38.png')}}">
				</a>
			</div>
			<div class="media-body">
				<p class="media-title">รายงานผู้ใช้ผิดกฎ</p>
				<h2 class="count">320</h2>
			</div>
		</div>
	</div>
</div>
<div id="index-table">
	<div class="row">
		<div class="col-md-12">
			<div id="group-campaign-wait">
				<a class="pull-right btn btn-green seeall" 
						href="{{ action('BackendController@getWaitingProduce') }}">ดูทั้งหมด >>
				</a>
				<table id="table-campaign-wait" class="table-radius none-source">			
					<thead>
						<tr>
							<th>รหัส</th>
							<th>วันที่จบ</th>
							<th>ชื่อแคมเปญ</th>
							<th>ขายได้</th>
							<th>สถานะ</th>
						</tr>
					</thead>
					<tbody> <!-- 10 row -->
                        @forelse($waiting_produces as $waiting_campaign)
						<tr class="clickable-row" data-href="{{ action('BackendController@getShowProduce', $waiting_campaign->id) }}">
							<td class="col-id">{{ $waiting_campaign->id }}</td>
							<td class="">{{ $waiting_campaign->end->format('d-m-Y H:i:s') }}</td>
							<td class="col-overflow">{{ $waiting_campaign->title }}</td>
							<td>{{ $waiting_campaign->totalProfit() }}</td>
							<td>{{ $waiting_campaign->produce_status->detail }}</td>
						</tr>
                        @empty
                        <tr><td colspan="5">ยังไม่มีแคมเปญที่พร้อมผลิต</td></tr>
                        @endforelse
					</tbody>
				</table>
			</div>
			<div id="group-campaign-must">
				<a class="pull-right btn btn-green seeall" 
						href="{{ action('BackendController@getProducing') }}">ดูทั้งหมด >>
				</a>
				<table id="table-campaign-must" class="table-radius table-saurce">
					<thead>
						<tr>
							<th>รหัส</th>
							<th>วันที่จบ</th>
							<th>ชื่อแคมเปญ</th>
							<th>ขายได้</th>
							<th>สถานะ</th>
						</tr>
					</thead>
					<tbody> <!-- 10 row -->
                        @forelse($producings as $producing_campaign)
						<tr class="clickable-row" data-href="{{ action('BackendController@getShowProduce', $producing_campaign->id) }}">
                            <td class="col-id">{{ $producing_campaign->id }}</td>
                            <td class="">{{ $producing_campaign->end->format('d-m-Y H:i:s') }}</td>
                            <td class="col-overflow">{{ $producing_campaign->title }}</td>
                            <td>{{ $producing_campaign->totalProfit() }}</td>
                            <td>{{ $producing_campaign->produce_status->detail }}</td>
						</tr>
                        @empty
                            <tr><td colspan="5">ยังไม่มีแคมเปญที่พร้อมผลิต</td></tr>
                        @endforelse
					</tbody>
				</table>
			</div>
			<div id="group-payment">
				<a class="pull-right btn btn-green seeall" 
						href="{{ action('BackendController@getPayment') }}">ดูทั้งหมด >>
				</a>
				<table id="table-payment" class="table-radius">
					<thead>
						<tr>
							<th>รหัสสั่งซื้อ</th>
			                <th>ผู้ซื้อ</th>
			                <th>ยอดโอน</th>
			                <th>วัน-เวลา ที่โอน</th>
			                <th>ธนาคารที่โอนเข้า</th>
			                <th>ธนาคารต้นทาง</th>
			                <th>สถานะ</th>
						</tr>
					</thead>
					<tbody> <!-- 10 row -->
                    @forelse($orders as $order)
                        <tr class="clickable-row" data-href="{{ action('BackendController@getPaymentDetail', $order->id) }}">
                            <td>{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $order->user->full_name }}</td>
                            <td>{{ $order->subTotal() }}</td>
                            <td>{{ $order->payment[0]->created_at->format('d-m-Y H:i:s') }}</td>
                            <td>{{ $order->payment[0]->to_bank }}</td>
                            <td>{{ $order->payment[0]->from_bank }}</td>
                            <td>{{ $order->payment_status->detail }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">ไม่มีรายการแจ้ง</td>
                        </tr>
                    @endforelse
					</tbody>
				</table>
			</div>
			<div id="group-report">
				<a class="pull-right btn btn-green seeall" 
						href="{{ action('BackendController@getPayment') }}">ดูทั้งหมด >>
				</a>
				<table id="table-report" class="table-radius">
					<thead>
						<tr>
							<th>วันที่แจ้งเรื่อง</th>
							<th>ผู้แจ้ง</th>
							<th>เรื่องที่แจ้ง</th>
							<th>รายละเอียด</th>
						</tr>
					</thead>
					<tbody> <!-- 10 row -->

					</tbody>
				</table>
			</div>
		</div>
	</div>
	

</div>
@stop
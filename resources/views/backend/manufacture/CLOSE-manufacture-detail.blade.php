@extends('backend.layouts.master')
@section('css')
<style>
/* header*/
#order-detail {
	margin: 0px 0 0 0;
	}
#order-detail img{
	height: 200px;
	width: 200px;
	margin:10px 0 0 0;
	}
#order-detail h6 {
	font-size:18px;
	padding-bottom:5px;
	}
#order-detail span {
	font-size:16px;
	vertical-align: text-top;
	display:inline;
	}
#order-detail p {
	font-size:16px;
	vertical-align: text-top;
	color:#000;
	display:inline;
	}
#order-detail-header {
	width:100%;
	display:inline;
	}
#order-detail-header h4{
	font-size:24px;
	color:#000;
	float:left;
	}
#order-detail-header h5{
	font-size:24px;
	color: #000;
	float:right;
	}
#order-status {
	width:100%;
	float:right;
	margin: 0 0 10px 0;
	text-align:right;
	}

#order-status span  {
	font-size:18px;
	color:#000;
	}
#order-status p1 {
	font-size:18px;
	color:#000;
	vertical-align:middle;
	}
#order-status p2 {
	font-size:18px;
	color:#000;
	vertical-align:middle;
	margin-left:10px;
	}
.edit-status {
	color:#2c3e50;
	display:inline;
	font-size:16px;
	vertical-align: text-top;
	margin: 0 0 0 20px;
	}
.edit-status:hover {
	text-decoration:none;
	color:#e67e22;
	}
.edit-status:active {
	text-decoration:none;
	border:0px solid transparent;
	}
#collapse-editstatus .well {
	border:1px solid transparent;
	background:none;
	height:60px;
	}
	
/**/	
#table-detail {
	width:100%;
	margin: 0 0 20px 0;
	border-top:	solid 1px #ddd;
	}
#table-detail tr {
	line-height:20px;
	vertical-align:top;
	border-bottom:1px solid #ddd;
	}
#table-detail td {
	padding: 15px 0 10px 50px;

	}
#table-detail tr:last-child {
	padding-bottom:40px;
	border-bottom:none;
	}	
#btn-download {
	width:350px;
	height:40px;
	font-size:16px;
	font-weight:bold;
	margin: 0 0 15px 0;
	}

/* Orderstatus (bottom) */
#btn-printAddressAll {
	width:250px;
	margin: 0 16px 0 0;
	font-size:16px;
	}
#btn-printAddressAll:hover {	
	}
#Receiver {
	margin: 20px 0 50px 0;
	}

h4 {
	font-size:22px;
	}
.pricetag {
	margin:15px 0 15px 0;
	}

#pricetag-view-revenue h2 {
	margin: 10px 0 0 0;
	}	
</style>
<script type="text/javascript">
	$(document).ready(function() { 
		$("#table-receiver").tablesorter();
        $('#save-status').click(function() {
            $.ajax({
                type: "POST",
                url: $('#campaign-status').data('url'),
                data: {
                    "_token": $('#save-status-token').val(),
                    "status_id": $('#campaign-status').val()
                },
                dataType: "json",
                success: function (data) {
                    if(data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                },
                failure: function (errMsg) {
                    alert(errMsg);
                }
            });
        });

        $('.view-order-btn').click(function() {
            $('#order-list').modal();
            var order_list_table = $('#order-list-table tbody');
            order_list_table.empty();
            $.ajax({
                type: "get",
                url: $(this).data('url'),
                dataType: "json",
                success: function (data) {
                    if(data.success) {
                        console.log(data);

                        var html = "";
                        $.each(data.items, function(k, item) {
                            html += '<tr>';
                            html += '<td>' + item.product.name + '</td>';
                            html += '<td>' + item.size + '</td>';
                            html += '<td><i class="fa fa-stop" style="color: ' + item.product_image.color + '"></i>&nbsp;' + item.product_image.color_name + '</td>';
                            html += '<td>' + item.qty + '</td>';
                            html += '</tr>';
                        });

                        order_list_table.html(html);
                    } else {
                        alert(data.message);
                    }
                },
                failure: function (errMsg) {
                    alert(errMsg);
                }
            });
        });
	}); 
</script>
@stop
@section('content')
<div id="order-detail-header">
	<div class="col-md-5">
    	<h4>{{ str_pad($campaign->id, 6, '0', STR_PAD_LEFT) }}</h4>
    </div>
    <div class="col-md-7">       		
	<h5>{{ $campaign->title }}</h5><br/><br />
	<div id="order-status">                            	                           	
		<span>สถานะ : </span> <p1>{{ $campaign->status->name }}</p1>
		<a class="edit-status" data-toggle="collapse" href="#collapse-editstatus" aria-expanded="false" aria-controls="collapse-editstatus"><i class="glyphicon glyphicon-pencil"></i> แก้ไขสถานะ </a>
			<div class="collapse" id="collapse-editstatus">
				<div class="well">
                    <input name="_token" value="{{ csrf_token() }}"}} id="save-status-token" type="hidden"/>
					<select id="campaign-status" data-url="{{ action('CampaignController@postSaveStatus', $campaign->id) }}">
						<option value="3">กำลังดำเนินการผลิต</option>
                        <option value="4">ผลิตเรียบร้อยแล้ว</option>
                        <option value="5">รอการจัดส่ง</option>
                        <option value="6">จัดส่งเรียบร้อยแล้ว</option>
					</select>
					<button class="btn btn-green" id="save-status">บันทึก</button>
				</div>
			</div>
                         
		</div>
    </div>
</div><!-- end order-detail-header -->
<div id="order-detail">        
	<div class="col-md-12" >                    
		<table id="table-detail">
            @foreach($ordered_product as $color => $items)
                @foreach($items as $item)
                    <tr>
                        <td><img src="{{ url('/') . '/' . $item['image_front'] }}" /></td>
                        <td><h6>{{ $item['name'] }} สี <i class="fa fa-stop" style="color: {{ $item['color'] }};"></i>&nbsp;{{ $item['color_name'] }}</h6>
                            @foreach($item['sizes'] as $size => $value)
                            <span> ขนาด : </span> <p> {{ $size }} </p> <span> จำนวน : </span> <p> {{ $value}} </p> <span> ตัว </span> <br><br>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            @endforeach
    	</table>                  
	<div class="col-md-12" style="border-bottom:1px solid #999">
        <div class="navbar-left">
            <button id="btn-download" class="btn btn-orenge" > ดาวโหลดลายสำหรับสกรีน </button>
        </div>
	</div>
</div>
</div> <!-- end order-detail -->
            
	<div class="row">
      	<div class="col-md-12">
        	<div id="Receiver">
      			<div class="navbar-left"><h4>รายชื่อผู้สั่งซื้อ</h4></div>
                <div><a href="{{ action('BackendController@getPrintCheckListReport', $campaign->id) }}" class="btn btn-success"><i class="fa fa-printer"></i>ใบเช็ครายการสินค้า</a></div>
            <table id="table-receiver" class="table-radius">
            	<thead>
                  <tr>
                    <th width="10%">เลขที่สั่งซื้อ</th>
                    <th width="20%">ชื่อ - สกุล</th>
                    <th width="10%">เบอร์โทร</th>
                    <th width="30%">ที่อยู่ผู้รับ</th>
                    <th width="20%">สถานะการสั่งซื้อ</th>
                    <th width="10%"></th>
                    {{--<th width="20%">สถานะการจ่ายเงิน</th>--}}
                  </tr>
            	</thead>
                <tbody>

                @foreach($orders as $order)
                        <tr>
                            <td>{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ (is_null($order->user) ? 'Guest' : $order->user->full_name) }}</td>
                            <td>{{ (is_null($order->shipping_address) ? '-' : $order->shipping_address->phone) }}</td>

                            {{--<td>{{ $item->product->name }}/{{ $item->color }}/{{ $item->size }}/{{ $item->qty }}</td>--}}
                            <td>{{ $order->getFullAddress() }}ี</td>
                            <td>{{ $order->status->name }}</td>
                            {{--<td>{{ $order->payment_status->name }}</td>--}}
                            <td><button class="btn btn-success view-order-btn" data-url="{{ action('OrderController@getOrderItemById', $order->id) }}"><i class="fa fa-search"></i></button></td>
                        </tr>
                @endforeach
            	</tbody>
                <tfoot>
                <tr>
                    <td colspan="5">{!! str_replace('/?', '?', $orders->render()) !!}</td>
                </tr>
                </tfoot>
            	</table>
                <div class="div-pagination">

        		</div>
		</div>
	</div>

<div class="modal fade" id="tracking-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">กรุณากรอกหมายเลขแทรกกิ้ง ของคุณปรียานุช</h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="control-label">หมายเลข:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
        <button type="button" class="btn btn-green">ยืนยัน</button>
      </div>
    </div>
  </div>
</div>
        <!-- Diaglog box show order item -->
        <div class="modal fade" id="order-list">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">รายละเอียดการสั่งซื้อ</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped" id="order-list-table">
                            <thead>
                            <tr>
                                <th>ชื่อ</th>
                                <th>ขนาด</th>
                                <th>สี</th>
                                <th>จำนวน</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-remove"></i>&nbsp;ปิด</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
@stop
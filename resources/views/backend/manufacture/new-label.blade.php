<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <title>พิมพ์ใบปะหน้าซอง</title>
    <link rel="stylesheet" href="{{ asset('css/print-customer-address.css') }}">
    <script src="{{ asset('jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery-barcode.js') }}"></script>
    <script src="{{ asset('js/jquery.qrcode.min.js') }}"></script>
    <script>
	    $(document).ready(function () {
            $(".barcode-pane").each(function () {
                $(this).barcode($(this).attr("data-order-id"), 'code39', {
                    barWidth: 2,
                    barHeight: 40
                });
            });

            $(".qrcode").each(function() {
                $(this).qrcode({
                    width: 80,
                    height: 80,
                    text: $(this).attr("data-url")
                });
            });
        });
    </script>
    <style type="text/css">
    .page-a44{
    	border-bottom: 1px solid #ddd;
    	padding: 15px 10px 10px 16px;
    }
    .logo {
    	width: 70px;
    	float: left;
    	display: inline-block;
    	padding-top: 5px;
    }
    .logo img{
    	width: 100%;
    }
    </style>

</head>
<body>
		<div class="page-a44">
			<table>
				<tr>
					<td width="50%">
						<div class="header">
							<table>
								<tr>
									<td width="80px">
										<div class="logo">
											<img src="{{ asset('images/logo-black-470.png') }}">
										</div>
									</td>
									<td>
										<div class="detail">
											<p>
												From&nbsp;:&nbsp;GG7&nbsp;
												197/63 Benjang Road, Mak Khaeng, Mueang Udon Thani, Udon Thani, 41000 <br>
												call&nbsp;:&nbsp;{{ config('profile.phone-primary') }},  
											</p>
											<h4>www.{{ config('profile.sitename') }}</h4>
										</div>
									</td>
									<td width="75px">
										<div class="qrcode" data-url="{{ action('UserController@getShowOrder', [$order->user->getID(), $order->id]) }}">
											
										</div>
									</td>
								</tr>
							</table>
						</div>							
						<div class="barcode">
							<div class="head">
								<div class="orderid">
									ORDER ID <span>{{ str_pad($order->id, 8, 0, STR_PAD_LEFT) }}</span>
								</div>
								<div class="tringle"></div>
								<div class="qty">
									QTY&nbsp;:&nbsp;{{ $order->totalQTY() }}&nbsp;ชิ้น
								</div>
							</div>
							<div class="order">
								@foreach($order->items as $item)
									<div class="item">
										<p>ชื่อสินค้า&nbsp;:&nbsp;{{ $item->campaign_product->campaign->title }}</p>
										<p class="text-indent">{{ $item->campaign_product->color->color_name }} ไซต์ {{ $item->sku->size }}&nbsp;:&nbsp;<span>{{ $item->qty }}&nbsp;ตัว</span></p>
									</div>
								@endforeach
							</div>
							<p class="seemore">Scan QR Code To See More*</p>
						</div>							
					</td>
					<td width="48%">
						<div class="box-barcode">
							<div class="order-id" >
								<p>ORDER ID</p>
                        		<div class="barcode-pane" data-order-id="{{ str_pad($order->id, 8, 0, STR_PAD_LEFT) }}"></div>
							</div>
						</div>
						<div class="address">
							<table>
								<tbody>
									<tr>
										<td width="45px">
											<h2>To&nbsp;:&nbsp;</h2>
										</td>
										<td>
											<h2>{{ $order->shipping_address->full_name }}</h2>
											@if($order->shipping_address->building != '')
					                            <p>{{ $order->shipping_address->building }}</p>
					                        @endif
					                        <p>{{ $order->shipping_address->address }}</p>

					                        <p>อ.{{ $order->shipping_address->district }}
					                            &nbsp;จ.{{ $order->shipping_address->province }}</p>

					                        <p>โทร&nbsp;{{ $order->shipping_address->phone }}</p>
								    		<h2 class="zipcode">{{ $order->shipping_address->zipcode }}</h2>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</td>
				</tr>
			</table>
		</div>

</body>
@extends('user.layouts.full-width')
@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $(".table-gray").tablesorter();
        });
        jQuery(document).ready(function ($) {
            $(".clickable-row").click(function () {
                window.location = $(this).data("href");
            });
        });
    </script>
@stop
@section('css')
    <style>
        @media (max-width: 480px) {
            #user-header #about #u-favorite {
                display: none;
            }
        }
        #user-order-history{
            display: block;
        }
        #mobile-user-order-history{
            display: none;
        }
        @media(max-width: 767px){
             #user-order-history{
                display: none;
            }
            #mobile-user-order-history{
                display: block;
            }
            .box{
                padding: 10px;
                border: 1px solid #ddd;
                box-shadow: 3px 3px 3px #eee;
                margin:0;
                border-radius: 4px;
            }
        }
    </style>
@stop
@section('content')

    <div class="row bg-dashboard">
        <div id="user-order-history" class="col-md-12">
            @if(count($orders) > 0)
                <table class="table-gray">
                    <thead>
                    <tr>
                        <th>รหัสสั่งซื้อ</th>
                        <th>วันที่สั่งซื้อ</th>
                        <th>ยอดสั่งซื้อ</th>
                        <th>สถานะการชำระเงิน</th>
                        <th>สถานะการผลิตและจัดส่ง</th>
                    </tr>
                    </thead>
                    <tbody> <!-- 10 row -->
                    @foreach($orders as $order)
                        <tr class="clickable-row"
                            data-href="{{ action('UserController@getShowOrder', [$user->getID(), $order->id]) }}">
                            <td>#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $order->created_at }}</td>
                            <td>{{ $order->subTotal() }}</td>
                            <td>
                                {{ $order->payment_status->detail }}
                            </td>
                            <td>
                                {{ $order->produce_status->detail }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert text-center" role="alert">ยังไม่มีการสั่งซื้อในขณะนี้</div>
            @endif
        </div>
        {{-- ถ้าเป็นออกแบบเพื่อซื้อ ไม่ต้องทำเป็นlinkที่ชื่อสินค้า ถ้าซื้อของคนอื่น ค่อยlink --}}
        <div id="mobile-user-order-history" class="col-xs-12">
            @forelse($orders as $order)
                <div class="box">
                    <div class="order"
                         onclick="location.href='{{ action('UserController@getShowOrder', [$user->getID(), $order->id]) }}';">
                        <div class="order-title">
                            <h4>
							<span>
							     @if($order->payment_status->name=='paid')
                                    <i class="fa fa-check-circle check"></i>
                                @else
                                    <i class="fa fa-exclamation-circle wait"></i>
                                @endif
                                สถานะการชำระเงิน&nbsp;{{ $order->payment_status->detail }}
							</span>
                            </h4>
                        </div>
                        <div class="order-detail">
                            <p><strong>วันที่สั่ง</strong>&nbsp;<span>{{ $order->created_at }}</span></p>
                            <p><strong>สถานะการผลิตและจัดส่ง</strong>&nbsp;<span>{{ $order->produce_status->detail }}</span></p>
                        </div>
                        <div class="order-total">
                            <span><strong>ยอดรวม</strong>&nbsp;{{ $order->subTotal() }}&nbsp;บาท</span>
                            @if($order->payment_status->name=='paid')
                                &nbsp;
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="alert text-center" role="alert">ไม่มีรายการสั่งซื้อ</div>
                </div>
            @endforelse
        </div>
    </div>
    <div class="row bg-dashboard">
        <div class="col-md-12">
            <nav class="pull-right mobile-paging">
                {!! str_replace('/?', '?', $orders->render()) !!}
            </nav>
        </div>
    </div>
@stop
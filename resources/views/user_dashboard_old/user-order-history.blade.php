@extends('layouts.user_full_width')
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
    </style>
@stop
@section('content')
    <div class="row bg-dashboard">
        <div id="user-order-history" class="col-md-12">
            @if(count($orders) > 0)
                <table class="table-gray">
                    <thead>
                    <tr>
                        <th>วันที่สั่งซื้อ</th>
                        <th>ยอดสั่งซื้อ</th>
                        <th>สถานะการชำระเงิน</th>
                        <th>สถานะการผลิตและจัดส่ง</th>
                    </tr>
                    </thead>
                    <tbody> <!-- 10 row -->
                    @forelse($orders as $order)
                        <tr class="clickable-row"
                            data-href="{{ action('UserController@getShowOrder', [$user->getID(), $order->id]) }}">
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $order->subTotal() }}</td>
                            <td>
                                {{ $order->payment_status->detail }}
                            </td>
                            <td>
                                {{ $order->status->detail }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">ไม่มีรายการสั่งซื้อ</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            @else
                <div class="alert text-center" role="alert">ยังไม่มีการสั่งซื้อในขณะนี้</div>
            @endif
        </div>
    <div class="row bg-dashboard">
        <div class="col-md-12">
            <nav class="pull-right mobile-paging">
                {!! str_replace('/?', '?', $orders->render()) !!}
            </nav>
        </div>
    </div>
@stop
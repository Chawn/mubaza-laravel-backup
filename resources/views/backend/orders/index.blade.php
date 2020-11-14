@extends('backend.layouts.master')
@section('css')
    <style>
        .error {
            border-color: #f00;
        }
        #table-manufacture-detail h3 {
            display:inline;
        }
        #table-manufacture-detail h2 {
            font-size:14px;
            color:#666;
        }
        #table-manufacture-detail>tbody>tr>td:nth-child(2) {
            text-align: left;
        }
        .small-product-image{
            width: 50px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#table-manufacture-detail").tablesorter();
        });
    </script>
    <link rel="stylesheet" href="{{ asset('js/timepicker/dist/jquery-ui-timepicker-addon.min.css') }}">
@stop
@section('script')
    <script src="{{ asset('js/validate/jquery.validate.min.js') }}"> </script>
    <script src="{{ asset('js/validate/additional-methods.min.js') }}"> </script>
    <script src="{{ asset('js/validate/localization/messages_th.min.js') }}"> </script>
    <script src="{{ asset('js/timepicker/dist/jquery-ui-timepicker-addon.min.js') }}"></script>

    <script src="{{ asset('js/timepicker/dist/jquery-ui-sliderAccess.js') }}"></script>
    <script>
        $(function() {
            $("#paginate-select").change(function() {
                window.location = $(this).val();
            });
        });
    </script>
@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
               <div class=" form-inline">
                   <div class="row">
                       <div class="col-sm-6 col-xs-6">
                           <div class="dataTables_length" id="example1_length">
                               <label>แสดง
                                   <select name="paginate_select" id="paginate-select" class="form-control input-sm">
                                       <option value="{{ action('BackendController@getOrder', 12) }}{{ $keyword == '' ? '' : '?q=' . $keyword }}" {{ $paging == 12 ? 'selected' : '' }}>12 รายการ</option>
                                       <option value="{{ action('BackendController@getOrder', 24) }}{{ $keyword == '' ? '' : '?q=' . $keyword }}" {{ $paging == 24 ? 'selected' : '' }}>24 รายการ</option>
                                       <option value="{{ action('BackendController@getOrder', 36) }}{{ $keyword == '' ? '' : '?q=' . $keyword }}" {{ $paging == 36 ? 'selected' : '' }}>36 รายการ</option>
                                   </select> ต่อหน้า
                               </label>
                           </div>
                       </div>
                       <div class="col-sm-6 col-xs-6">
                           <div id="example1_filter" class="dataTables_filter">
                               <div class="pull-right">
                                   <label>
                                       <form action="{{ action('BackendController@getOrder') }}" method="get">
                                           ค้นหา: <input type="text" class="form-control" name="q" placeholder="">
                                       </form>
                                   </label>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
            </div>
            <div class="box-body box-product">
                
                <table class="table">
                    <thead>
                        <tr>
                            <th>รหัสสั่งซื้อ</th>
                            <th>วันที่สั่งซื้อ</th>
                            <th>ผู้สั่งซื้อ</th>
                            <th>ผู้รับ</th>
                            <th>ยอด</th>
                            <th>การชำระเงิน</th>
                            <th>การผลิต</th>
                            <th>เครื่องมือ</th>
                        </tr>
                    </thead>
                    @forelse($orders as $order)
                        <tr>
                        <td>
                            <a href="{{ action('BackendController@getOrderDetail', $order->id) }}">
                               {{ $order->id }}
                            </a>

                        </td>
                        <td>
                            {{ $order->created_at->format('d/m/Y') }}
                        </td>
                        <td>
                            <a href="{{ action('BackendController@getUserDetail', $order->user) }}">
                                {{ $order->user == null ? $order->shipping_address->full_name : $order->user->full_name }}
                            </a>
                        </td>
                        <td>
                            {{ $order->shipping_address->full_name }}
                        </td>
                        <td>
                            ฿{{ number_format($order->sub_total, 2) }}
                        </td>
                        <td>
                            {{ $order->payment_status->detail }}
                        </td>
                        <td>
                            {{ $order->status->detail }}
                        </td>
                        <td>
                            <a href="{{ action('BackendController@getUpdateOrder', $order->id) }}" class="btn btn-warning">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a href="{{ action('BackendController@getOrderDetail', $order->id) }}" class="btn btn-primary">
                                <i class="fa fa-search"></i>
                            </a>
                        </td>
                    </tr>
                        @empty
                    <tr>
                        <td colspan="8">ไม่มีรายการสั่งซื้อ</td>
                    </tr>
                        @endforelse
                </table>
                <div class="div-pagination">
                    <div class="navbar">
                        {!! str_replace('/?', '?', $orders->render()) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="payment-save-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">แจ้งการชำระเงิน</h4>
            </div>
            <div class="modal-body">
                <form id="payment-form" method="POST" action="{{ action('BackendController@postUpdatePayment') }}">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                    <input name="order_id" id="order-id" type="hidden" />
                    <div class="form-group">
                        <label for="from-bank">จากธนาคาร</label>
                        <input type="text" class="form-control" id="from-bank" name="from_bank" placeholder="โอนเงินจากธนาคาร">
                    </div>
                    <div class="form-group">
                        <label for="to-bank">ถึงธนาคาร</label>
                        <input type="text" class="form-control" id="to-bank" name="to_bank" placeholder="โอนเงินถึงธนาคาร" required>
                    </div>
                    <div class="form-group">
                        <label for="total">จำนวนเงิน</label>
                        <input type="number" class="form-control" id="total" name="total" placeholder="จำนวนเงิน" required>
                    </div>
                    <div class="form-group">
                        <label for="transferred-on">วันที่-เวลา</label>
                        <input type="text" class="form-control" id="transferred-on" name="transferred_on" placeholder="วันที่-เวลา" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    ยกเลิก
                </button>
                <button type="button" class="btn btn-primary" id="save-btn">
                    บันทึก
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@stop
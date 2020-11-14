@extends('backend.layouts.master')
@section('css')
    <link rel="stylesheet" href="{{ asset('js/timepicker/dist/jquery-ui-timepicker-addon.min.css') }}">
@stop
@section('script')
    <script src="{{ asset('js/timepicker/dist/jquery-ui-timepicker-addon.min.js') }}"></script>

    <script src="{{ asset('js/timepicker/dist/jquery-ui-sliderAccess.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            var myControl=  {
                create: function(tp_inst, obj, unit, val, min, max, step){
                    $('<input class="ui-timepicker-input" value="'+val+'" style="width:50%">')
                            .appendTo(obj)
                            .spinner({
                                min: min,
                                max: max,
                                step: step,
                                change: function(e,ui){ // key events
                                    // don't call if api was used and not key press
                                    if(e.originalEvent !== undefined)
                                        tp_inst._onTimeChange();
                                    tp_inst._onSelectHandler();
                                },
                                spin: function(e,ui){ // spin events
                                    tp_inst.control.value(tp_inst, obj, unit, ui.value);
                                    tp_inst._onTimeChange();
                                    tp_inst._onSelectHandler();
                                }
                            });
                    return obj;
                },
                options: function(tp_inst, obj, unit, opts, val){
                    if(typeof(opts) == 'string' && val !== undefined)
                        return obj.find('.ui-timepicker-input').spinner(opts, val);
                    return obj.find('.ui-timepicker-input').spinner(opts);
                },
                value: function(tp_inst, obj, unit, val){
                    if(val !== undefined)
                        return obj.find('.ui-timepicker-input').spinner('value', val);
                    return obj.find('.ui-timepicker-input').spinner('value');
                }
            };
            $('.datetimepicker').each(function(){
                $(this).datetimepicker({
                    controlType: myControl,
                    dateFormat: 'dd/mm/yy',
                    timeFormat: 'HH:mm',
                    onClose: function() {
                        var obj = $(this);
                        $.ajax({
                            method: 'GET',
                            url: '/backend/set-payout-transferred/' + $(this).data('order-id'),
                            data: {
                                transferred_on: $(this).val()
                            },
                            dataType: "json",
                            success: function (data) {
                                if(!data.error) {
                                    obj.attr('disabled', 'disabled');
                                }
                            },
                            failure: function (errMsg) {
                                alert(errMsg);
                            }
                        });
                    }
                });
            });
            $('#datetimepicker_slide').datetimepicker({
                addSliderAccess: true,
                sliderAccessArgs: { touchonly: false }
            });

            $('.edit-btn').click(function() {
                $(this).closest('.input-group').find('.datetimepicker').removeAttr('disabled');
            });
        });
    </script>
@stop
@section('content')

    <div id="manufacture">
        <div id="header-table-manufacture-detail" style="margin:0px 0 30px 0">
            <h3>{{ $title }}</h3>
        </div>
        <table id="table-manufacture-detail" class="table-radius">
            <thead>
            <tr>
                <th>รหัสสั่งซื้อ</th>
                <th>ชื่อผู้ใช้</th>
                <th>ชื่อบัญชี</th>
                <th>จำนวนเงิน</th>
                <th>ธนาคาร</th>
                <th>วันเวลาที่โอนเงิน</th>
            </tr>
            </thead>
            <tbody>
            @forelse($orders as $order)
                <tr class="">
                    <td><a href="{{ action('BackendController@getPaymentDetail', $order->id) }}">{{ str_pad($order->id, 6, 0, STR_PAD_LEFT) }}</a></td><td>{{ $order->user->full_name }}</td>
                    <td>{{ is_null($order->user->bank_account) ? '' : $order->user->bank_account->name }}</td>
                    <td>฿{{ number_format($order->payment->first()->total, 2) }}</td>
                    <td>{{ is_null($order->user->bank_account) ? '' : ($order->user->bank_account->bank_name . ' เลขที่ ' . $order->user->bank_account->no) }}</td>
                    <td width="20%">
                        @if(is_null($order->user->bank_account))
                            <p class="text-danger">ไม่มีข้อมูลบัญชีธนาคาร</p>
                        @elseif(count($order->payout) > 0)
                            <div class="input-group">
                                <input type="text" class="form-control datetimepicker" disabled data-order-id="{{ $order->id }}" value="{{ $order->payout->first()->transferred_on ? $order->payout->first()->transferred_on->format('d/m/Y H:i') : '' }}" placeholder="วันเวลาที่โอนเงินคืน">
                              <span class="input-group-btn">
                                <button class="btn btn-default edit-btn" type="button"><i class="fa fa-edit"></i>&nbsp;แก้ไข</button>
                              </span>
                            </div><!-- /input-group -->
                        @else
                            <div class="input-group">
                                <input type="text" class="form-control datetimepicker" data-order-id="{{ $order->id }}" placeholder="วันเวลาที่โอนเงินคืน">
                              <span class="input-group-btn">
                                <button class="btn btn-default edit-btn" type="button"><i class="fa fa-edit"></i>&nbsp;แก้ไข</button>
                              </span>
                            </div><!-- /input-group -->
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">
                        ไม่มีข้อมูลการคืนเงิน
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {!! str_replace('/?', '?', $orders->render()) !!}
    </div><!-- end manufacture -->
@stop
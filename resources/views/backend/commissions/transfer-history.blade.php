@extends('backend.layouts.master')
@section('css')
<link rel="stylesheet" href="{{ asset('js/timepicker/dist/jquery-ui-timepicker-addon.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/new-backend.css') }}">
<style>

</style>
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
                        url: '/backend/set-payout-transferred/' + $(this).data('payout-id'),
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
        $('table-manufacture-detail').tablesorter();
    });
</script>
@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"></h3>
            </div>
            <div class="box-body">
                <div class=" form-inline">
                    <div class="row">
                        <div class="col-sm-6 col-xs-6">
                            <div class="dataTables_length" id="example1_length">
                                <label>Show 
                                    <select name="example1_length" aria-controls="example1" class="form-control input-sm">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select> entries
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <div id="example1_filter" class="dataTables_filter">
                                <div class="pull-right">
                                    <label>
                                        <form action="">
                                            ค้นหา: <input type="text" class="form-control" name="q" placeholder="">
                                        </form>
                                    </label>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{ action('BackendController@getCampaign') }}">ทั้งหมด</a></li>
                                        @foreach(\App\CampaignStatus::all() as $campaign_status)
                                            <li>
                                                <a href="{{ action('BackendController@getCampaign', $campaign_status->name) }}">{{ $campaign_status->detail }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="table-manufacture-detail" class="table tablesorter table-bordered table-striped dataTable">
                    <thead>
                        <tr>
                            <th>รหัสยื่นคำขอโอนเงิน</th>
                            <th>วันส่งคำขอ</th>
                            <th>วันที่จ่ายรายได้</th>
                            <th>ชื่อ-นามสกุล</th>
                            <th>จำนวนเงิน</th>
                            <th>ธนาคารรับเงิน</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="clickable-row" data-href="{{ action('BackendController@getTransferDetail') }}">
                            <td>#000001</td>
                            <td>10/9/2558</td>
                            <td>10/10/2558</td>
                            <td>นายศักรินทร์ มีพวกมาก</td>
                            <td>฿1,900</td>
                            <td>ธนาคารกรุงไทย</td>
                        </tr>
                    </tbody>
                </table>
                <div class="div-pagination">
                    <div class="navbar-right">
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
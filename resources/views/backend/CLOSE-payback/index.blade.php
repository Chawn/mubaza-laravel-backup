@extends('backend.layouts.master')
@section('css')
<link rel="stylesheet" href="{{ asset('js/timepicker/dist/jquery-ui-timepicker-addon.min.css') }}">
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

$('.date-time').datetimepicker({
    controlType: myControl
});

        $('#datetimepicker_slide').datetimepicker({
            addSliderAccess: true,
            sliderAccessArgs: { touchonly: false }
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
                <th>แคมเปญ</th>
                <th>จำนวนเงิน</th>
                <th>ชื่อบัญชี</th>
                <th>ธนาคาร</th>
                <th>วันเวลาที่โอนเงิน</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach($materials as $material) --}}
            <tr class="">
                <td>000011</td>
                <td>Programmer Life</td>
                <td>฿250</td>
                <td>นายณรงค์ เดินลง</td>
                <td>กสิกรไทย</td>
                <td>14 ก.พ. 57 17:02 น. 
                    <button class="btn btn-sm btn-default">แก้ไข</button>
                </td>
            </tr>
            <tr class="">
                <td>000012</td>
                <td>Programmer Life</td>
                <td>฿500</td>
                <td>นายเมตตา มหาชัย</td>
                <td>ไทยพาณิชย์</td>
                <td>14 ก.พ. 57 17:02 น.
                    <button class="btn btn-sm btn-default">แก้ไข</button>
                </td>
            </tr>
            <tr class="">
                <td>000013</td>
                <td>Programmer Life</td>
                <td>฿250</td>
                <td>นายหลีกภัย สบายใจ</td>
                <td>กสิกรไทย</td>
                <td><input type="text" class="form-control date-time" id="datetimepicker" placeholder="วันเวลาที่โอนเงินคืน"></td>
            </tr>
            <tr class="">
                <td>000013</td>
                <td>Programmer Life</td>
                <td>฿250</td>
                <td>นายหลีกภัย สบายใจ</td>
                <td>กสิกรไทย</td>
                <td><input type="text" class="form-control date-time" id="datetimepicker" placeholder="วันเวลาที่โอนเงินคืน"></td>
            </tr>
            <tr class="">
                <td>000014</td>
                <td>Programmer Life</td>
                <td>฿250</td>
                <td>นายแมลงสาบ ชอบนอนหงาย</td>
                <td>-</td>
                <td><p class="text-danger">ไม่มีข้อมูลบัญชีธนาคาร</p></td>
            </tr>
            <!--end loop -->
            {{-- @endforeach --}}
        </tbody>
	</table>
       {{--  {!! str_replace('/?', '?', $campaigns->render()) !!} --}}
</div><!-- end manufacture -->
@stop
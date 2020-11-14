@extends('layouts.user-profile')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/user-account.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.fs.dropper.min.css') }}">
<style>
#user-account-contact {
	min-height: 300px;
    margin: 25px 0;
}
#user-header{
    display: none;
}
label{
	padding-right: 5px;
}

.modal-dialog {
    background: #fff;
    border-radius: 5px;
}
.modal-header {
    border-radius: 5px 5px 0 0;
}
.modal-body {
    text-align: center;
}
.modal-body img {
    width: 150px;
}
#show-qrcode img {
	width: 100%;
}
.wrapper {
	width: 300px;
	min-height: 150px;
}
@media (max-width: 480px){
    .wrapper{
        width: 100%;
        min-height: 100px;
        margin-top: 20px;
    }
    #show-qrcode img{
        width: 50%;
    }
}
</style>
@stop
@section('script')
<script src="{{ asset('js/jquery.fs.dropper.min.js') }}"></script>
<script src="{{ asset('js/profile.js') }}"></script>
<script>
$(document).ready(function(){

    $(".drop").dropper({
        action: $('.drop').data('url'),
        label: 'ลากและวางไฟล์ หรือ คลิกเพื่อเลือก',
        postData: {_token: $('.drop').data('token')}
    })
//                    .on("start.dropper", onStart)
        .on("complete.dropper", onComplete)
        .on("fileStart.dropper", onFileStart)
        .on("fileProgress.dropper", onFileProgress)
        .on("fileComplete.dropper", onFileComplete)
//                    .on("fileError.dropper", onFileError);

    function onFileStart() {
        $('.progress').addClass('show');
        $('.progress').removeClass('hide');
        $('.progress-bar').width('0%');
    }

    function onComplete() {
    }

    function onFileProgress(e, file, percent) {
        $('.progress-bar').width(percent + '%');
    }

    function onFileComplete(e, file, response) {
        $('.progress').addClass('hide');
        $('.progress').removeClass('show');
        console.log(response);
        if(response.error) {
            console.log(response);
        } else {
            document.location.reload();
        }
    }

    $('.btn-save').click(function() {
       save_profile($(this).data('input'));
    });

    var loadPicture = function(src) {
        console.log(src);
        $('#qr-code').attr('src', src);
        $('#show-qr-code').attr('src', src);
    }
})
</script>
@stop
@section('content')
<div class="box">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>เลขที่</th>
                <th>รายการ</th>
                <th>สถานะ</th>
                <th>แคมเปญ</th>
                <th>จำนวนเงิน</th>
                <th>วันที่</th>
                <th>บัญชีธนาคาร</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payouts as $payout)
            <tr>
                <td>
                    @if($payout->type->name == 'refund')
                    {{ is_null($payout->order_id) ? '-' : str_pad($payout->order->id, 6, 0, STR_PAD_LEFT) }}
                    @elseif($payout->type->name == 'profit')
                    #{{ str_pad($payout->campaign->id, 6, 0, STR_PAD_LEFT) }}
                    @endif
                </td>
                <td>{{ $payout->type->detail }}</td>
                <td>
                    {{ $payout->status->detail }}
                </td>
                <td>{{ $payout->campaign->title }}</td>
                <td>
                    @if($payout->type->name == 'refund')
                    {{ is_null($payout->order) ? '-' : '฿' . number_format($payout->order->payment->first()->total, 2) }}
                    @elseif($payout->type->name == 'profit')
                    {{ is_null($payout->campaign) ? '-' : '฿' . number_format($payout->campaign->totalProfit(), 2) }}
                    @endif
                </td>
                <td>{{ (is_null($payout->transferred_on)) ? '-' : $payout->transferred_on->format('d/m/Y H:i') }}</td>
                <td>{{ $payout->bank_name }}&nbsp;{{ $payout->bank_no }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7">ไม่พบรายการประวัติการเงิน</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="col-md-12">
   {!! str_replace('/?', '?', $payouts->render()) !!}
</div>   
<div id="modal-show-qrcodeline" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="qrcodeline" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-header">
            <h4 class="modal-title">QR Code ไลน์</h4>
        </div>
        <div class="modal-body">
            <img src="{{ url('/') . '/' . $user->profile->line_qr }}" id="qr-code">
        </div>
        <div class="modal-footer">
            <a href="{{ url('/') . '/' . $user->profile->line_qr }}" class="btn btn-success">บันทึก QR Code</a>
            <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
        </div>

    </div>
</div>
@stop
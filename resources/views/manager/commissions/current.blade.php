@extends('manager.layouts.master')
@section('script')
    <script src="{{ asset('js/validate/jquery.validate.min.js') }}"> </script>
    <script src="{{ asset('js/validate/additional-methods.min.js') }}"> </script>
    <script src="{{ asset('js/validate/localization/messages_th.min.js') }}"> </script>
    <script src="{{ asset('js/hashids.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#minimum-commission-form').validate({
                rules: {
                    minimum_commission: {
                        required: true,
                        min: 500
                    }
                },
                errorPlacement: function (error, element) {
                    // Append error within linked label
                    alert("จำนวนเงินต้องมากกว่าหรือเท่ากับ 500 บาท");
                    $(element).addClass('error');
                }
            });

            $('#save-btn').click(function() {
                if($('#minimum-commission-form').valid())
                {
                    $('#minimum-commission-form').submit();
                }
            });
        });
    </script>
@stop
@section('css')
    <style type="text/css" media="screen">
        .error {
            border: 1px solid #f00;
        }
    </style>
@stop
@section('content')
    <div class="box-blank">
        <div class="box-body">
            <table class="table table-bordered table-hover dataTable text-center">
                <thead>
                <tr>
                    <th>เดือน</th>
                    <th>ยอดเงิน</th>
                    <th>สถานะ</th>

                </tr>
                </thead>
                <tbody>
                @for($month = 0; $month < $diff_month; $month++)
                    <tr>
                        <td>
                            <a href="{{ action('AssociateController@getCommissionDetail') . '?start=' . \Carbon::now()->subMonth($month)->firstOfMonth()->format('d/m/Y') . '&end=' . \Carbon::now()->subMonth($month)->endOfMonth()->format('d/m/Y') }}"
                               title="">
                                <i class="fa fa-search"></i> {{ \Carbon::now()->subMonth($month)->format('F Y') }}
                            </a>
                        </td>
                        <td>{{ \CommissionService::sumCommission($user, \Carbon::now()->subMonth($month)->startOfMonth()->startOfDay(), \Carbon::now()->subMonth($month)->endOfMonth()->endOfDay()) }}</td>
                        <td>รอการตรวจสอบ</td>
                    </tr>
                @endfor
                @foreach($monthly_commissions as $monthly_commission)
                    <tr>
                        <td>
                            <a href="{{ action('AssociateController@getCommissionDetail') . '?start=' . $monthly_commission->start->format('d/m/Y') . '&end=' . $monthly_commission->end->format('d/m/Y') }}"
                               title="">
                                <i class="fa fa-search"></i> {{ $monthly_commission->start->format('F Y') }}
                            </a>
                        </td>
                        <td>{{ number_format($monthly_commission->total, 2) }}</td>
                        <td>{{ $monthly_commission->status->detail }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <br>
            <div class="row">
                <div class="col-sm-7">
                    <strong>เงื่อนไขและข้อตกลง</strong>
                    <ul>

                        <li>
                            <small>บริษัทจะตรวจสอบยอดขายของเดือนปัจจุบันทั้งหมด ในวันที่ 16 - 20 ในเดือนต่อไป</small>
                        </li>
                        <li>
                            <small>บริษัทจะโอนเงินให้คุณเมื่อมียอดเงินเท่ากับยอดเงินขั้นต่ำที่คุณกำหนด ในวันที่ 16 - 20  ของเดือน</small>
                        </li>
                        <li>
                            <small>บริษัทขอสงวนสิทธิ์ที่จะ<a href="#">หักค่าธรรมเนียมโอนเงิน</a>ออกจากยอดเงินส่วนแบ่งในรอบถัดไป
                            </small>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-5 ">
                    <div class="well">
                        <h2 class="text-center">
                            <small>จำนวนเงินรวม</small>
                            <span class="text-success">฿{{ number_format(\CommissionService::totalPendingCommission($user), 2) }}</span>
                        </h2>
                    </div>
                    <div>
                        ยอดเงินขั้นต่ำในการได้รับส่วนแบ่ง : <span>{{ number_format($user->affiliate->minimum_commission, 2) }}</span>
                        &nbsp;<a href="javascript:void(0)" data-toggle="modal" data-target="#modal-minimum-commission">ตั้งค่า</a>
                    </div>
                </div>
            </div>
        </div>
    <div class="box-blank">
        <div class="box-head">
            <h3>ประวัติการรับส่วนแบ่งรายได้</h3>
        </div>
        <div class="box-body">
            
                <table class="table table-bordered table-flex table-hover dataTable text-center">
                    <thead>
                        <tr>
                            <th>ช่วงเวลา</th>
                            <th>วันที่โอน</th>
                            <th>จำนวนเงิน</th>
                            <th>ค่าธรรมเนียมการโอน</th>
                            <th>รายละเอียด</th>
                            <th>สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(isset($user->payouts))
                        @foreach($user->payouts as $payout)
                            <tr>
                                <td data-label="ช่วงเวลา">
                                    {{ $payout->monthly_commissions->first()->start->format('j/n/Y') }} ถึง {{ $payout->monthly_commissions->last()->end->format('j/n/Y') }}
                                </td>
                                <td data-label="วันที่โอน">
                                    {{ $payout->status->name == 'paid' ? $payout->pay_on->format('j/n/Y H:i') : '-' }}
                                </td>
                                <td data-label="จำนวนเงิน">
                                    {{ number_format($payout->pay_total, 2) }}
                                </td>
                                <td data-label="ค่าธรรมเนียมการโอน">
                                    {{ number_format($payout->transfer_fee, 2) }}
                                </td>
                                <td data-label="รายละเอียด">
                                    {{ $payout->status->detail }}
                                </td>
                                <td data-label="สถานะ">
                                    <a href="" class="btn btn-success">
                                        <i class="fa fa-search"></i> ดูข้อมูล
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" rowspan="" headers="" style="text-align:center;">
                                    ยังไม่มีข้อมูล
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>

        </div>
    </div>
        <div class="modal fade" id="modal-minimum-commission">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">ตั้งค่ายอดเงินขั้นต่ำ</h4>
                    </div>
                    <div class="modal-body">
                        <form id="minimum-commission-form" method="POST" action="{{ action('AssociateController@postUpdateMinimumCommission', $user->affiliate->id) }}">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label for="total">จำนวนเงิน ขั้นต่ำ 500 บาท</label>
                                <input type="number" class="form-control" id="minimum-commission"
                                       name="minimum_commission" placeholder="จำนวนเงิน ขั้นต่ำ 500 บาท" min="500" value="{{ $user->affiliate->minimum_commission }}" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                        <button type="button" class="btn btn-primary" id="save-btn">บันทึก</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
@stop
@extends('backend.layouts.master')
@section('css')
<link rel="stylesheet" href="{{ asset('datetimepicker-master/jquery.datetimepicker.css') }}">
<link rel="stylesheet" href="{{ asset('css/new-backend.css') }}">
@stop
@section('script')
    <script src="{{ asset('datetimepicker-master/jquery.datetimepicker.js') }}"></script>
    <script>
        $(document).ready(function() {
            jQuery('#pay-on').datetimepicker({
                format: 'd/m/Y H:i',
                step: 1,
                inline: false,
                lang: 'th'
            });
        });
    </script>
@stop
@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="box">
                <div class="box-header">
                    <div class="box-title">
                        <h3 class="box-title">รายการจ่ายเงิน {{ $payout ? '#' . str_pad($payout->id, 6, 0, STR_PAD_LEFT) : '' }}</h3>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <b>ข้อมูลการติดต่อ</b>
                            <br>ชื่อ-นามสกุล(จริง):&nbsp;{{ $user->full_name }}
                            <br>ชื่อที่ใช้แสดง:&nbsp;<a href="#">{{ $user->username }}</a>
                            <br>เบอร์โทร:&nbsp;{{ $user->profile->phone }}
                            <br>อีเมลล์:&nbsp;{{ $user->email }}
                        </div>

                        <div class="col-sm-6">
                            @if($payout)
                                <strong>วันที่อนุมัติ:&nbsp;{{ $payout->created_at->format('d/m/Y') }}</strong>
                                @endif
                        </div>
                    </div>
                    <br>
                    <div class="well">
                        <div class="row">
                            <div class="col-sm-6">
                                <br>
                                <h1 class="text-center">
                                    <small>จำนวนเงิน</small> {{ number_format($total_pending, 2) }} บาท
                                </h1>
                            </div>
                            <div class="col-sm-6">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <strong class="text-info">ช่วงเวลา: </strong>
                                        {{ $start->format('d/m/Y') }} - {{ $end->format('d/m/Y') }}
                                    </li>
                                    <li class="list-group-item">
                                        <strong class="text-info">ส่วนแบ่งรายได้: </strong> {{ number_format($total_commission, 2) }}
                                        บาท<br>
                                    </li>
                                    {{--<li class="list-group-item">--}}
                                        {{--<strong class="text-info">ภาษีหัก ณ ที่จ่าย (7%): </strong> 0 บาท<br>--}}
                                    {{--</li>--}}
                                    <li class="list-group-item">
                                        <strong class="text-info">หักเงินจากการคืนสินค้า: </strong> {{ number_format($return_commission, 2) }} บาท<br>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <h3>ประวัติการขาย</h3>
                    <table id="table-profit-detail" class="table tablesorter table-bordered table-striped dataTable">
                        <thead>
                        <tr>
                            <th>รหัสสั่งซื้อ</th>
                            <th>ชื่อสินค้า</th>
                            <th>ราคา</th>
                            <th>จำนวน</th>
                            <th>รวม</th>
                            <th>ส่วนแบ่งครีเอเตอร์</th>
                            <th>ส่วนแบ่งนักขาย</th>
                            <th>วันที่</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order_items as $order_item)
                            <tr>
                                <td><a href="{{ action('BackendController@getOrderDetail', $order_item->order_id) }}"
                                       target="_blank">{{ $order_item->order_id }}</a></td>
                                <td>
                                    <a href="{{ action('CampaignController@showCampaign', $order_item->campaign->url) }}"
                                       target="_blank">{{ $order_item->campaign->title }}</a></td>
                                <td>{{ number_format($order_item->price, 2) }}</td>
                                <td>{{ $order_item->qty }}</td>
                                <td>{{ number_format($order_item->total(), 2) }}</td>
                                <td>{{ number_format($order_item->creatorCommission($user->id), 2) }}</td>
                                <td>{{ number_format($order_item->affiliateCommission($user->affiliate->id), 2) }}</td>
                                <td>{{ $order_item->approved_at->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <h3>รายการคืนสินค้า</h3>
                    <table id="table-profit-detail" class="table tablesorter table-bordered table-striped dataTable">
                        <thead>
                        <tr>
                            <th>รหัสสั่งซื้อ</th>
                            <th>ชื่อสินค้า</th>
                            <th>ราคา</th>
                            <th>จำนวน</th>
                            <th>รวม</th>
                            <th>ส่วนแบ่งครีเอเตอร์</th>
                            <th>ส่วนแบ่งนักขาย</th>
                            <th>วันที่</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($return_items as $return_item)
                            <tr>
                                <td><a href="{{ action('BackendController@getOrderDetail', $return_item->order_item->order_id) }}"
                                       target="_blank">{{ $return_item->order_item->order_id }}</a></td>
                                <td>
                                    <a href="{{ action('CampaignController@showCampaign', $return_item->order_item->campaign->url) }}"
                                       target="_blank">{{ $return_item->order_item->campaign->title }}</a></td>
                                <td>{{ number_format($return_item->order_item->price, 2) }}</td>
                                <td>{{ $return_item->order_item->qty }}</td>
                                <td>{{ number_format($return_item->order_item->total(), 2) }}</td>
                                <td>{{ number_format($return_item->order_item->creatorCommission($user->id), 2) }}</td>
                                <td>{{ number_format($return_item->order_item->affiliateCommission($user->affiliate->id), 2) }}</td>
                                <td>{{ $return_item->order_item->approved_at->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <hr>
                </div>
            </div>
            <div class="box">
            </div>
        </div>
        <div class="col-md-3">
            <div class="box">
                <div class="box-header">
                    <div class="box-title">
                        <h3 class="box-title"></h3>
                    </div>
                </div>
                <div class="box-body">
                    <button class="btn btn-default-shadow btn-block btn-lg">
                        <i class="fa fa-print"></i>
                        พิมพ์รายงานการยื่นขอ
                    </button>
                    <br>
                    <button class="btn btn-default-shadow btn-block btn-lg">
                        <i class="fa fa-print"></i>
                        พิมพ์รายงานการขายทั้งหมด
                    </button>
                    <br>
                    @if($payout)
                        @if($payout->status->name == 'approved')
                        <button class="btn btn-success btn-lg btn-block" data-toggle="modal"
                                data-target="#modal-profit-detail">
                            <i class="fa fa-check"></i> โอนเงิน
                        </button>
                        @elseif($payout->status->name == 'paid')
                            <button class="btn btn-warning btn-lg btn-block" data-toggle="modal"
                                    data-target="#modal-confirm-reset">
                                <i class="fa fa-times"></i> ยกเลิกข้อมูลการโอนเงิน
                            </button>
                        @endif
                    @else
                    <a href="{{ action('BackendController@getApproveCommission', $user->id) }}"
                       class="btn btn-success btn-lg btn-block"><i class="fa fa-check"></i> อนุมัติ</a>
                    @endif
                    <br>
                </div>
            </div>
        </div>
    </div>
    @if($payout)
        @if($payout->status->name == 'approved')
    <div id="modal-profit-detail" class="modal fade">
        <div class="modal-dialog">
            <form class="form-horizontal" method="post"
                  action="{{ action('BackendController@postUpdatePayout', $payout->id) }}">
                {!! csrf_field() !!}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4>กรอกรายละเอียดการโอนเงิน</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="mbank">โอนจาก</label>
                            <div class="col-sm-8">
                                <select name="from_bank" id="mbank" class="form-control">
                                    <option value="ธนาคารกรุงเทพ">ธนาคารกรุงเทพ</option>
                                    <option value="ธนาคารกสิกรไทย">ธนาคารกสิกรไทย</option>
                                    <option value="ธนาคารกรุงไทย">ธนาคารกรุงไทย</option>
                                    <option value="ธนาคารทหารไทย">ธนาคารทหารไทย</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="bank-name">ธนาคารที่โอนเข้า</label>
                            <div class="col-sm-8">
                                <input type="text" id="bank-name" class="form-control" placeholder="ธนาคารที่โอนเข้า"
                                       value="{{ $user->bank_account->bank_name }}" name="bank_name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="bank-account-name">ชื่อบัญชี</label>
                            <div class="col-sm-8">
                                <input type="text" id="bank-account-name" class="form-control" placeholder="ชื่อบัญชี"
                                       value="{{ $user->bank_account->name }}" name="bank_account_name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="bank-id">เลขที่บัญชี</label>
                            <div class="col-sm-8">
                                <input type="text" id="bank-id" class="form-control" placeholder="เลขที่บัญชี"
                                       value="{{ $user->bank_account->no }}" name="bank_id" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="bank-branch">สาขา</label>
                            <div class="col-sm-8">
                                <input type="text" id="bank-branch" class="form-control" placeholder="สาขา"
                                       value="{{ $user->bank_account->branch }}" name="bank_branch" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="transfer-fee">ค่าธรรมเนียนการโอนเงิน</label>
                            <div class="col-sm-8">
                                <input type="number" id="transfer-fee" class="form-control"
                                       placeholder="ค่าธรรมเนียนการโอนเงิน"
                                       value="{{ number_format($total_pending, 2) }}" name="transfer_fee" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="pay-total">จำนวนเงินจ่าย</label>
                            <div class="col-sm-8">
                                <input type="number" id="pay-total" class="form-control" placeholder="จำนวนเงินจ่าย"
                                       value="{{ number_format($total_pending, 2) }}" name="pay_total" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="pay-on">วัน-เวลา ที่โอน</label>
                            <div class="col-sm-8">
                                <input type="text" id="pay-on" class="form-control" name="pay_on" required>
                            </div>
                        </div>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary" >ยืนยัน</button>
                </div>
            </div>
            </form>
        </div>
    </div>
        @elseif($payout->status->name == 'paid')
        <div id="modal-confirm-reset" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4>ยืนยัน</h4>
                    </div>
                    <div class="modal-body">
                        <h4>ยืนยันการยกเลิกข้อมูลการโอนเงิน</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                        <a href="{{ action('BackendController@getResetPayoutTransfer', $payout->id) }}" class="btn btn-primary">ยืนยัน</a>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endif
    {{--<div id="modal-auth-staff" class="modal fade">--}}
        {{--<div class="modal-dialog">--}}
            {{--<div class="modal-content">--}}
                {{--<div class="modal-header">--}}
                    {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span--}}
                                {{--aria-hidden="true">&times;</span></button>--}}
                    {{--<h4>กรอกรหัสพนักงานเพื่อยืนยัน</h4>--}}
                {{--</div>--}}
                {{--<div class="modal-body">--}}
                    {{--<input type="text" class="form-control">--}}
                {{--</div>--}}
                {{--<div class="modal-footer">--}}
                    {{--<button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>--}}
                    {{--<button class="btn btn-primary">ยืนยัน</button>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

@stop
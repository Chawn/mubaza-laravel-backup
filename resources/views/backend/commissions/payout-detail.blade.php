@extends('backend.layouts.master')
<link rel="stylesheet" href="{{ asset('css/new-backend.css') }}">
@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="box">
                <div class="box-header">
                    <div class="box-title">
                        <h3 class="box-title">รายการจ่ายเงิน #{{ str_pad($payout->id, 6, 0, STR_PAD_LEFT) }}</h3>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <b>ข้อมูลการติดต่อ</b>
                            <br>ชื่อ-นามสกุล(จริง):&nbsp;{{ $payout->user->full_name }}
                            <br>ชื่อที่ใช้แสดง:&nbsp;<a href="#">{{ $payout->user->username }}</a>
                            <br>เบอร์โทร:&nbsp;{{ $payout->user->profile->phone }}
                            <br>อีเมลล์:&nbsp;{{ $payout->user->email }}
                        </div>

                        <div class="col-sm-6">
                            <strong>วันที่อนุมัติ:&nbsp;</strong>{{ $payout->created_at->format('d/m/Y') }}
                        </div>
                    </div>
                    <br>
                    <div class="well">
                        <div class="row">
                            <div class="col-sm-6">
                                <br>
                                <h1 class="text-center">
                                    <small>จำนวนเงิน</small> {{ number_format($payout->total, 2) }} บาท
                                </h1>
                            </div>
                            <div class="col-sm-6">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <strong class="text-info">ช่วงเวลา: </strong>
                                        {{ $payout->start->format('d/m/Y') }} - {{ $payout->end->format('d/m/Y') }}
                                    </li>
                                    <li class="list-group-item">
                                        <strong class="text-info">ส่วนแบ่งรายได้: </strong> {{ number_format($payout->total, 2) }}
                                        บาท<br>
                                    </li>
                                    <li class="list-group-item">
                                        <strong class="text-info">ภาษีหัก ณ ที่จ่าย (7%): </strong> 0 บาท<br>
                                    </li>
                                    <li class="list-group-item">
                                        <strong class="text-info">หักค่าบริการโอนเงิน: </strong> 0 บาท<br>
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
                                <td>{{ number_format($order_item->creatorCommission($payout->user->id), 2) }}</td>
                                <td>{{ number_format($order_item->affiliateCommission($payout->user->affiliate->id), 2) }}</td>
                                <td>{{ $order_item->approved_at->format('d/m/Y') }}</td>
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

                    <button class="btn btn-success btn-lg btn-block" data-toggle="modal"
                            data-target="#modal-profit-detail">
                        <i class="fa fa-check"></i> อนุมัติ
                    </button>
                    <br>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-profit-detail" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4>กรอกรายละเอียดการโอนเงิน</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">โอนจาก</label>
                            <div class="col-sm-9">
                                <select name="from_bank" id="mbank" class="form-control">
                                    <option value="bangkokbank">ธนาคารกรุงเทพ</option>
                                    <option value="kbank">ธนาคารกสิกรไทย</option>
                                    <option value="ktb">ธนาคารกรุงไทย</option>
                                    <option value="tmb">ธนาคารทหารไทย</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="bank-name">ธนาคารที่โอนเข้า</label>
                            <div class="col-sm-9">
                                <input type="text" id="bank-name" class="form-control" placeholder="ธนาคารที่โอนเข้า"
                                       value="{{ $payout->user->bank_account->bank_name }}" id="bank_name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="bank-id">เลขที่บัญชี</label>
                            <div class="col-sm-9">
                                <input type="text" id="bank-id" class="form-control" placeholder="เลขที่บัญชี"
                                       value="{{ $payout->user->bank_account->no }}" name="bank_id" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="bank-branch">สาขา</label>
                            <div class="col-sm-9">
                                <input type="text" id="bank-branch" class="form-control" placeholder="สาขา"
                                       value="{{ $payout->user->bank_account->branch }}" name="bank_branch" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="pay-total">จำนวนเงิน</label>
                            <div class="col-sm-9">
                                <input type="number" id="pay-total" class="form-control" placeholder="จำนวนเงิน"
                                       value="{{ $payout->total }}" name="total" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="pay-on-date">วันที่</label>
                            <div class="col-sm-9">
                                <input type="date" id="pay-on-date" class="form-control" name="pay_on_date" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="pay-on-time">เวลา</label>
                            <div class="col-sm-9">
                                <input type="time" id="pay-on-time" class="form-control" name="pay_on_time" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">ไฟล์แนบ</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="file" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                    <a type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal"
                       data-target="#modal-auth-staff">ยืนยัน</a>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-auth-staff" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4>กรอกรหัสพนักงานเพื่อยืนยัน</h4>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                    <button class="btn btn-primary">ยืนยัน</button>
                </div>
            </div>
        </div>
    </div>
@stop
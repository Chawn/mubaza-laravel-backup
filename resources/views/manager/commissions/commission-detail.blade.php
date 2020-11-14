@extends('manager.layouts.master')
@section('content')
    <div class="box-blank">
        <div class="box-body">
            <table class="table table-bordered table-flex table-hover dataTable text-center">
                <thead>
                <tr>
                    <th>id</th>
                    {{--<th>affiliate id</th>--}}
                    <th width="35%">ชื่อสินค้า</th>
                    <th width="10%">ราคา</th>
                    <th width="10%">จำนวน</th>
                    <th width="15%">รวม</th>
                    <th width="15%">ส่วนแบ่ง Affiliate</th>
                    <th width="15%">ส่วนแบ่ง Artist</th>
                </tr>
                </thead>
                <tbody>
                {{-- */$total=0;/* --}}
                @foreach($items as $item)
                    {{-- */$total+=$item->total();/* --}}
                    <tr>
                        <td >{{ $item->id }}</td>
                        {{--<td>{{ $item->affiliate_id }}</td>--}}
                        <td data-label="ชื่อสินค้า">
                            <a href="{{ action('CampaignController@showCampaign', $item->campaign->url) }}" title="{{ $item->campaign->title }}">{{ $item->campaign->title }}
                            </a>
                        </td>
                        <td data-label="ราคา">฿{{ number_format($item->price, 2) }}</td>
                        <td data-label="จำนวน">
                            {{ $item->qty }}</td>
                        <td data-label="รวม">฿{{ number_format($item->total(), 2) }}</td>
                        <td data-label="ส่วนแบ่ง Affiliate">
                            ฿{{ $item->affiliateCommission(\Auth::user()->user()->affiliate->id) }}</td>
                        <td data-label="ส่วนแบ่ง Artist">
                            ฿{{ $item->creatorCommission(\Auth::user()->user()->id) }}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="4"><p class="text-right">
                            <strong>Sub Total:</strong>
                        </p></td>
                    <td>฿{{ number_format($total, 2) }}</td>
                    <td>฿{{ number_format($total_affiliate_commission, 2) }}</td>
                    <td>฿{{ number_format($total_creator_commission, 2) }}</td>
                </tr>
                </tfoot>
            </table>
            <br>

        </div>
    </div>
@stop
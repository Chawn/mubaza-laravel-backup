@extends('manager.layouts.master')
@section('script')
    <script src="{{ asset('js/hashids.min.js') }}"></script>
    <script>
    </script>
@stop
@section('css')
    <style type="text/css" media="screen">
       
    </style>
@stop
@section('content')
<div class="box-blank">
    <div class="box-body">
    <table class="table table-bordered table-hover dataTable text-center">
        <thead>
            <tr>
                <th>วันที่</th>
                <th>จำนวนสินค้า Affiliate</th>
                <th>ยอดขาย Affiliate</th>
                <th>จำนวนสินค้า Artist</th>
                <th>ยอดขาย Artist</th>
                <th>ส่วนแบ่ง Affiliate</th>
                <th>ส่วนแบ่ง Artist</th>
            </tr>
        </thead>
        <tbody>
            @for($day = 0;$day <= $diff_days;$day++)
            <tr>
                <td>
                    <a href="{{ action('AssociateController@getCommissionDetail') . '?date=' . \Carbon::now()->subDays($day)->format('d/m/Y') }}" title="">
                        <i class="fa fa-search"></i>{{ \Carbon::now()->subDays($day)->format('d/m/Y') }}
                    </a>
                </td>
                <td>{{ $affiliate->getTotalAffiliateItemQuantity(\Carbon::today()->subDays($day), \Carbon::today()->subDays($day)->addHours(24)) }}</td>
                <td>฿{{ $affiliate->getTotalAffiliateItemSell(\Carbon::today()->subDays($day), \Carbon::today()->subDays($day)->addHours(24)) }}</td>
                <td>{{ $affiliate->getTotalDesignItemQuantity(\Carbon::today()->subDays($day), \Carbon::today()->subDays($day)->addHours(24)) }}</td>
                <td>฿{{ $affiliate->getTotalDesignItemSell(\Carbon::today()->subDays($day), \Carbon::today()->subDays($day)->addHours(24)) }}</td>
                <td>฿{{ $affiliate->getTotalAffiliateCommission(\Carbon::today()->subDays($day), \Carbon::today()->subDays($day)->addHours(24)) }}</td>
                <td>฿{{ $affiliate->getTotalDesignCommission(\Carbon::today()->subDays($day), \Carbon::today()->subDays($day)->addHours(24)) }}</td>
            </tr>
                @endfor
        </tbody>
        <tfoot>
        <tr>
            <td colspan="5"><p class="text-right">
                    <strong>Sub Total:</strong>
                </p></td>
            <td>฿0</td>
            <td>฿88</td>
        </tr>
        </tfoot>
    </table>    
    <br>
    <div class="row">
        <div class="col-sm-7">
            <strong>เงื่อนไขและข้อตกลง</strong>
            <ul>
                
                <li>
                    <small>คุณสามารถยื่นคำขอโอนเงินได้ เมื่อมีเงินส่วนแบ่งมากกว่า 500 บาท</small>
                </li>
                <li>
                    <small>บริษัทจะโอนเงินให้คุณภายใน 45 วัน นับจากวันที่ยื่นคำขอโอนเงิน</small>
                </li>
                <li>
                    <small>จะโอนเงินเป็นยอดเงินที่<a href="#">หักค่าธรรมเนียมโอนเงิน</a>ออกจากยอดเงินส่วนแบ่ง</small>
                </li>
            </ul>
        </div>    
        <div class="col-sm-5 ">
            <div class="well">
                <h2 class="text-center">
                    <small>จำนวนเงินรับ </small>
                    <span class="text-success">฿88</span> 
                </h2>
                <p class="text-center">
                    <strong class="text-info">ช่วงเวลา: </strong>
                    30/12/2557 - 30/12/2558
                </p>
            </div>
            <button class="btn btn-default disabled btn-xl btn-block">ยื่นคำขอโอนเงิน</button>
            <br>
            
        </div>

    </div>
</div>
@stop
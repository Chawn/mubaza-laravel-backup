<html>
<head>
    <title></title>
    <style>
        .containerDiv {
            border: 1px solid #3697f6;
            width: 100%;
            display: table
        }

        .containerDiv2 {
            border: 1px solid #3697f6;
            width: 50%;
            display: table
        }

        .rowDivHeader {
            border: 1px solid #668db6;
            background-color: #336799;
            color: white;
            font-weight: bold;
            display: table-row
        }

        .rowDiv {
            border: 1px solid #668db6;
            background-color: #cee6fe;
            display: table-row
        }

        .cellDivHeader {
            border-right: 1px solid white;
            display: table-cell;
            width: 12%;
            padding: 1px;
            text-align: center;
        }

        .cellDiv {
            border-right: 2px solid white;
            display: table-cell;
            width: 10%;
            padding-right: 4px;
            text-align: center;
            border-bottom: none;
        }

        .lastCell {
            border-right: none;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Coupon {{@$id}}</h1>
</div>
<div class="containerDiv2">
    <div class="rowDiv">
        <div class="cellDivHeader">ชื่อคูปอง</div>
        <div class="cellDiv">{{$coupon->coupon_name}}</div>
    </div>
    <div class="rowDiv">
        <div class="cellDivHeader">Code</div>
        <div class="cellDiv">{{$coupon->coupon_code}}</div>
    </div>
    <div class="rowDiv">
        <div class="cellDivHeader">รายละเอียด</div>
        <div class="cellDiv">{{$coupon->coupon_detail}}</div>
    </div>
    <div class="rowDiv">
        <div class="cellDivHeader">ส่วนลด</div>
        <div class="cellDiv">
            {{$coupon->coupon_discount_number}}
            @if($coupon->coupon_discount_type === 'price')
                บาท
            @else
                %
            @endif
        </div>
    </div>
    <div class="rowDiv">
        <div class="cellDivHeader">ราคาขั้นต่ำ</div>
        <div class="cellDiv">{{ $coupon->coupon_condition_at_least_price_flag == 'yes' ? $coupon->coupon_condition_at_least_price : '-'}}</div>
    </div>
    <div class="rowDiv">
        <div class="cellDivHeader">วันที่</div>
        <div class="cellDiv">{{ $coupon->coupon_condition_end_date_flag == 'yes' ? $coupon->coupon_condition_end_date : '-'}}</div>
    </div>
    <div class="rowDiv">
        <div class="cellDivHeader">จำนวนการใช้งานต่อ user</div>
        <div class="cellDiv">{{ $coupon->coupon_condition_max_use_per_user_flag == 'yes' ? $coupon->coupon_condition_max_use_per_user : '-'}}</div>
    </div>
    <div class="rowDiv">
        <div class="cellDivHeader">จำนวน user ที่สามารถใช้ได</div>
        <div class="cellDiv">{{ $coupon->coupon_condition_max_user_flag == 'yes' ? $coupon->coupon_condition_max_user : '-'}}</div>
    </div>
    <div class="rowDiv">
        <div class="cellDivHeader">สถานะ</div>
        <div class="cellDiv">{{$coupon->status}}</div>
    </div>
</div>
<br/>
<br/>
<div class="container">
    <h1>User using</h1>
</div>
<div class="containerDiv">
    <div class="rowDivHeader">
        <div class="cellDivHeader">ID</div>
        <div class="cellDivHeader">วันที่</div>
        <div class="cellDivHeader">user_id</div>
        <div class="cellDivHeader">order_id</div>
        <div class="cellDivHeader">ส่วนลด</div>
        <div class="cellDivHeader">ยอดสุทธิ</div>
        <div class="cellDivHeader">สถานะ</div>
    </div>
    @foreach($redeemCoupons as $redeemCoupon)
        <div class="rowDiv">
            <div class="cellDiv">{{$redeemCoupon->id}}</div>
            <div class="cellDiv">{{$redeemCoupon->created_at}}</div>
            <div class="cellDiv">{{$redeemCoupon->user->full_name}}</div>
            <div class="cellDiv">{{$redeemCoupon->order_id}}</div>
            <div class="cellDiv">{{$redeemCoupon->order->coupon_discount_total}}</div>
            <div class="cellDiv">{{$redeemCoupon->order->net_price_total}}</div>
            <div class="cellDiv">{{$redeemCoupon->redeem_status}}</div>
        </div>
    @endforeach
</div>
</body>
</html>
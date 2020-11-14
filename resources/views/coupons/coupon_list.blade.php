<html>
<head>
    <title></title>
    <style>
        .containerDiv {
            border: 1px solid #3697f6;
            width: 100%;
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

        form {
            float: right;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>All coupon</h1>
</div>
<div class="container">
    <h4><a href="/coupon/create">Create</a></h4>
</div>
<div class="containerDiv">

    <div class="rowDivHeader">
        <div class="cellDivHeader">ID</div>
        <div class="cellDivHeader">Actions</div>
        <div class="cellDivHeader">Status</div>
        <div class="cellDivHeader">ชื่อคูปอง</div>
        <div class="cellDivHeader">Code</div>
        <div class="cellDivHeader">รายละเอียด</div>
        <div class="cellDivHeader">ส่วนลด</div>
        <div class="cellDivHeader">ราคาขั้นต่ำ(บาท)</div>
        <div class="cellDivHeader">วันที่สิ้นสุด</div>
        <div class="cellDivHeader">จำนวนการใช้งานต่อ user</div>
        <div class="cellDivHeader">จำนวน user ที่สามารถใช้ได้</div>
    </div>
    @foreach ($coupons as $coupon)
        <div class="rowDiv">
            <div class="cellDiv">{{ $coupon->id }}</div>
            <div class="cellDiv">
                <input type="button" value="Edit" onclick="location.href='/coupon/edit/{{ $coupon->id }}'"/>
                <form action="/coupon/delete/{{ $coupon->id }}" method="POST"
                      onSubmit="if(!confirm('Confirm?')){return false;}">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="submit" value="Delete"/>
                </form>
            </div>
            <div class="cellDiv">{{ $coupon->status }}</div>
            <div class="cellDiv">
                <a href="/coupon/detail/{{$coupon->id}}">{{ $coupon->coupon_name }}</a>
            </div>
            <div class="cellDiv">{{ $coupon->coupon_code }}</div>
            <div class="cellDiv">{{ $coupon->coupon_detail }}</div>
            <div class="cellDiv">{{ $coupon->coupon_discount_number }}
                @if($coupon->coupon_discount_type === 'price')
                    บาท
                @else
                    %
                @endif
            </div>
            <div class="cellDiv">
                @if($coupon->coupon_condition_at_least_price_flag === 'yes')
                    {{$coupon->coupon_condition_at_least_price}} <br/>
                @else
                    -
                @endif
            </div>
            <div class="cellDiv">
                @if($coupon->coupon_condition_end_date_flag === 'yes')
                    {{$coupon->coupon_condition_end_date}} <br/>
                @else
                    -
                @endif
            </div>
            <div class="cellDiv">
                @if($coupon->coupon_condition_max_use_per_user_flag === 'yes')
                    {{$coupon->coupon_condition_max_use_per_user}} <br/>
                @else
                    -
                @endif
            </div>
            <div class="cellDiv">
                @if($coupon->coupon_condition_max_user_flag === 'yes')
                    {{$coupon->coupon_condition_max_user}} <br/>
                @else
                    -
                @endif
            </div>
        </div>
    @endforeach

</div>
</body>
</html>
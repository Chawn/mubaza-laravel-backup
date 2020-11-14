<html>
<head>
    <title></title>
    <style>
        .containerDiv {
            border: 1px solid #3697f6;
            width: 30%;
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
            width: 4%;
            padding: 1px;
            text-align: right;
        }

        .cellDiv {
            border-right: 2px solid white;
            display: table-cell;
            width: 10%;
            padding-right: 4px;
            text-align: left;
            border-bottom: none;
        }

        .lastCell {
            border-right: none;
        }

    </style>
</head>
<body>
<div class="container">
    <h1>Order {{@$id}} success</h1>
</div>
<div class="containerDiv">
    <div class="rowDiv">
        <div class="cellDivHeader">Order total</div>
        <div class="cellDiv">{{$order->before_discount_price_total}}</div>
    </div>
    <div class="rowDiv">
        <div class="cellDivHeader">Coupon discount</div>
        <div class="cellDiv">{{$order->coupon_discount_total}}</div>
    </div>
    <div class="rowDiv">
        <div class="cellDivHeader">Total net</div>
        <div class="cellDiv">{{$order->net_price_total}}</div>
    </div>
</div>
</body>
</html>
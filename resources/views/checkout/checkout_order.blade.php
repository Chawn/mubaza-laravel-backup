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
            width: 2%;
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
    <script type="text/javascript">
        function OnSubmit(type, id) {
            var form = document.getElementById('form');
            if (type.indexOf('check') > -1) {
                // check code
            } else {
                // submit order
                form.setAttribute("action", "/checkout/submit/order");
            }
            form.submit();
            return false;
        }
    </script>
</head>
<body>
<div class="container">
    <h1>Order</h1>
</div>

<div class="containerDiv">{{$msg}}</div>
<br/>
<div class="containerDiv">
    <form id="form" method="POST">
        <input type="hidden" name="_method" value="POST"/>
        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

        <div class="rowDiv">
            <div class="cellDivHeader">user id</div>
            <div class="cellDiv">
                <input type="text" name="userId" value="{{$userId}}"/>
            </div>
        </div>
        <div class="rowDiv">
            <div class="cellDivHeader">Order total</div>
            <div class="cellDiv">
                <input type="text" name="totalPrice" value="{{$totalPrice}}"/>
            </div>
        </div>
        <div class="rowDiv">
            <div class="cellDivHeader">Coupon code</div>
            <div class="cellDiv">
                <input type="text" name="couponCode" VALUE="{{@$couponCode}}"/>
                <input type="button" value="Check" onclick="return OnSubmit('check')"/>
            </div>
        </div>
        <div class="rowDiv">
            <div class="cellDivHeader">Discount</div>
            <div class="cellDiv">{{@$discount}}</div>
        </div>
        <div class="rowDiv">
            <div class="cellDivHeader">Net price</div>
            <div class="cellDiv">{{@$netPrice}}</div>
        </div>

        <div class="rowDiv">
            <div class="cellDivHeader"></div>
            <div class="cellDiv">
                <br/>
                <br/>
                <input type="button" value="Submit" onclick="return OnSubmit('submitorder')"/>
            </div>
        </div>
    </form>
</div>
</body>
</html>
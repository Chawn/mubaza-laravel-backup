<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style>
        body {
            font-family: helvetica, arial, 'lucida grande', sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        th {
            border-bottom: 1px solid black;
            border-left: 1px solid black;
            border-top: 1px solid black;
        }

        th:last-child {
            border-right: 1px solid black;
        }

        td {
            border-bottom: 1px solid black;
            border-left: 1px solid black;
        }

        td:last-child {
            border-right: 1px solid black;
        }
    </style>
</head>
<body>
<h3>ใบเช็ครายการสินค้า Campaign&nbsp;:&nbsp;{{ str_pad($campaign->id, 6, '0', STR_PAD_LEFT)}}
    &nbsp;{{ $campaign->title }}&nbsp;พิมพ์เมื่อ&nbsp;วันที่&nbsp;{{ Date::now()->format('d/m/Y H:i:s') }}</h3>
<table width="100%" cellpadding="10" cellspacing="0">
    <thead>
    <tr>
        <th width="13%">เลขที่สั่งซื้อ</th>
        <th>ชื่อผู้รับ</th>
        <th>รายการสินค้า</th>
        <th width="10%">จำนวน</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    {{--*/ $row = 0 /*--}}
    @foreach($campaign->orders as $order)
        @if($order->payment_status->name == 'paid')
            <tr valign="top">
                <td rowspan="{{ count($order->allItems) }}">{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                <td rowspan="{{ count($order->allItems) }}">{{ $order->shipping_address->full_name}}</td>
                @foreach($order->allItems as $id => $item)
                    {{--*/ $row++ /*--}}
                    @if($id == 0)
                        <td>{{ $item->item->product->name }}&nbsp;/&nbsp;{{ $item->size }}
                            &nbsp;/&nbsp;{{ $item->item->product_image->color_name }}</td>
                        <td align="center">{{ $item->qty }}</td>
                        <td></td>
            </tr>
        @else
            <tr>
                <td>{{ $item->item->product->name }}&nbsp;/&nbsp;{{ $item->size }}
                    &nbsp;/&nbsp;{{ $item->item->product_image->color_name }}</td>
                <td align="center">{{ $item->qty }}</td>
                <td></td>
            </tr>
        @endif

        @if(($row % 24) == 0)
    </tbody>
</table>
<br/>
<br/>
<br/>
<table width="100%" cellpadding="10" cellspacing="0">
    <thead>
    <tr>
        <th width="13%">เลขที่สั่งซื้อ</th>
        <th>ชื่อผู้รับ</th>
        <th>รายการสินค้า</th>
        <th width="10%">จำนวน</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    @endif
    @endforeach
    @endif
    @endforeach

    </tbody>
</table>
</body>
</html>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>พิมพ์ใบปะหน้าซอง</title>
    <link rel="stylesheet" href="{{ asset('css/print-customer-address.css') }}">
    <link rel="stylesheet" href="{{ asset('datetimepicker/jquery.datetimepicker.css') }}"/>
    <script src="{{ asset('jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery-barcode.js') }}"></script>
    <script src="{{ asset('js/jquery.qrcode.min.js') }}"></script>
    <script src="{{ asset('datetimepicker/jquery.datetimepicker.js') }}"></script>
    <style>
        body {
            font-family: 'Tahoma';
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .page {
            width: 974px;
            height: 675px;
            /*
            max-height: 1376px;
            */
            border-spacing: 0px;
            border-bottom: 1px solid #ddd;
        }

        .page td {
            width: 487px;
            /*
            height: 675px;
            */
            vertical-align: top;
            padding: 5px;
        }

        .bottom {
            vertical-align: bottom !important;
            height: 160px;
        }

        @media all {
            .page-break {
                display: none;
            }
        }

        @media print {
            .page-break {
                display: block;
                height: 1px;
                page-break-after: always;
            }
            #select-date, .link-button { display: none; }
        }

        input {
            width: 150px;
            height: 30px;
            font-size: 15px;
        }
        button {
            width: 70px;
            height: 30px;

        }
        .qrcode {
            padding: 42px 0 0 30px;
            float: left;
        }

        .link-button {
            font-size: 16px;
        }
        a:visited, a:link, a {
            text-decoration: none;
        }
    </style>

    <script>
        $(document).ready(function () {
            jQuery('#start').datetimepicker({
                format: 'd/m/Y H:i:s',
                inline: false,
                lang: 'th'
            });
            jQuery('#end').datetimepicker({
                format: 'd/m/Y H:i:s',
                inline: false,
                lang: 'th'
            });
            $(".barcode-pane").each(function () {
                $(this).barcode($(this).attr("data-order-id"), 'code39', {
                    barWidth: 4,
                    barHeight: 80
                });
            });

            $(".qrcode").each(function() {
                $(this).qrcode({
                    width: 80,
                    height: 80,
                    text: $(this).attr("data-url")
                });
            });
        });
    </script>
</head>
<body>
    <table class="page">
        <tbody>
        <tr>
            <td>
                <div class="box-order">
                    <div class="box-order-header">
                        <div class="box-logo">
                            <img class="logo" src="{{ asset('images/logo-black-470.png') }}">
                        </div>
                        <div class="box-header">
                            <h2>Shipment Details</h2>

                            <p>track this shipment : {{ url('/') }}</p>
                        </div>
                    </div>
                    <div class="box-order-body">
                        <div class="detail">
                            <table class="table-detail" cellspacing="0" border="0">
                                <thead>
                                <tr>
                                    <th class="box-head" colspan="4">
                                        Order ID <span>{{ str_pad($order->id, 8, 0, STR_PAD_LEFT) }}</span>
                                    </th>
                                </tr>
                                <tr>
                                    <th width="50%">
                                        Product
                                    </th>
                                    <th width="25%">Color</th>
                                    <th width="10%">
                                        Size
                                    </th>
                                    <th width="15%">
                                        Quantity
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            {{ $item->campaign_product->campaign->title }}
                                        </td>
                                        <td>
                                            {{ $item->campaign_product->color->color_name }}
                                        </td>
                                        <td>
                                            {{ $item->sku->size }}
                                        </td>
                                        <td>
                                            {{ $item->qty }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </td>
            <td>
                <div class="box-shipment">
                    <table cellspacing="0">
                        <tr>
                            <td class="shipment-way" width="65%">
                                <h3><span>Shipment Way&nbsp;:&nbsp;</span>{{ ucfirst($order->shipping_type->name) }}
                                </h3>
                            </td>
                            <td class="shipment-id">
                                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="from">
                    <p>
                        From&nbsp;:&nbsp;GG7&nbsp;
                        197/63 Benjang Road, Mak Khaeng, Mueang Udon Thani, Udon Thani, 41000 <br>
                        call&nbsp;:&nbsp;{{ config('profile.phone-primary') }},
                    </p>
                    <h4>www.{{ config('profile.sitename') }}</h4>
                </div>
                <div class="box-customer">
                    <div class="box-customer-header">
                        <h1><span>To&nbsp;:&nbsp;</span>{{ $order->shipping_address->full_name }}</h1>
                    </div>
                    <div class="box-customer-address">
                        @if($order->shipping_address->building != '')
                            <p>{{ $order->shipping_address->building }}</p>
                        @endif
                        <p>{{ $order->shipping_address->address }}</p>

                        <p>อ.{{ $order->shipping_address->district }}
                            &nbsp;จ.{{ $order->shipping_address->province }}</p>

                        <p>โทร&nbsp;{{ $order->shipping_address->phone }}</p>
                    </div>
                    <div class="zipcode">
                        <h1>{{ $order->shipping_address->zipcode }}</h1>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td class="bottom">
                <div class="box-caution">
                    <h3>DO NOT ACCEPT IF SEAL IS BROKEN</h3>

                    <p>all product at mubaza.com come with manufacturer's warranty where applicable</p>

                    <p>
                        Mubaza allows easy replcement for wrong size, color, quantity, style, manufaturing defects,
                        damaged
                        or significantlu different from product listing
                    </p>

                    <p><b>Customer Support&nbsp;</b>call&nbsp;:&nbsp;098-101-5050, 098-101-6060 <br>
                        email&nbsp;:&nbsp;service@mubaza.com</p>
                </div>
            </td>
            <td class="bottom">
                <div class="box-barcode">
                    <div class="qrcode" data-url="{{ action('UserController@getShowOrder', $order->user->getID()) }}">

                    </div>
                    <div class="order-id">
                        <h4>ORDER ID</h4>
                        <div class="barcode-pane" data-order-id="{{ $order->id }}"></div>
                    </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</body>
</html>
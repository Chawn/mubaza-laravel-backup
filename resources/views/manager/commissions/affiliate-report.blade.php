@extends('manager.layouts.master')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop
@section('script')
    <script src="{{ asset('js/hashids.min.js') }}"></script>
    <script src="{{ asset('js/chart.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/jquery.daterangepicker.js') }}"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script>
        google.load('visualization', '1.1', {packages: ['corechart', 'line']});
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var rows = [];
            var date_start = null;
            var date_end = null;

//            google.setOnLoadCallback(drawBackgroundColor);
            $.dateRangePickerLanguages['custom'] =
            {
                'selected': 'ระหว่าง:',
                'days': 'วัน',
                'apply': 'เลือก',
                'week-1': 'จ',
                'week-2': 'อ',
                'week-3': 'พ',
                'week-4': 'พฤ',
                'week-5': 'ศ',
                'week-6': 'ส',
                'week-7': 'อา',
                'month-name': [
                    'มกราคม',
                    'กุมภาพันธ์',
                    'มีนาคม',
                    'เมษายน',
                    'พฤษภาคม',
                    'มิถุนายน',
                    'กรกฎาคม',
                    'สิงหาคม',
                    'กันยายน',
                    'ตุลาคม',
                    'พฤศจิกายน',
                    'ธันวาคม'
                ],
                'shortcuts': 'Shortcuts',
                'past': 'Past',
                '7days': '7 วัน',
                '14days': '14 วัน',
                '30days': '30 วัน',
                'previous': 'ก่อนหน้า',
                'prev-week': 'อาทิตย์',
                'prev-month': 'เดือน',
                'prev-quarter': 'Quarter',
                'prev-year': 'ปี',
                'less-than': 'Date range should longer than %d days',
                'more-than': 'Date range should less than %d days',
                'default-more': 'Please select a date range longer than %d days',
                'default-less': 'Please select a date range less than %d days',
                'default-range': 'Please select a date range between %d and %d days',
                'default-default': 'กรุณาเลือกช่วงวันที่ต้องการ'
            };
            var date_range_options = {
                endDate: moment().format("D-M-YYYY"),
                format: "D-M-YYYY",
                getValue: function () {
                    return "VALUE" + $(this).val();
                },
                language: "custom",
                separator: " ถึง ",
                showShortcuts: false,
                shortcuts: {
                    'prev-days': [3, 5, 7],
                    'prev': ['week', 'month', 'year'],
                    'next-days': null,
                    'next': null
                }
            };

            $("#selected-date").dateRangePicker(date_range_options).bind('datepicker-apply', function (event, obj) {
                /* This event will be triggered when user clicks on the apply button */
                date_start = moment(obj.date1).format("YYYY-M-DD");
                date_end = moment(obj.date2).format("YYYY-M-DD");
                window.location = "?start=" + date_start + "&end=" +  date_end;
            });

            function drawAxisTickColors() {
                var data = new google.visualization.DataTable();
                var title = '';
                data.addColumn('string', 'วันที่');
                data.addColumn('number', 'รายได้');
                var all_rows = [];
                $.each(rows, function (key, value) {
                    var row = [];
                    row.push(key);
                    row.push(value);
                    all_rows.push(row);
                });
                data.addRows(all_rows);
                console.log(all_rows);
                var options = {
                    hAxis: {
                        title: title,
                        textStyle: {
                            color: '#fff',
                            fontSize: 0,
                            fontName: 'ThaiSansNeue-Regular',
                            bold: true,
                        },
                        titleTextStyle: {
                            color: '#4c3218',
                            fontSize: 24,
                            fontName: 'ThaiSansNeue-Regular',
                            bold: true,
                            italic: false,
                        }
                    },
                    vAxis: {
                        title: 'รายได้ (บาท)',
                        textStyle: {
                            color: '#000',
                            fontSize: 16,
                            fontName: 'ThaiSansNeue-Regular',
                            bold: true
                        },
                        titleTextStyle: {
                            color: '#4c3218',
                            fontSize: 24,
                            fontName: 'ThaiSansNeue-Regular',
                            bold: true,
                            italic: false,
                        },
                        viewWindow: {
                            min: 0
                        }
                    },
                    chart: {
                        title: 'ตารางแสดงผลกำไร',
                        subtitle: 'จำนวน (บาท)'
                    },
                    width: 1068,
                    height: 450,
                    pointSize: 4,
                    lineWidth: 2,
                    curveType: 'function'
                };

                var chart = new google.visualization.LineChart(document.getElementById('sellchart'));
                chart.draw(data, options);
            }
            function loadData(select_start, select_end) {
                $.ajax({
                    type: "POST",
                    url: '/api/affiliate-profit-by-date',
                    data: {
                        start: select_start,
                        end: select_end
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data.success) {
                            rows = data.data;
                            drawAxisTickColors();
                        }
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            }
            loadData($("#selected-date").data("start"), $("#selected-date").data("end"));
        });
    </script>
@stop
@section('css')
    <link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}">
    <style type="text/css" media="screen">
        .product-img img {
            max-width: 100px;
        }
    </style>
@stop
@section('content')
    <div class="row">
        <div class="col-md-3 col-md-offset-5 text-right">
            <label for="selected-date"
                                                                style="margin-top:10px;">เลือกวันที่</label></div>
        <div class="date-range col-md-3 col-xs-12">
            <input type="text" class="form-control"
                   id="selected-date"
                   data-start="{{ $start->format('d/m/Y') }}"
                   data-end="{{ $end->format('d/m/Y') }}">
        </div>
    </div>

    <div class="box-bank">
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div id="chart-warpper">
                        <div id="sellchart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box-blank">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-bordered table-flex table-hover dataTable text-center">
                        <thead>
                        <tr>
                            <th>วันที่</th>
                            <th>รูปสินค้า</th>
                            <th>ชื่อสินค้า</th>
                            <th>จำนวนเงินส่วนแบ่ง</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order_items as $order_item)
                            <tr>
                                <td data-label="รูปสินค้า">{{ $order_item->approved_at->format('d/m/Y') }}</td>
                                <td data-label="ชื่อสินค้า">
                                    <div class="product-img">
                                        <img src="{{ action('CampaignController@getFile', [$order_item->campaign->id, $order_item->campaign->frontCover()]) }}">
                                    </div>
                                </td>
                                <td data-label="จำนวนเงินส่วนแบ่ง">{{ $order_item->campaign->title }}</td>
                                <td data-label="แสดงกราฟ">฿{{ $order_item->affiliate_commission }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">
                                {!! str_replace('/?', '?', $order_items->render()) !!}
                            </div>
                        </div>
                        <div class="col-sm-7">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@stop
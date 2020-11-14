@extends('manager.layouts.master')
@section('script')
    <script src="{{ asset('js/hashids.min.js') }}"></script>
    <script>
    </script>
@stop
@section('css')
    <style type="text/css" media="screen">
       .head-grey{
        background: #ccc;
       }
    </style>
@stop
@section('content')
<div class="box-blank">
    <div class="box-body">
    <table class="table table-bordered dataTable ">
        <thead class="head-grey">
            <tr>
                <th colspan="5">1 ก.พ. 2558 - 28 ก.พ. 2558</th>
            </tr>
        </thead>
        <thead>
            <tr>
                <th>วันที่</th>
                <th>รายละเอียด</th>
                <th>จ่าย (฿)</th>
                <th>รับ (฿)</th>
                <th>คงเหลือ (฿)</th>
            </tr>
        </thead>
        <tbody>

            <tr>
                <td>
                    1 ก.พ. 2558 - 28 ก.พ. 2558
                </td>
                <td>รับรายได้
                </td>
                <td class="text-right"></td>
                <td class="text-right">4,300</td>
                <td class="text-right">4,300</td>
            </tr>
            <tr>
                <td>
                    15 ก.พ. 2558
                </td>
                <td>
                <a href="#" title="">จ่ายรายได้: ธนาคารกรุงไทย 1482444211, Status: Paid (23/8/2558)</a>
                </td>
                <td class="text-right">9,000</td>
                <td class="text-right"></td>
                <td class="text-right">0</td>
            </tr>
            <tr>
                <td>
                    1 ก.พ. 2558
                </td>
                <td>ยอดยกมา</td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right">9,000</td>
            </tr>
        </tbody>

        <thead class="head-grey">
            <tr>
                <th colspan="5">1 ม.ค. 2558 - 31 ม.ค. 2558</th>
            </tr>
        </thead>
        <thead>
            <tr>
                <th>วันที่</th>
                <th>รายละเอียด</th>
                <th>จ่าย (฿)</th>
                <th>รับ (฿)</th>
                <th>คงเหลือ (฿)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    1 ม.ค. 2558 - 31 ม.ค. 2558
                </td>
                <td>รับรายได้
                </td>
                <td class="text-right"></td>
                <td class="text-right">2,100</td>
                <td class="text-right">2,100</td>
            </tr>
            <tr>
                <td>
                   1 ม.ค. 2558
                </td>
                <td>ยอดยกมา</td>
                <td class="text-right"></td>
                <td class="text-right"></td>
                <td class="text-right">0</td>
            </tr>
        </tbody>
        
    </table>   
</div>
@stop
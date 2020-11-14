@extends('backend.layouts.master')
@section('css')
    <style>
        
    </style>
    @stop
@section('script')
    <script>
        $( document ).ready(function() {
           
        });
    </script>
@stop
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">ทั้งหมดที่ผ่านมา</h3>
            </div>
            <div class="box-body">
                <table class="table table-hover">
                    <tr>
                        <td>
                            บัญชีผู้ใช้
                        </td>
                        <td>
                            {{ number_format($user_count, 0) }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            แคมเปญทั้งหมดขณะนี้
                        </td>
                        <td>
                            {{ number_format($campaign_count, 0) }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            จำนวนการสั่งซื้อ
                        </td>
                        <td>
                            {{ number_format($order_count, 0) }} ครั้ง
                        </td>
                    </tr>
                    <tr>
                        <td>
                            จำนวนสินค้าที่ขายแล้ว
                        </td>
                        <td>
                            {{ number_format($item_count, 0) }} ตัว
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">สถิติ</h3>
            </div>
            <div class="box-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>รายการ</th>
                            <th>วันนี้</th>
                            <th>สัปดาห์</th>
                            <th>เดือนนี้</th>
                            <th>ปีนี้</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>ผู้ใช้ใหม่</td>
                            <td>{{ number_format($user_count_day, 0) }}</td>
                            <td>{{ number_format($user_count_week, 0) }}</td>
                            <td>{{ number_format($user_count_month, 0) }}</td>
                            <td>{{ number_format($user_count_year, 0) }}</td>
                        </tr>
                        <tr>
                            <td>เปิดแคมเปญใหม่</td>
                            <td>{{ number_format($campaign_count_day, 0) }}</td>
                            <td>{{ number_format($campaign_count_week, 0) }}</td>
                            <td>{{ number_format($campaign_count_month, 0) }}</td>
                            <td>{{ number_format($campaign_count_year, 0) }}</td>
                        </tr>
                        <tr>
                            <td>จำนวนการสั่งซื้อ</td>
                            <td>{{ number_format($order_count_day, 0) }}</td>
                            <td>{{ number_format($order_count_week, 0) }}</td>
                            <td>{{ number_format($order_count_month, 0) }}</td>
                            <td>{{ number_format($order_count_year, 0) }}</td>
                        </tr>
                        <tr>
                            <td>จำนวนสินค้าที่ขายแล้ว</td>
                            <td>{{ number_format($item_count_day, 0) }}</td>
                            <td>{{ number_format($item_count_week, 0) }}</td>
                            <td>{{ number_format($item_count_month, 0) }}</td>
                            <td>{{ number_format($item_count_year, 0) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
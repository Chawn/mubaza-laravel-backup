@extends('backend.layouts.master')
@section('css')
    <style>
       
    </style>
@stop
@section('script')

@stop
@section('content')
<h3>แก้ไขข้อมูลการสั่งซื้อ {{ str_pad($order->id, 6, 0, STR_PAD_LEFT) }}</h3>
    <form action="{{ action('BackendController@postUpdateOrder', $order->id) }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="order_id" value="{{ $order->id }}">
        <table>
            <tr>
                <td>วิธีการชำระเงิน</td>
                <td>
                    <select name="payment_type" class="form-control">
                        @foreach(\App\PaymentType::all() as $payment)
                            <option value="{{ $payment->name }}" {{ $order->payment_type->id == $payment->id ? 'selected' : '' }}>{{ $payment->detail }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td>วิธีการจัดส่ง</td>
                <td>
                    <select name="shipping_type"  class="form-control">
                        @foreach(\App\ShippingType::all() as $shipping_type)
                            <option value="{{ $shipping_type->name }}" {{ $order->shipping_type->id == $shipping_type->id ? 'selected' : '' }}>{{ $shipping_type->detail }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td>ชื่อ นามสกุล ผู้รับสินค้า </td>
                <td>
                    <input type="text" name="full_name" class="form-control" value="{{ $order->shipping_address->full_name }}" required>
                </td>
            </tr>
            <tr>
                <td>ที่อยู่</td>
                <td>
                    <textarea name="address" placeholder="ที่อยู่" class="form-control" required>{{ $order->shipping_address->address }}</textarea>
                </td>
            </tr>
            <tr>
                <td>อาคาร</td>
                <td>
                    <input type="text" name="building" class="form-control" value="{{ $order->shipping_address->building }}">
                </td>
            </tr>
            <tr>
                <td>เขต/อำเภอ</td>
                <td>

                    <input type="text" name="district" class="form-control" value="{{ $order->shipping_address->district }}" required>
                </td>
            </tr>
            <tr>
                <td>จังหวัด</td>
                <td>
                    <select name="province" id="province" class="form-control" id="province"
                            required>
                        @foreach(Config::get('constant.provinces') as $province)
                            <option value="{{ $province }}" {{ $order->shipping_address->province == $province ? 'selected' : ''}}>{{ $province }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td>รหัสไปรษณีย์</td>
                <td>
                    <input type="text" name="zipcode" class="form-control" value="{{ $order->shipping_address->zipcode }}">
                </td>
            </tr>
            <tr>
                <td>เบอร์โทรศัพท์</td>
                <td>
                    <input type="text" name="phone" placeholder="โทรศัพท์" class="form-control" value="{{ $order->shipping_address->phone }}">
                </td>
            </tr>
            <tr>
                <td>อีเมล</td>
                <td>
                    <input type="text" name="email" placeholder="อีเมล" class="form-control" value="{{ $order->shipping_address->email }}">
                </td>
            </tr>
            <tr>
                <td></td>
                <td><button type="submit" class="btn btn-success btn-lg">บันทึก</button></td>
            </tr>
        </table>
    </form>
@stop
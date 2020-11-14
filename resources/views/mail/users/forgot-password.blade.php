@extends('mail.layouts.email-page')
@section('content')
    <table style="width: 100%;padding:25px;">
        <tr>
            <td width="25%" style="color:#5eba1c;height:50px;padding:0 25px;">
                <a href="{{url('/')}}" style="color:#000;text-decoration:none;">
                    <img src="{{asset('images/logo-gg7.png')}}" alt="GG7logo" style="height:40px;">

                    <p>www.ggseven.com</p>
                </a>
            </td>
            <td width="75%">
                <h1 style="margin: 0px;color:#0096ff">กู้คืนรหัสผ่าน</h1>
                <h4>กรุณายืนยันอีเมลล์โดยการคลิกที่ลิงค์ด้านล่าง</h4>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding:25px;border-top: 1px solid #ddd;font-size:14px;">
                <p><b>สวัสดี</b> {{ $name }}</p>

                <p>เริ่มต้นขั้นตอนการกู้คืนรหัสผ่านโดย คลิกที่ลิงค์ <a
                            href="{{ action('UserController@getResetPassword', [$id, $token]) }}">{{ action('UserController@getResetPassword', [$id, $token]) }}</a>
                    เพื่อดำเนินการ</p>

                <p>
                    หากคลิกที่ลิงก์ดังกล่าวแล้วไม่มีอะไรเกิดขึ้น ให้คัดลอกและวาง URL ลงบนหน้าต่างใหม่ของเบราว์เซอร์แทน
                    หากคุณได้รับอีเมล์ฉบับนี้โดยไม่ตั้งใจ อาจเป็นไปได้ว่ามีบุคคลอื่น ป้อนที่อยู่อีเมล์ของคุณ
                </p>

                <p>
                    ขอขอบคุณที่ใช้ GG7 หากมีคำถามหรือข้อสงสัยเกี่ยวกับบัญชีของคุณ โปรดเข้าไปที่ศูนย์ช่วยเหลือ ของ
                    <a href="{{ url('/') }}">http://www.ggseven.com</a> ได้ที่
                </p>

                <p><a href="{{ action('HelpController@getContact') }}">ติดต่อเรา</a></p>

                <p>นี่เป็นจดหมายสำหรับส่งเพียงอย่างเดียว และจะไม่มีการตรวจสอบหรือตอบกลับจดหมายที่คุณส่งกลับมา</p>

                <p>ขอขอบคุณ</p>

                <p>ทีมงาน GG7</p>
            </td>
        </tr>
    </table>
@stop
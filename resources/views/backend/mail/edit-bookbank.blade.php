@extends('backend.layouts.email')
@section('content')
	<p><b>สวัสดี&nbsp;</b>{{ $user['full_name'] }}</p>
	<p>บัญชี GGSEVEN ของคุณได้แก้ไขบัญชีธนาคาร จาก 
		<b>{{ $old_bank_no }}</b> เป็น <b>{{ $bank_account['no'] }}</b> เมื่อ {{ $created_at }}
	</p>
	<p><b>หากคุณได้ดำเนินการ&nbsp;</b>คุณสามารถเพิกเฉยต่ออีเมล์นี้ได้อย่างปลอดภัย</p>
    <br/>
	<p><b>หากคุณไม่ได้ดำเนินการ&nbsp;</b>
	โปรดคลิกที่ลิ้งค์เพื่อดำเนินการยกเลิกการแก้ไขบัญชีธนาคารนี้</p>
    <p><a href="{{ action('UserController@getBankAccount', $id) }}">ดูรายละเอียดบัญชีธนาคาร</a></p>

    <br/>
    <p>
		ขอขอบคุณที่ใช้ GGSEVEN หากมีคำถามหรือข้อสงสัยเกี่ยวกับบัญชีของคุณ โปรดเข้าไปที่ศูนย์ช่วยเหลือ ของ {{ config('profile.sitename') }} ได้ที่
	</p>
	<p><a href="{{ action('HelpController@getContact') }}">ติดต่อเรา</a></p>
	<p>นี่เป็นจดหมายสำหรับส่งเพียงอย่างเดียว และจะไม่มีการตรวจสอบหรือตอบกลับจดหมายที่คุณส่งกลับมา</p>
	<p>ขอบคุณ</p>
    <br/>
	<p>ทีมงาน {{ config('profile.sitename') }}</p>
@stop
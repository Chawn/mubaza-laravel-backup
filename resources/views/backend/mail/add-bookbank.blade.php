@extends('backend.layouts.email')
@section('content')
	<p><b>สวัสดี&nbsp;</b>{{ $user['full_name'] }}</p>
	<p>บัญชี GGSEVEN ของคุณได้เพิ่มบัญชีธนาคาร
		<b>{{ $bank_account['no'] }}</b> เมื่อ {{ $created_at }}
	</p>
	<p><b>หากคุณไม่ได้ดำเนินการ&nbsp;</b>
        <br/>
	โปรดคลิกที่ลิ้งค์เพื่อดำเนินการยกเลิกการเพิ่มบัญชีธนาคารนี้</p>
	<p><a href="{{ action('UserController@getBankAccount', $id) }}">ดูรายละเอียดบัญชีธนาคาร</a></p>

	<p>
		ขอขอบคุณที่ใช้ GGSEVEN หากมีคำถามหรือข้อสงสัยเกี่ยวกับบัญชีของคุณ โปรดเข้าไปที่ศูนย์ช่วยเหลือ ของ {{ config('profile.sitename') }} ได้ที่
        <br/>
	</p>
	<p><a href="{{ action('HelpController@getContact') }}">ติดต่อเรา</a></p>
	<p>นี่เป็นจดหมายสำหรับส่งเพียงอย่างเดียว และจะไม่มีการตรวจสอบหรือตอบกลับจดหมายที่คุณส่งกลับมา</p>
	<p>ขอ
	<p>ทีมงาน {{ config('profile.sitename') }}</p>
    <br/>
@stop
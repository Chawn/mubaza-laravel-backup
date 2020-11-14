@extends('backend.layouts.email')

@section('content')
<h3>ทั่วไป</h3>
<ol>
	<li>
		<a href="{{ url('/') }}/email-regis">ยืนยันการสมัครสมาชิก</a>
	</li>
	<li>
		<a href="{{ url('/') }}/email-registered">สมัครสมาชิกเรียบร้อยแล้ว</a>
	</li>
	<li>
		<a href="{{ url('/') }}/email-resetpassword">เปลี่ยนรหัสผ่าน</a>
	</li>
	<li>
		<a href="{{ url('/') }}/email-password-reset">เปลี่ยนรหัสผ่านเสร็จแล้ว</a>
	</li>
	<li>
		<a href="{{ url('/') }}/email-edit-email">เปลี่ยนอีเมล์</a>
	</li>
	<li>
		<a href="{{ url('/') }}/email-new-email">ยืนยันอีเมล์ใหม่</a>
	</li>
	<li>
		<a href="{{ url('/') }}/email-add-bookbank">เพิ่มบัญชีธนาคาร</a>
	</li>
	<li>
		<a href="{{ url('/') }}/email-edit-bookbank">แก้ไขบัญชีธนาคาร</a>
	</li>
	<li>
		<a href="{{ url('/') }}/email-delete-bookbank">ลบบัญชีธนาคาร</a>
	</li>
	<li>
		<a href="{{ url('/') }}/email-ban">บัญชีผู้ใช้ถูกแบบเนื่องจาก</a>
	</li>
	<li>
		<a href="{{ url('/') }}/email-favorite">แคมเปญที่คุณชื่นชอบ &nbspกำลังจะหมดเวลาในอีก&nbsp1&nbspวัน</a>
	</li>
	<li>
		<a href="{{ url('/') }}/email-follow">ผู้ขายที่คุณติดตามได้สร้างแคมเปญใหม่</a>
	</li>
	<li>
		<a href="{{ url('/') }}/email-start-again">แคมเปญที่คุณร้องขอให้เปิดอีกครั้ง ได้เปิดแล้ว</a>
	</li>
</ol>

<h3>เกี่ยวกับการสั่งซื้อ</h3>
	<ol>
		<li>
			<a href="{{ url('/') }}/email-design-wait">ออกแบบและสั่งซื้อสินค้า รอการชำระเงิน (โอนเงิน)
			</a>
		</li>
		<li>
			<a href="{{ url('/') }}/email-design-success">ออกแบบและสั่งซื้อสินค้า ชำระเงินแล้ว (บัตรเครดิต)
			</a>
		</li>
		<li>
			<a href="{{ url('/') }}/email-sell-wait">สั่งซื้อสินค้า รอการชำระเงิน (ชำระเงินผ่านการโอนเงิน)
			</a>
		</li>
		<li>
			<a href="{{ url('/') }}/email-sell-success">สั่งซื้อสินค้า เสร็จแล้ว (ชำระเงินผ่านบัตรเครดิต)
			</a>
		</li>
		<li>
			<a href="{{ url('/') }}/email-payment-success">แจ้งชำระเงินแล้ว
			</a>
		</li>
		<li>
			<a href="{{ url('/') }}/email-produce">แคมเปญที่สั่งซื้อได้รับการผลิต
			</a>
		</li>
		<li>
			<a href="{{ url('/') }}/email-notproduce">แคมเปญที่สั่งซื้อไม่ได้รับการผลิต (แจ้งรอการตรวจสอบและคืนเงิน กรณีโอนเงิน)
			</a>
		</li>
		<li>
			<a href="{{ url('/') }}/email-payback">
			GGSEVEN คืนเงินแล้ว
			</a>
		</li>
		<li>
			<a href="{{ url('/') }}/email-shipping">แคมเปญที่สั่งซื้อไม่ได้รับการผลิต (แจ้งรอการตรวจสอบและคืนเงิน กรณีโอนเงิน)
			</a>
		</li>
	</ol>

<h3>เกี่ยวกับการขาย</h3>
	<ol>
		<li>
			<a href="{{ url('/') }}/email-designed">สร้างแคมเปญแล้ว</a>
		</li>
		<li>
			<a href="{{ url('/') }}/email-produce-earnings">แคมเปญได้รับการผลิต แจ้งยอด กำไร มีลิงก์ให้คลิกเพื่อกรอกข้อมูลบัญชีเพื่อรับเงิน</a>
		</li>
		<li>
			<a href="{{ url('/') }}/email-paid">แคมเปญได้รับการผลิต GGSEVEN ได้จ่ายเงินให้แล้ว</a>
		</li>
		<li>
			<a href="{{ url('/') }}/email-shipped">แคมเปญได้รับการผลิต ได้จัดส่งแล้ว</a>
		</li>
		<li>
			<a href="{{ url('/') }}/email-campaign-nonproduce">แคมเปญจบแล้ว ไม่ได้รับการผลิต</a>
		</li>
		<li>
			<a href="{{ url('/') }}/email-campaign-ready-produce">แคมเปญยังไม่จบ มียอดสั่งซื้อมากพอที่จะได้รับการผลิต</a>
		</li>
		<li>
			<a href="{{ url('/') }}/email-campaign-goals">แคมเปญยังไม่จบ ขายได้เกินเป้า</a>
		</li>
		<li>
			<a href="{{ url('/') }}/email-campaign-banned">แคมเปญโดนแบนเนื่องจาก...</a>
		</li>
		<li>
			<a href="{{ url('/') }}/email-campaign-start-again">แคมเปญจบแล้ว มีคนต้องการให้เปิดแคมเปญอีกครั้งมากกว่า 10 คน มีลิงก์ให้คลิกเพื่อเปิดอีกครั้ง</a>
		</li>
	</ol>
@stop

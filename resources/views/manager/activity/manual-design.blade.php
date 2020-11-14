@extends('manager.layouts.master')
@section('script')
<script>
	$(document).ready(function() {
		var deviceWidth = $(window).width();
		var panelHeight = $('#mockup').height();
		if ( deviceWidth > 767) {

			$('#striped').css({
				'height': panelHeight,
			});
		}
		
	});
</script>
@stop
@section('css')
<style>
	.main{
		padding-top: 0px;
        margin-top:0px;
	}
	#artist-header .jumbotron{
		padding-top: 40px;
	}
	#striped img{
		height: 150px;
		position: relative;
    	bottom: -70px;
	}
	#mockup img{
		height: 250px;
	}
	@media(max-width: 767px){
		#artist-header img{
			width: 100%;
		}
		#artist-header .btn{
			width: 100%;
			height: auto;
			font-size: 16px;
		}
		#mockup img{
			width: 100%;
			height: auto;
		}
		#striped img{
			height: auto;
			width: 65%;
			position: static;
			margin: auto;
		}
	}	
</style>
@stop
@section('content')
<section id="provision">
	<div class="row">
		<div class="col-md-12">
			<h3>1 ข้อกำหนดและเงื่อนไข</h3>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<div id="striped" class="panel panel-default">
				<div class="panel-heading text-center">
					<h3 class="panel-title">รูปลาย</h3>
				</div>
				<div class="panel-body text-center">
					<p>ภาพที่นำไปใช้ในกระบวนการผลิต</p>
					<hr>
					<p>รูปแบบไฟล์: PNG พื้นหลังโปร่งใส</p>
					<p>ขนาด: กว้าง 2400 พิกเซล x สูง 3200 พิกเซล</p>
					<hr>
					<img src="{{asset('images/activity/1449140442_cat_hungry.png')}}">
				</div>
			</div>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<div id="mockup" class="panel panel-default">
				<div class="panel-heading text-center">
					<h3 class="panel-title">รูปเสื้อตัวอย่าง</h3>
				</div>
				<div class="panel-body text-center">
					<p>ภาพเสื้อตัวอย่างที่แสดงให้ผู้ซื้อเห็น</p>
					<hr>
					<p>รูปแบบไฟล์: PNG หรือ JPG</p>
					<p>แนะนำให้ดาวน์โหลด <a href="{{url('resources/gg7-t-shirt.psd')}}">Template</a> ของเรา</p>
					<hr>
					<img src="{{asset('images/activity/GG7-T-shirt-Template-V1.png')}}">
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<p>
				*&nbsp;แนะนำให้ใช้ความละเอียดที่สูงกว่า 72 dpi
			</p>
			<p>
				**&nbsp;ขนาดสูงสุดของภาพละไฟล์คือ 5 MB
			</p>
			<p>
				***&nbsp;รูปลาย และ รูปลายที่อยู่บนรูปเสื้อตัวอย่าง จะต้องเป็นลายเดียวกัน
			</p>
			<p>
				****&nbsp;รูปภาพลายจะต้องเป็นลายที่คิดและออกแบบขึ้นใหม่ และต้องไม่ใช่ลายที่ละเมิดลิขสิทธิ์
			</p>
		</div>
	</div>
</section>
<section id="guid">
	<div class="row">
		<div class="col-md-12">
			<h3>2 คำแนะนำและการพิจารณาลาย</h3>
		</div>
		<div class="col-md-12">
			<h4>ลายที่แนะนำ</h4>
			<ol>
				<li>
					ลายที่สร้างสรรค์ขึ้นมาใหม่ ด้วยจินตนาการ และความตั้งใจ ของคุณเอง
				</li>
				<li>
					ลายที่มีสีตรงข้ามกับสีเสื้อ เช่น เสื้อมีสีอ่อน ลายควรมีสีเข้ม
				</li>
				<li>
					ไม่เป็นลายที่ละเมิดลิขสิทธิ์ หรือเคยมีการวางจำหน่ายที่ใดมาก่อน
				</li>
				<li>
					ลายสามารถออกแบบได้ไม่จำกัดสี ไม่จำกัดความคิดสร้างสรรค์ แต่จะต้องไม่ขัดกับประเพณี และ วัฒนธรรม
				</li>
				<li>
					ลายที่ส่งเข้ามาเมื่อผ่านการพิจารณา จนสามารถวางจำหน่ายได้แล้ว ถือเป็นลิขสิทธิ์ร่วมกัน ระหว่างผู้สร้างสรรค์ลาย และ ggseven.com โดยลิขสิทธิ์การออกแบบยังคงเป็นของผู้สร้างสรรค์ลาย โดยสามารถยุติการจำหน่ายเมื่อใดก็ได้
				</li>
			</ol>
		</div>
		<div class="col-md-12">
			<h4>ลายที่ไม่แนะนำ</h4>
			<ol>
				<li>
					ลายที่ละเมิดลิขสิทธิ์ เช่นคัดลอกงานของผู้อื่น หรือนำงานของผู้อื่นมาใช้ในงานตนเอง
				</li>
				<li>
					ลายที่ขาดความน่าสนใจ เช่น ลายที่มีขนาดเล็ก หรือ สีอ่อนจนมองเห็นไม่ชัดเจน 
				</li>
				<li>
					ลายที่ขัดต่อกฎหมาย ศีลธรรม หรือ ระเบียบของสังคม 
				</li>
				<li>
					ลายที่มีรูปลาย และรูปลายบนภาพเสื้อตัวอย่าง แตกต่างกันโดยสิ้นเชิง
				</li>
				<li>
					ลายที่ผลิตขึ้นมาเฉพาะบุคคล เช่น ภาพใบหน้าตนเอง
				</li>
				<li>
					ลายที่เคยวางจำหน่ายที่อื่นมาก่อนแล้ว ที่มิใช่การสร้างสรรค์ขึ้นสำหรับ GG7 โดยเฉพาะ
				</li>
			</ol>
		</div>
		<div class="col-md-12">
			<p>หมายเหตุ&nbsp;:&nbsp;</p>
			<p>-&nbsp;หากพบการทุจริต การละเมิด หรือความผิดปกติใด ทาง ggseven.com ขอสงวนสิทธิ์ในการเปลี่ยนแปลง หรือยกเลิกการพิจารณาตามรายบุคคลไป</p>
			<p>-&nbsp;นอกจากแนวทางปฏิบัติที่ระบุไว้ข้างต้น ggseven.com อาจยุติการวางจำหน่ายลายใดๆ ที่เราเห็นว่าไม่มีความเหมาะสมก็ได้</p>
			<p>-&nbsp;การพิจารณา และการตัดสิน ขึ้นอยู่กับดุลยพินิจของทีมงาน ggseven.com ถือเป็นที่สุด</p>
		</div>
	</div>
</section>
@stop
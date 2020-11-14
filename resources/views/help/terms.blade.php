@extends('layouts.help')
@section('css')
@section('content')
<div id="artcle">
	<p class="text-indent">
		ยินดีต้อนรับสู่เว็บไซต์ {{ config('profile.sitename') }} ผู้เข้าชมเว็บไซต์นี้จะต้องถูกผูกพันตามข้อกำหนดและเงื่อนไขในเว็บไซต์นี้ ดังนั้นโปรดอ่าน ข้อกำหนดและเงื่อนไขเหล่านี้ด้วยความระมัดระวังก่อนทำธุรกรรมใด ๆ บนเว็บไซต์นี้ และเพื่อจุดประสงค์ ในข้อกำหนดและเงื่อนไขนี้ให้คำว่า "{{ config('profile.sitename') }}"  หมายถึง "mubaza ทะเบียนพาณิชย์เลขที่ 1411700196868" และ "เว็บไซต์นี้" หมายถึง "{{ config('profile.sitename') }}" ซึ่งอาจจะมีการเชื่อมต่อกับเว็บไซต์อื่น ๆ ของ {{ config('profile.sitename') }} และเว็บไซต์อื่น ๆ ของบุคคลภายนอก ที่มีการเชื่อมต่อนั้นอาจจะมีข้อกำหนดและ เงื่อนไขอื่นซึ่งแตกต่างไปจาก ข้อกำหนดและเงื่อนไขในเว็บไซต์นี้ ในระหว่างที่คุณ เข้าเยี่ยมชมเว็บไซต์อื่น ๆ โปรดตรวจสอบข้อกำหนดและเงื่อนไขของเว็บไซต์แต่ละแห่งที่คุณเข้าเยี่ยมชมอย่าพึงสันนิษฐาน ว่าข้อกำหนดและเงื่อนไขในเว็บไซต์นี้จะใช้กับเว็บไซต์อื่นของ {{ config('profile.sitename') }} ด้วย
	</p>
	<h4 class="article-title">ข้อกำหนดและเงื่อนไขการใช้</h4>
	<p class="text-indent">
		เว็บไซต์นี้ประกอบด้วยเนื้อหาต่าง ๆ ทั้งที่เป็นตัวอักษร รูปภาพและเสียง ซึ่งได้รับความ คุ้มครองในด้านลิขสิทธิ์ และทรัพย์สินทางปัญญาประเภทอื่นๆ ลิขสิทธิ์และทรัพย์สินทางปัญญาทั้งหลายที่บรรจุในเว็บไซต์นี้เป็นกรรมสิทธิ์ของ {{ config('profile.sitename') }} ได้รับอนุญาตจากผู้มีสิทธิเหล่านั้นให้สามารถใช้เป็นส่วนหนึ่งของเว็บไซต์นี้ได้ เว็บไซต์นี้ประกอบด้วยเครื่องหมายการค้า ทั้งเครื่องหมาย คำว่า ”{{ config('profile.sitename') }}” (ggseven) และสัญลักษณ์รูป {{ config('profile.sitename') }} เครื่องหมายการค้าที่ปรากฏในเว็บไซต์เหล่านี้เป็นกรรมสิทธิ์ของ {{ config('profile.sitename') }} หรือผู้ที่ได้รับอนุญาตจากเจ้าของเครื่องหมายการค้าเหล่านั้นให้ใช้ในเว็บไซต์นี้ได้ คุณอาจจะทำการพิมพ์ ทำซ้ำ หรือใช้ข้อมูลหรือดาวน์โหลดไฟล์ที่เป็นซอฟต์แวร์ หรือรูปภาพ จากเว็บไซต์นี้เพื่อใช้ส่วนตัว หรือเพื่อการศึกษาเท่านั้น โดยไม่นำไปใช้ในกิจกรรมใด ๆ ที่เกี่ยวข้องกับการค้า และมีข้อแม้ว่าคุณต้องระบุถึงสิทธิความเป็นเจ้าของให้กับ {{ config('profile.sitename') }} และไม่ทำการแก้ไขข้อมูลเหล่านั้น เอกสารทุกประเภทที่เกิดจากการทำซ้ำขึ้น จะต้องมีข้อความที่ระบุถึงสิทธิต่าง ๆ ที่ปรากฏในข้อมูลต้นฉบับนั้น ๆ
		ข้อมูลที่คุณเป็นผู้ส่งให้ {{ config('profile.sitename') }} เช่นรูปภาพลายเสื้อ ข้อความแสดงความคิดเห็นเป็นต้นนั้น ทีมงาน {{ config('profile.sitename') }} มีสิทธิ์เด็ดขาดในการพิจารณาข้อมูล เนื้อหาที่ยู่ภายในเว็บไซต์ของเรา ให้แสดงผล หรือ ปฏิเสธการแสดงผล หรือจะนำออกเมื่อใดก็ได้โดยไม่ต้องบอกล่าวล่วงหน้า

	</p>
	<h4 class="article-title">การปฏิเสธความรับผิดและข้อจำกัดความรับผิด</h4>
		<p class="text-indent">เนื้อหาและข้อมูลใดที่ปรากฏใน เว็บไซต์นี้ได้รับการรวบรวมโดย {{ config('profile.sitename') }} จากแหล่งข้อมูลต่าง ๆ ที่ได้รับอนุญาตแล้ว และสามารถเปลี่ยนแปลงได้โดยไม่ต้องมีการบอกกล่าวล่วงหน้า ทุกครั้งในการเปิดดูเว็บไซต์นี้ คุณยอมรับที่จะปฏิบัติตามข้อกำหนด และเงื่อนไขการใช้ที่มีอยู่ ณ เวลาขณะที่เข้าเยี่ยมชมเว็บไซต์นี้ ดังนั้นทุกครั้งที่เข้าเยี่ยมชมเว็บไซต์ คุณจึงควรตรวจสอบข้อกำหนดและเงื่อนไขการใช้ก่อน เราขอปฏิเสธความรับผิดในการรับประกันใด ๆ (warranties) ทุกประเภทที่เกี่ยวกับเว็บไซต์นี้ หรือการที่คุณใช้การรับประกันคุณภาพ (warranties) ทุกประเภท ไม่ว่าจะเป็นการรับประกัน ด้านการซื้อขายหรือความเหมาะสมเพื่อวัตถุประสงค์เฉพาะอย่างใดอย่างหนึ่ง หรือผลที่จะได้รับ จากการใช้ข้อมูลและผลิตภัณฑ์ดังกล่าว หรือการใช้ข้อมูลหรือผลิตภัณฑ์ดังกล่าวจะไม่ละเมิด สิทธิใด ๆ เราจะไม่รับผิดชอบต่อผลกำไรหรือขาดทุนอันเกิดจากโอกาสทางธุรกิจที่เกิดจากการใช้ หรือใช้เว็บไซต์ หรือข้อมูลในเว็บไซต์นี้ในทางที่ผิด โปรดสังเกตว่าผลิตภัณฑ์ทุกประเภทที่เราซื้อหรือจำหน่ายนั้นอยู่ภายใต้เงื่อนไขที่ระบุในเนื้อหา การรับรู้คำสั่ง และ/หรือใบส่งสินค้า เรารับรองเพียงว่าผลิตภัณฑ์ของเรามีคุณสมบัติตาม มาตรฐานดังปรากฏในเนื้อหาเอกสารเหล่านั้น หรือในสิ่งตีพิมพ์อื่น ๆ จริง</p>

	<h4 class="article-title">การเชื่อมโยงกับเว็บไซต์อื่น ๆ</h4>
		<p class="text-indent">เว็บไซต์นี้อาจมีการเชื่อมต่อกับเว็บไซต์อื่น ๆ การเชื่อมต่อนี้เพื่อช่วยให้คุณค้นหาเว็บไซต์ บริการ และ/หรือ ผลิตภัณฑ์ที่เกี่ยวข้องได้อย่างรวดเร็วและง่ายดาย เราไม่มีอำนาจที่จะควบคุม รับรองยืนยันความถูกต้องหรือความน่าเชื่อถือหรือรับผิดชอบในเนื้อหาของเว็บไซต์ของบุคคล ภายนอก หรือการเชื่อมต่อใด ๆ ที่บรรจุอยู่ในเว็บไซต์ของบุคคลภายนอก แม้ว่าเว็บไซต์ดัง กล่าวนั้นจะมีเจ้าหน้าที่ของ {{ config('profile.sitename') }} อื่นเป็นเจ้าของและผู้ดำเนินการก็ตาม การตัดสินใจว่าบริการ และ/หรือผลิตภัณฑ์ที่นำเสนอผ่านเว็บไซต์เหล่านี้สอดคล้องกับวัตถุประสงค์ของคุณหรือไม่นั้น เป็นความรับผิดชอบของคุณเอง {{ config('profile.sitename') }} ไม่มีความรับผิดชอบ ในฐานะเจ้าของหรือผู้ดำเนินการเว็บไซต์เหล่านั้น หรือสินค้าและบริการที่บริษัทผู้เป็นเจ้าของ หรือผู้ดำเนินงานของเว็บไซต์นำเสนอ และ {{ config('profile.sitename') }} ไม่ได้มีส่วน เกี่ยวข้องในการกำหนดถึงการรับประกันใด ๆ หรือต้องรับภาระค่าเสียหายที่เกี่ยวพันกับเจ้าของ หรือผู้ดำเนินงานของเว็บไซต์ใด ๆ (รวมทั้งความเสียหายที่เกิดจากข้ออ้างใด ๆ ก็ตามที่ละเมิดลิขสิทธิ์หรือทรัพย์สินทางปัญญาประเภทอื่นของเว็บไซต์ของบุคคลที่สามนั้น</p>
	<h4 class="article-title">การชำระเงิน</h4>
		<p class="text-indent">
			หากคุณชำระเงินบน {{ config('profile.sitename') }} หมายความว่าคุณยอมรับ<a href="{{ url('help/payment_terms') }}">เงื่อนไขการชำระเงิน</a>ของเรา เว้นแต่จะมีการระบุไว้ว่าให้ใช้เงื่อนไขอื่น
		</p>




	<h4 class="article-title">การคุ้มครองข้อมูล</h4>
		<p class="text-indent">รายละเอียดข้อมูลส่วนบุคคลที่คุณแจ้งต่อ {{ config('profile.sitename') }} ผ่านเว็บไซต์นี้จะถูกนำ ไปใช้ตามนโยบายการรักษาข้อมูลส่วนตัวเท่านั้น โปรดอ่านนโยบายนี้อย่างละเอียดก่อนผ่านไปยังข้อมูลอื่น และด้วยการที่คุณให้ข้อมูลส่วนตัวนี้เท่ากับว่าคุณได้ยินยอมให้มีการนำข้อมูลนี้ไปใช้ตามนโยบาย การรักษาข้อมูลส่วนบุคคลของเรา</p>

	<h4 class="article-title">ลิขสิทธิ์</h4>
	<p class="text-indent">
		ลิขสิทธิ์คือการที่บุคคลใดสร้างสรรค์ผลงานขึ้นใหม่และจัดเก็บไว้ในสื่อบันทึกข้อมูลแบบจับต้องได้ บุคคลผู้นั้นถือเป็นเจ้าของลิขสิทธิ์ในผลงานชิ้นนั้นโดยอัตโนมัติ เจ้าของจะมีสิทธิ์เฉพาะตัวในการใช้ผลงานในรูปแบบที่เฉพาะเจาะจง
	</p>

	<h4 class="article-title">เครื่องหมายการค้า</h4>
	<p class="text-indent">
		เครื่องหมายการค้า หมายถึง เครื่องหมาย หรือยี่ห้อ หรือตราที่ใช้กับสินค้าเพื่อแสดงว่าสินค้าที่ใช้เครื่องหมายการค้านั้นแตกต่างไปจาสินค้าของบุคคลอื่น เครื่องหมายการค้าเป็นทรัพย์สินทางปัญญาประเภทหนึ่งที่ได้รับความคุ้มครอง {{ config('profile.sitename') }} ไม่อนุญาตให้ผู้ใช้นำเครื่องหมายการค้าของผู้อื่นมามาใช้ นอกจากได้รับอนุญาตจากเจ้าของแล้ว
	</p>
	<p class="text-indent">
		{{ config('profile.sitename') }} ไม่สามารถกำหนดความเป็นเจ้าของลิขสิทธิ์ได้ {{ config('profile.sitename') }} ไม่สามารถเป็นตัวกลางไกล่เกลี่ยข้อโต้แย้งเกี่ยวกับการเป็นเจ้าของสิทธิ์ได้ เมื่อเราได้รับการแจ้งเตือนการละเมิด เราจะทำการนำเนื้อหานั้นออกตามที่กฎหมายกำหนด แต่ผู้ถูกแจ้งเตือนการละเมิดสามารถยื่นเรื่องโต้แย้งได้ เมื่อเราได้รับการยื่นเรื่องโต้แย้งเราจะส่งคำโต้แย้งต่อไปยังผู้ที่แจ้งเตือนการละเมิด หลังจากนั้นก็จะขึ้นอยู่กับฝ่ายที่เกี่ยวข้องว่าจะยื่นฟ้องต่อศาลหรือไม่
	</p>

	<h4 class="article-title">ผลงานเลียนแบบ</h4>
	<p class="text-indent">
		คุณต้องได้รับอนุญาตจากเจ้าของลิขสิทธิ์ในการสร้างงานที่มาจากรูปแบบดั้งเดิมของพวกเขา ผลงานเลียนแบบอาจรวมถึง การปรับแต่ง เปลี่ยนสี ต่อเติม ฯลฯ คุณอาจจะต้องปรึกษาผู้เชี่ยวชาญด้านกฎหมายก่อนเปิดการขายเพื่อขายลายเสื้อที่มีรูปแบบ ลวดลาย และองค์ประกอบอื่นๆ ที่เหมือนของสินค้าที่ได้รับการคุ้มครองลิขสิทธิ์
	</p>

	<h4 class="article-title">วิธีส่งคำขอแจ้งการละเมิด</h4>
	<p class="text-indent">
		คุณสามารถรายงานการละเมิดลิขสิทธิ์ได้ที่หน้าแคมเปญ หรือหน้าโปรไฟล์ผู้ใช้ที่ละเมิดลิขสิทธิ์ หรือส่งอีเมล์มาที่ {{ config('profile.email') }}
	</p>
	<p class="text-indent">
		ในการรายงานการละเมิดลิขสิทธิ์ คุณอาจต้องส่งข้อมูลเพิ่มเติม เพราะการลบด้านลิขสิทธิ์คือคำขอทางกฎหมายที่เป็นทางการ ซึ่งต้องมีองค์ประกอบเฉพาะเพื่อให้คำขอสมบูรณ์และสามารถดำเนินการได้ เมื่อเราได้รับคำขอด้านลิขสิทธิ์ที่ไม่สมบูรณ์หรือไม่ถูกต้อง ไม่ว่าจะเป็นการแจ้งเพื่อให้ลบออก หรือการยื่นเรื่องโต้แย้ง เราจะตอบกลับด้วยข้อมูลที่จะช่วยให้ผู้ส่งสร้างคำขอที่สมบูรณ์
	</p>
	<p class="text-indent">
		ถ้าคุณได้รับการตอบกลับในลักษณะนี้หลังจากส่งคำขอเกี่ยวกับลิขสิทธิ์ คุณจะต้องตรวจดูการตอบกลับที่ได้รับให้ละเอียดและปฏิบัติตาม โดยส่วนใหญ่แล้ว เราจะไม่สามารถดำเนินการใดๆ กับคำขอของคุณได้ จนกว่าคุณจะดำเนินการแก้ไขคำขอให้สมบูรณ์
	</p>

	
	<h4 class="article-title">{{ config('profile.sitename') }} ไม่ต้องการมีส่วนเกี่ยวข้องกับการละเมิดลิขสิทธิ์</h4>
	<p class="text-indent">
		เราจะไม่ผลิตสินค้าที่มีลวดลายที่เป็นการละเมิดลิขสิทธิ์ แต่หากไม่มีการร้องเรียนการละเมิดลิขสิทธิ์ เราอาจผลิตสินค้านั้นโดยไม่ทราบว่าเป็นสินค้าที่มีการละเมิดลิขสิทธิ์ เนื่องจากเราไม่สามารถตรวจสอบที่มาที่ไปของทุกลายออกแบบได้ว่ามีสินค้าที่ละเมิดลิขสิทธิ์หรือไม่
	</p>

	<p class="text-indent text-italic">
		ข้อจำกัดความรับผิดชอบ : เราไม่ใช่ทนายความของคุณและข้อมูลที่ระบุนี้ไม่ใช่คำแนะนำทางกฎหมาย เราจัดเตรียมข้อมูลเหล่านี้ไว้เพื่อวัตถุประสงค์ในการให้ข้อมูลคุณเท่านั้น
	</p>

	<h4 class="article-title">นโยบายการรักษาข้อมูลส่วนบุคคล</h4>
		<p class="text-indent">สำหรับข้อมูลเพิ่มเติมเกี่ยวกับการเก็บ การใช้ และการเปิดเผยข้อมูลส่วนบุคคลของคุณนั้น โปรดดูนโยบายการรักษาข้อมูลส่วนบุคคลของเรา</p>

	<h4 class="article-title">ข้อร้องเรียน</h4>
		<p class="text-indent">หากคุณมีคำถามหรือต้องการร้องเรียนเกี่ยวกับเว็บไซต์นี้ โปรดส่งเรื่องร้องเรียนมาที่ {{ config('profile.email') }} หรือโทร {{ config('profile.phone-all') }}</p>

	<h4 class="article-title">เขตอำนาจศาล</h4>
		<p class="text-indent">ข้อกำหนดและเงื่อนไขการใช้ที่ปรากฏบนเว็บไซต์นี้ ให้ใช้บังคับและตีความตามกฎหมายไทย และในกรณี ที่เกิดข้อพิพาทขึ้นอันเกี่ยวข้องเว็บไซต์นี้ ไม่ว่าจะเป็นสัญญา หรือละเมิด หรือนิติสัมพันธ์ทางกฎหมายใด ๆ ให้ศาลไทยมีอำนาจโดยเด็ดขาดในการพิจารณาข้อพิพาทเหล่านั้น</p>

</div>
<!-- end PAGE -->
@stop

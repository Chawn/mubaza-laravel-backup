<div id="bc-sell" class="{{ $type=='sell' ? 'active' : 'hidden' }} breadcrumb-design">
	<div class="container">
		<ol class="breadcrumb">
			<li class="{{ $step>1 ? 'visited' : '' }} {{ $step==1 ? 'active' : '' }}">
				@if($step == 2)
					<a href="javascript:history.back({{ 1 - $step }})">
				@else
					<a href="javascript:void(0)">
				@endif
					<span class="breadcrumb-circle">
						1
					</span>
					<p>สร้างแคมเปญ</p>
				</a>	
			</li>
			<li class="content {{ $step>1 ? 'passed' : '' }}">				
			</li>
			<li class="{{ $step>2 ? 'visited' : '' }} {{ $step==2 ? 'active' : '' }}">
				@if($step == 3)
					<a href="javascript:history.back({{ 2 - $step }})">
				@else
					<a href="javascript:void(0)">
				@endif
					<span class="breadcrumb-circle">
						2
					</span>
					<p>ตั้งเป้าการขาย</p>
				</a>
			</li>
			<li class="content {{ $step>2 ? 'passed' : '' }}">
				
			</li>
			<li class="{{ $step==3 ? 'active' : '' }}">
				<a href="javascript:void(0)">
					<span class="breadcrumb-circle">
						3
					</span>
					<p>ใส่รายละเอียด</p>
				</a>
			</li>
		</ol>
	</div>	
</div>
<div id="bc-design" class="{{ $type=='design' ? 'active' : 'hidden' }} breadcrumb-design">
	<div class="container">
		<ol class="breadcrumb">
			<li class="{{ $step>1 ? 'visited' : '' }} {{ $step==1 ? 'active' : '' }}">
				<a href="#">
					<span class="breadcrumb-circle">
						1
					</span>
					<p>ออกแบบเพื่อสั่งซื้อ</p>
				</a>	
			</li>
			<li class="content {{ $step>1 ? 'passed' : '' }}">
				
			</li>
			<li class="{{ $step>2 ? 'visited' : '' }} {{ $step==2 ? 'active' : '' }}">
				<a href="#">
					<span class="breadcrumb-circle">
						2
					</span>
					<p>กรอกรายละเอียดการจัดส่ง</p>
				</a>
			</li>
			<li class="content {{ $step>2 ? 'passed' : '' }}">
				
			</li>
			<li class="{{ $step==3 ? 'active' : '' }}">
				<a href="#">
					<span class="breadcrumb-circle">
						3
					</span>
					<p>ชำระเงิน</p>
				</a>
			</li>
		</ol>
	</div>	
</div>
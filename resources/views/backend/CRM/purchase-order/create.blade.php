@extends('backend.layouts.master')
<link rel="stylesheet" href="{{ asset('css/crm.css') }}">
@section('content')
<div class="row">
	<div class="col-md-3 pull-right">
		<div class="box">
			<div class="box-body box-menu">
				<div class="box-sub">
					<h4><i class="fa fa-cog"></i>&nbsp;เครื่องมือ 
						<span class="btn-transparent pull-right" data-toggle="collapse" data-target="#po-menu" aria-expanded="false" aria-controls="filter-menu">
							<i class="fa fa-angle-down"></i>
						</span>
					</h4>
					<div id="po-menu" class="collapse in">				
						<ul class="list-group">
							<li class="list-group-item">
								<button class="btn btn-crm btn-primary">
									<span></span>ดูตัวอย่าง 
								</button>
							</li>
							<li class="list-group-item">
								<button class="btn btn-crm btn-success">
									<span></span>บันทึก 
								</button>
							</li>
							<li class="list-group-item">
								<button class="btn btn-crm btn-default">
									<span></span>ยกเลิก 
								</button>
							</li>
						</ul>
						
					</div>
						
				</div>

				<div class="box-sub">
					
				</div>
			</div>
				
		</div>
	</div>
	<div class="col-md-9">
		<div class="box">
			
		</div>
	</div>
</div>
@stop
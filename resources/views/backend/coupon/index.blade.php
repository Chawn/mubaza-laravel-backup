@extends('backend.layouts.master')
<link rel="stylesheet" href="{{ asset('css/coupon.css') }}">
@section('css')
<style>
	.btn-tools-group .btn-tools{
		width: 32%;
	}
</style>
@stop
@section('script')
<script>
	$(document).ready(function() {
		$('.docbox').click(function(e){	
			if(!$(e.target).closest('.td-view').length){
				if ($(this).find('input:checkbox[name=selectQUO]').is(":checked")) {
					$(this).find('input:checkbox[name=selectQUO]').attr("checked", false);
				}else {
				    $(this).find('input:checkbox[name=selectQUO]').prop("checked", true);		    
				}
			}		
			if($('#coupon input:checkbox:checked').length > 0) {
				$('#btn-add').addClass('disabled');
			}else{
				$('#btn-add').removeClass('disabled');
			}

			if($('#coupon input:checkbox:checked').length > 1) {
				$('#btn-edit').addClass('disabled');
			}else{
				$('#btn-edit').removeClass('disabled');
			}
		});

		$(".delete-button").click(function() {
            var result = confirm("คุณต้องการลบคูปองส่วนลดออกจากระบบ?");
            var element = $(this);
            if(result) {
                deleteCoupon(element.data("coupon-id"));
            }
        });

        function deleteCoupon(id) {
            $.ajax({
                type: "GET",
                url: "/backend/coupon/delete/" + id,
                success: function (data) {
                    if(data.success) {
                        window.location.reload();
                    } else
                    {
                        alert(data.message);
                    }
                },
                failure: function (errMsg) {
                    alert(errMsg);
                }
            });
        }

	});
</script>
@stop
@section('content')
<div class="col-md-3 col-sm-3 col-xs-12 pull-right">
	<div class="box">
		<div class="box-header with-border">
			<h4 class="box-title">คูปองทั้งหมด</h4>
		</div>
		<div class="box-body">
			<div id="btn-tools-group" class="btn-tools-group collapse in">
				<a id="btn-add" href="{{ action('BackendController@getAddCoupon') }}" class="btn btn-block btn-success">สร้าง</a>
{{--				<a id="btn-edit" href="{{url('coupon-edit')}}" class="btn btn-tools btn-warning">แก้ไข</a>--}}
{{--				<a id="btn-delete" href="{{url('coupon')}}" class="btn btn-tools btn-default">ลบ</a>--}}
			</div>
		</div>
	</div>
</div>
<div class="col-md-9 col-sm-9 col-xs-12">
	<div id="coupon" class="box">
		<div class="box-header">
			<h4 class="box-title">คูปอง</h4>
			<div class="box-tools">
	            <div class="input-group input-group-sm" style="width: 150px;">
		              <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

		              <div class="input-group-btn">
		                	<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
		              </div>
	            </div>
          	</div>
		</div>
		<div class="box-body table-responsive no-padding">
			<table class="table table-hover">
				<thead>
				<tr>
					<th>ID</th>
					<th>คูปอง</th>
					<th>วันที่หมดอายุ</th>
					<th>สถานะ</th>
					<th>เครื่องมือ</th>
				</tr>
				</thead>
                <tbody>
				@foreach($coupons as $coupon)
	                <tr class="docbox">	                	
	                	<td>{{ $coupon->id }}</td>
	                	<td>{{ $coupon->coupon_name }}</td>
	                	<td>{{ $coupon->coupon_condition_end_date->format('d/m/Y H:i')}}</td>
	                	<td>{{ $coupon->getStatusName() }}</td>
	                	<td>
	                		<a href="{{url('backend/coupon/detail', $coupon->id)}}" class="btn btn-primary">
	                			<i class="fa fa-search"></i>
	                		</a>
	                		<a href="{{ url('backend/coupon/edit', $coupon->id) }}" class="btn btn-warning">
								<i class="fa fa-pencil"></i>
	                		</a>
	                		<a href="javascript:void(0)" class="btn btn-danger delete-button" data-coupon-id="{{ $coupon->id }}">
	                			<i class="fa fa-trash"></i>
	                		</a>
	                	</td>
	                	
							
							{{--<div class="select">--}}
								{{--<input type="checkbox" name="selectQUO">--}}
								{{--<label for="selectQUO"><i class="fa fa-check-circle"></i></label>--}}
							{{--</div>--}}
	                	
	                </tr>
					@endforeach
	                {{--<tr class="docbox">--}}
	                	{{--<td class="td-view"><a href="{{url('coupon-view')}}" class="btn btn-default"><i class="fa fa-eye"></i></a></td>--}}
	                	{{--<td>175</td>--}}
	                	{{--<td>ลด30%</td>--}}
	                	{{--<td>05/01/59</td>--}}
	                	{{--<td><span class="label label-warning">ใกล้หมดเวลา</span></td>--}}
	                	{{--<td>สั่งซื้อ 1000 บาทขึ้นไป ต่อ 1 ออร์เดอร์ ต่อ 1 ผู้ใช้</td>--}}
	                	{{--<td>--}}
	                		{{--<div class="select">--}}
	                			{{--<input type="checkbox" name="selectQUO">--}}
	                			{{--<label for="selectQUO"><i class="fa fa-check-circle"></i></label>--}}
	                		{{--</div>--}}
	                	{{--</td>--}}
	                {{--</tr>--}}
	                {{--<tr class="docbox">--}}
	                	{{--<td class="td-view"><a href="{{url('coupon-view')}}" class="btn btn-default"><i class="fa fa-eye"></i></a></td>--}}
	                	{{--<td>175</td>--}}
	                	{{--<td>ลด30%</td>--}}
	                	{{--<td>05/01/59</td>--}}
	                	{{--<td><span class="label label-danger">หมดเวลา</span></td>--}}
	                	{{--<td>สั่งซื้อ 1000 บาทขึ้นไป ต่อ 1 ออร์เดอร์ ต่อ 1 ผู้ใช้</td>--}}
	                	{{--<td>--}}
	                		{{--<div class="select">--}}
	                			{{--<input type="checkbox" name="selectQUO">--}}
	                			{{--<label for="selectQUO"><i class="fa fa-check-circle"></i></label>--}}
	                		{{--</div>--}}
	                	{{--</td>--}}
	                {{--</tr>--}}
              	</tbody>
            </table>
		</div>
	</div>
</div>
@stop
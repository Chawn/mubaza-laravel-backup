@extends('backend.layouts.master')
@section('css')
<style>

</style>
<script type="text/javascript">
	$(document).ready(function() { 
		$("#table").tablesorter(); 
	}); 
</script>
@stop
@section('content')

<div class="box">
    <div class="box-body">
        <table id="table" class="table text-center">
            <caption></caption>
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>ชื่อสินค้า</th>
                    <th>จำนวนคงเหลือ</th>
                    <th>อัพเดทล่าสุด</th>
                    <th>เครื่องมือ</th>
                </tr>
            </thead>
            <tbody>
                @for($i=1;$i<=10;$i++)
                <tr>
                    <td>{{ $i }}</td>
                    <td>เสื้อยืด Orginal คอกลม, Color,  Size</td>
                    <td>100</td>
                    <td>{{ Carbon::now() }}</td>
                    <td>
                        <a href="#">
                            <i class="fa fa-file-text-o"></i> ดาวน์โหลดใบสั่งซื้อ SKU {{ $i }}
                        </a>
                    </td>
                </tr>
                @endfor
            </tbody>
        </table>
        <div class="div-pagination">
            <div class="navbar-left">
                <p>แสดง 10 จาก 109</p>
            </div>
            <div class="navbar-right">
                <div class="a-pagination">
                    <a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>   
                    <a href="#">1</a>
                    <a href="#">2</a>
                    <a href="#">3</a>
                    <a href="#">4</a>
                    <a href="#">5</a>
                    <a href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
                </div>
            </div>
        </div><!-- end div-pagination -->
    </div>
</div>
	
@stop
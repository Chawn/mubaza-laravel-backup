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
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">เพิ่มการจัดซื้อใหม่</h4>
            </div>
            <div class="modal-body">
                <table class="table" >
                    <tbody>
                        <tr>
                            <td>SKU</td>
                            <td><input name="" type="text" class="form-control"></td>
                        </tr>
                        <tr>
                            <td>วันที่สั่งซื้อ</td>
                            <td><input name="" type="text" class="form-control"></td>
                        </tr>
                        <tr>
                            <td>จำนวน</td>
                            <td><input name="" type="text" class="form-control"></td>
                        </tr>
                        <tr>
                            <td>ราคาต่อหน่วย</td>
                            <td><input name="" type="text" class="form-control"></td>
                        </tr>
                        <tr>
                            <td>ค่าจัดส่ง</td>
                            <td><input name="" type="text" class="form-control"></td>
                        </tr>
                        <tr>
                            <td>ราคารวมสุทธิ</td>
                            <td><input name="" type="text" class="form-control"></td>
                        </tr>
                        <tr>
                            <td>หมายเหตุ</td>
                            <td><input name="" type="text" class="form-control"></td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default-shadow" data-dismiss="modal">
                    ปิด
                </button>
            </div>
        </div>
    </div>
</div>


<div class="box">
    <div class="box-body">
        <button class="btn btn-success btn-lg pull-right" data-toggle="modal" data-target="#modal">
                <i class="fa fa-plus">&nbsp;เพิ่มการจัดซื้อใหม่</i>
        </button> 
        <table id="table" class="table text-center">
            <caption></caption>
            <thead>
                <tr>
                    <th>วันที่สั่งซื้อ</th>
                    <th>SKU</th>
                    <th>จำนวน</th>
                    <th>ราคาต่อหน่วย</th>
                    <th>ค่าจัดส่ง</th>
                    <th>ราคารวมสุทธิ</th>
                    <th>หมายเหตุ</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ Carbon::now() }}</td>
                    <td>000001</td>
                    <td>100</td>
                    <td>฿<span>85</span></td>
                    <td>฿<span>200</span></td>
                    <td>฿<span>{{ (100*85)+200 }}</span></td>
                    <td></td>
                </tr>
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
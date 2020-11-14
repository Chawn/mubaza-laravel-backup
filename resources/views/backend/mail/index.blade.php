@extends('backend.layouts.master')
@section('css')
<style>

.table-mail {
	margin: 15px 0 0 0;
	font-weight:bold;
	}
.table-mail>tbody>tr>td:nth-child(3) {
    text-align: left;
    }
.table-mail .readed td {
	background:#FFF;
	color:#989898;
	font-weight:normal;
	}
#mail-tool {
	display:inline;
	}
#group-checkbox {
	width:130px;
	}
#mail-tools .form-group {
	margin: 15px 0 0 10px;
	}
#view-option {
	border:none;
	}
#view-option:hover {
	background:#ddd;
	}
.btn-gray {
	background:#f5f5f5;
	border:1px solid #ddd;
	border-radius:5px;
	height:35px;
	}

</style>

<script type="text/javascript">
	$(function() {
		$(".clickable-row").click(function() {
			window.document.location = $(this).data("href");
		});
		$('.clickable-row').on('click', 'td:first-child, td:last-child', function(e) {
    		e.stopPropagation();
		});
	});

	$(document).ready(function() { 
		$(".table-mail").tablesorter(); 
	}); 
</script>
@stop
@section('content')

<h3>ข้อความจากติดต่อเรา</h3>
<form class="form-inline">
    <div id="mail-tools">
    	<div class="form-group">
            <label id="group-checkbox" class="btn btn-gray">
                <input type="checkbox"> เลือกทั้งหมด
            </label>
        </div>
        <div class="form-group">
            <div class="btn-group">
              	<button type="button" class="btn btn-gray  dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                	ทั้งหมด <span class="caret"></span>
              	</button>
              	<ul class="dropdown-menu" role="menu">
                    <li><a href="#">ทั้งหมด</a></li>
                    <li><a href="#">อ่านแล้ว</a></li>
                    <li><a href="#">ยังไม่ได้อ่าน</a></li>
              	</ul>
            </div>
        </div>
        <div class="form-group">
        	<button id="btn-mail-delete" class="btn btn-danger"><i class="fa fa-trash-o"></i> ลบ</button>
        </div>
    </div>
</form>
<table class="table-mail table-radius">
	<thead>
        <tr>
        	<th></th>
            <th>ผู้ส่ง</th>
            <th>ข้อความ</th>
            <th>วันที่ส่ง</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
<div class="row">
    <div class="col-md-12">
        <nav class="pull-right">
          <ul class="pagination">
            <li>
              <a href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
            <li><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <li>
              <a href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          </ul>
        </nav>
    </div>
</div>

@stop
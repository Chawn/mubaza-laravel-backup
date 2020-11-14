@extends('backend.layouts.master')
@section('css')
<style>

#table-report h3 {
	display:inline;
	}	
#table-report h2 {
	font-size:14px;
	color:#666;
	}
#table-report>tbody>tr>td:nth-child(2) {
    text-align: left;
    }

.table-mail {
    margin: 15px 0 0 0;
    font-weight:bold;
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
	$(document).ready(function() { 
		$("#table-report").tablesorter();

	}); 
</script>
@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        <div id="report">
            <div class="col-md-8">
                <h3>แจ้งผู้ใช้ผิดกฏ</h3>
            </div>
            <div class="col-md-4">
                <div class="pull-right">
                <form class="form-inline">
                    <div>
                        {{--<div class="form-group">--}}
                            {{--<label id="group-checkbox" class="btn btn-gray">--}}
                                {{--<input type="checkbox"> เลือกทั้งหมด--}}
                            {{--</label>--}}
                        {{--</div>--}}
                        <div class="form-group">
                            <div class="btn-group">
                                <button type="button" class="btn btn-gray  dropdown-toggle" data-toggle="dropdown"
                                        aria-expanded="false">
                                    ทั้งหมด <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">ทั้งหมด</a></li>
                                    <li><a href="#">อ่านแล้ว</a></li>
                                    <li><a href="#">ยังไม่ได้อ่าน</a></li>
                                </ul>
                            </div>
                        </div>
                        {{--<div class="form-group">--}}
                            {{--<button id="btn-mail-delete" class="btn btn-danger"><i class="fa fa-trash-o"></i> ลบ--}}
                            {{--</button>--}}
                        {{--</div>--}}
                    </div>
                </form>
                    </div>
            </div>
            <div class="clear-fix">&nbsp;</div>
            <table id="table-report" class="table-radius">
                <thead>
                <tr>
                    <th>วันที่แจ้งเรื่อง</th>
                    <th>ผู้ร้องเรียน</th>
                    <th>เรื่องที่แจ้ง</th>
                    <th>ผู้ใช้งานที่ถูกร้องเรียน</th>
                    <th>แคมเปญที่ถูกร้องเรียน</th>
                    <th>รายละเอียด</th>
                </tr>
                </thead>
                <tbody> <!-- 10 row -->
                @forelse($reports as $report)
                    <tr>
                        <td>{{ $report->created_at->format('d/m/Y H:i') }}</td>
                        <td><a href="{{ action('UserController@getIndex', $report->reporter->getID()) }}">{{ $report->reporter->full_name }}</a></td>
                        <td>{{ $report->type->detail }}</td>
                        <td>
                            @if(is_null($report->user))
                                -
                            @else
                                <a href="{{ action('UserController@getIndex', $report->user->getID()) }}">{{ $report->user->full_name }}</a>
                            @endif
                        </td>
                        <td>@if(is_null($report->campaign))
                                -
                            @else
                                <a href="{{ action('SellController@showCampaign', $report->campaign->url) }}">{{ $report->campaign->title }}</a>
                            @endif
                        </td>
                        <td>{{ $report->detail }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">ไม่มีข้อมูล</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
    </div>
</div>


</div><!-- end report -->
<div class="row">
    <div class="col-md-12">
        {!! str_replace('/?', '?', $reports->render()) !!}
    </div>
</div>
@stop
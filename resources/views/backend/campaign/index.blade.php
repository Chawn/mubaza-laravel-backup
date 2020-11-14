@extends('backend.layouts.master')
@section('css')
<style>
    #table-campaign-detail>tbody>tr>td:nth-child(2){
        text-align: left;
    }
    .recommended {
        color: #f0ad4e;
    }
    

</style>
@stop
@section('script')
<script type="text/javascript">
    $(document).ready(function() { 
        $("#table-campaign-detail").tablesorter();
        $("#paginate-select").change(function() {
            window.location = $(this).val();
        });
    }); 
</script>
@stop
@section('content')
<div class="row">
    <div class="col-md-9">
        <div class="box">
            <div class="box-header">
                <div class=" form-inline">
                    <div class="row">
                        <div class="col-sm-4 col-xs-4">
                            <div class="dataTables_length" id="example1_length">
                                <div class="pull-left">
                                    <label>Show 
                                        <select name="example1_length" id="paginate-select" aria-controls="example1" class="form-control input-sm">
                                            <option value="{{ action('BackendController@getCampaign', 16) }}{{ $criteria == '' ? '' : '?criteria=' . $criteria }}{{ $keyword == '' ? '' : '&q=' . $keyword }}" {{ $paging == 16 ? 'selected' : '' }}>16</option>
                                            <option value="{{ action('BackendController@getCampaign', 24) }}{{ $criteria == '' ? '' : '?criteria=' . $criteria }}{{ $keyword == '' ? '' : '&q=' . $keyword }}" {{ $paging == 24 ? 'selected' : '' }}>24</option>
                                            <option value="{{ action('BackendController@getCampaign', 32) }}{{ $criteria == '' ? '' : '?criteria=' . $criteria }}{{ $keyword == '' ? '' : '&q=' . $keyword }}" {{ $paging == 32 ? 'selected' : '' }}>32</option>
                                        </select> รายการ
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-8 col-xs-8">
                            <div id="example1_filter" class="dataTables_filter">
                                <div class="pull-right">
                                    <label>
                                        <form action="{{ action('BackendController@getCampaign') }}">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <select class="form-control" name="criteria" id="criteria">
                                                        <option value="id" {{ $criteria == 'id' ? 'selected' : '' }}>รหัสแคมเปญ</option>
                                                        <option value="title" {{ $criteria == 'title' ? 'selected' : '' }}>ชื่อแคมเปญ</option>
                                                        <option value="creator_name" {{ $criteria == 'creator_name' ? 'selected' : '' }}>ชื่อ Creator</option>
                                                        <option value="creator_id" {{ $criteria == 'creator_id' ? 'selected' : '' }}>รหัส Creator</option>
                                                        <option value="tag" {{ $criteria == 'tag' ? 'selected' : '' }}>แท็ก</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" name="q" placeholder="ใส่คำค้น.." value="{{ $keyword ? $keyword : '' }}">
                                                         
                                                </div>
                                            </div>
                                        </form>
                                    </label>
                                </div>
                            </div>
                        </div>
                       
                        
                    </div>
                </div>
            </div>
            <div class="box-body box-product">
                <div class="row">
                    @foreach($campaigns as $campaign)
                    <div class="col-md-3 col-sm-6 col-xs-6 col-mobile">
                        @include('backend.campaign.product-box',array('campaign'=>$campaign))
                    </div>
                    @endforeach
                </div>
                <div class="row-fluid">
                    <div class="col-sm-12">
                        <div class="div-pagination">
                            <div class="navbar-right">
                                {!! str_replace('/?', '?', $campaigns->render()) !!}
                            </div>
                        </div><!-- end div-pagination -->
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">เครื่องมือ</h3>
            </div>
            <div class="box-body box-product">
                <input type="checkbox" name="" id="show-wait" value="">
                <label for="show-wait">
                    แสดงเฉพาะที่รอการตรวจสอบ
                </label>
                <br>

                <input type="checkbox" name="" id="show-active" value="">
                <label for="show-active">
                    แสดงเฉพาะที่อนุมัติแล้ว
                </label>
                <br>

                <input type="checkbox" name="" id="show-banned" value="">
                <label for="show-banned">
                    แสดงเฉพาะที่ไม่อนุมัติ
                </label>
                    
            </div>
        </div>
    </div>
</div>

@stop
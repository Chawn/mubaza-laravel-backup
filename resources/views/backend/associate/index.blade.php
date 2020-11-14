@extends('backend.layouts.master')
@section('css')
<style>

#table-manufacture-detail h3 {
    display:inline;
    }   
#table-manufacture-detail h2 {
    font-size:14px;
    color:#666;
    }
#table-manufacture-detail>tbody>tr>td:nth-child(2){
    text-align: left;
}
#table-manufacture-detail>tbody>tr>td:nth-child(3){
    text-align: left;
}
</style>
<script type="text/javascript">
    $(document).ready(function() { 
        $("#table-manufacture-detail").tablesorter();

        $('#confirm-ban').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var url = button.data('url');// Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.modal-body form').attr('action', url);
        });

        $('#confirm-ban-btn').click(function() {
           $('#confirm-ban-form').submit();
        });

        $(".reason-radio").change(function(){
            $('#remark').val($(this).val());
        });

        $("#paginate-select").change(function() {
            window.location = $(this).val();
        });
    }); 
</script>
@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        @include('backend.layouts.include.alert')
    </div>
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
            </div>

            <div class="box-body">
                <div class=" form-inline">
                    <div class="row">
                        <div class="col-sm-5 col-xs-5">
                            <div class="dataTables_length" id="example1_length">
                                <label>แสดง
                                    <select name="paginate_select" id="paginate-select" class="form-control input-sm">
                                        <option value="{{ action('BackendController@getAssociate', 10) }}{{ $keyword == '' ? '' : '?q=' . $keyword }}" {{ $paging == 10 ? 'selected' : '' }}>10</option>
                                        <option value="{{ action('BackendController@getAssociate', 25) }}{{ $keyword == '' ? '' : '?q=' . $keyword }}" {{ $paging == 25 ? 'selected' : '' }}>25</option>
                                        <option value="{{ action('BackendController@getAssociate', 50) }}{{ $keyword == '' ? '' : '?q=' . $keyword }}" {{ $paging == 50 ? 'selected' : '' }}>50</option>
                                        <option value="{{ action('BackendController@getAssociate', 100) }}{{ $keyword == '' ? '' : '?q=' . $keyword }}" {{ $paging == 100 ? 'selected' : '' }}>100</option>
                                    </select> ต่อหน้า
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-7 col-xs-7">
                            <div class="pull-right">
                                <label>
                                    <form action="{{ action('BackendController@getAssociate') }}">
                                        ค้นหา: <input type="text" class="form-control" name="q"
                                                      placeholder="ค้นหา ชื่อ อีเมล์ หรือ ชื่อผู้ใช้"
                                                      value="{{ $keyword ? $keyword : '' }}">

                                    </form>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="table-campaign-detail" class="table table-bordered table-striped dataTable">
                    <thead>
                        <tr>
                            <th>รหัส Associate</th>
                            <th>ชื่อ-นามสกุล</th>
                            <th>อีเมล์</th>
                            <th>สถานะ</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($associates as $associate)
                        <tr data-href="{{ action('BackendController@getAdminDetail', $associate->id) }}"><!-- loop -->
                            <td class="col-id">{{ $associate->id }}</td>
                            <td class="col-name">
                                <span>{{ $associate->user->full_name }}</span>
                            </td>
                            <td class="col-overflow">{{ $associate->user->email }}</td>
                            <td>{{ $associate->status->detail }}</td>
                            <td>
                                @if($associate->status->name === \App\AssociateStatus::ACTIVE)
                                    <a href="{{ action('BackendController@getDisableAssociate', [$associate->id, \App\AssociateStatus::DISABLE]) }}" class="btn btn-danger btn-block" ><i class="fa fa-stop"></i> ปิดการใช้งาน</a>
                                @elseif($associate->status->name == \App\AssociateStatus::DISABLE)
                                    <a href="{{ action('BackendController@getActivateAssociate', [$associate->id, \App\AssociateStatus::ACTIVE] ) }}" class="btn btn-success btn-block" ><i class="fa fa-check"></i> เปิดการใช้งาน</a>
                                @endif
                            </td>
                            <td>
                                <a href="{{ action('BackendController@getUserDetail', $associate->user->id) }}" class="btn btn-default">
                                    <i class="fa fa-search"></i> ดู
                                </a>
                            </td>
                        </tr><!--end loop -->
                        @endforeach
                    </tbody>
                </table>
                <div class="div-pagination">
                    <div class="navbar">
                        {!! str_replace('/?', '?', $associates->render()) !!}
                    </div>
                </div><!-- end div-pagination -->
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="confirm-ban">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">ยืนยันการระงับการใช้งานชื่อผู้ใช้นี้</h4>
            </div>
            <div class="modal-body">
                <p><h4>เหตุผลในการระงับการใช้งาน</h4></p>
                <label>
                    <input class="reason-radio" name="band-reason" type="radio" value="มีการร้องเรียนและเราตรวจพบว่าบัญชีผู้ใช้นี้ ได้ลอกเลียนแบบผู้ใช้ที่เป็นเจ้าของแบรน">
                     บัญชีผู้ใช้ปลอม หรือลอกเลียนแบบผู้ใช้ที่เป็นเจ้าของแบรน
                </label>
                <label>
                    <input class="reason-radio" name="band-reason" type="radio" value="พบการละเมิดลิขสิทธิ์ในหลายแคมเปญของบัญชีผู้ใช้นี้">
                     พบการละเมิดลิขสิทธิ์ในหลายแคมเปญของบัญชีผู้ใช้นี้
                </label>
                <label>
                    <input class="reason-radio" name="band-reason" type="radio" value="ทำให้ผู้ใช้ท่านอื่นได้รับความเสียหายต่อสินค้าหรือตัวบุคคล">
                    ทำให้ผู้ใช้ท่านอื่นได้รับความเสียหายต่อสินค้าหรือตัวบุคคล
                </label>
                
                <label>
                    <input class="reason-radio" name="band-reason" type="radio" value="อธิบายอย่างละเอียด และใช้หลักไวยากรณ์ให้ถูกต้อง">
                    อื่นๆ ระบุ:
                    <br>
                    <form class="form" id="confirm-ban-form" action="">
                        <div class="form-group">
                            <textarea name="remark" id="remark" cols="50" rows="10" class="form-control"></textarea>
                        </div>
                    </form>
                </label>

                
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-lg btn-default" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;ปิด</button>
                <button type="button" class="btn btn-lg btn-primary" id="confirm-ban-btn"><i class="fa fa-check"></i>&nbsp;ยืนยัน</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End comfirm dialog box -->
@stop
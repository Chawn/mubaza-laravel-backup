@if(\Auth::user()->check())
    <!-- Modal -->
<div class="modal fade" id="report-modal" tabindex="-1" role="dialog" aria-labelledby="reportLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-flag"></i>&nbsp;รายงานปัญหา</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-success" id="success" role="alert" style="display: none"><strong>เสร็จเรียบร้อย</strong>&nbsp;ข้อมูลการรายงานได้ถูกส่งเรียบร้อยแล้ว</div>
                <div class="report-group">
                    <div class="form-group">
                    <label for="subject">เรื่อง:</label>
                    <input type="text" class="form-control" id="subject" placeholder="เรื่องที่ต้องการรายงาน">
                </div>
                <div class="form-group">
                    <label for="detail">ข้อความ</label>
                    <textarea name="detail" id="detail" class="form-control" cols="30" rows="10"></textarea>
                </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-primary" id="send-report-button"
                        data-token="{{ csrf_token() }}"
                        data-url="{{ action('HomeController@postReport', \Auth::user()->user()->id) }}">
                    <i class="fa fa-check"></i>&nbsp;บันทึก</button>
            </div>
        </div>
    </div>
</div>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#report-modal">
    รายงานปัญหา
</button>
    @endif
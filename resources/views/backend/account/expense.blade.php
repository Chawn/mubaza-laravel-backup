@extends('backend.layouts.master')
@section('css')
<style>


#table-account-detail {
    margin: 15px 0 0 0;
    }

#d1 {
    width:15px;
    height:15px;
    color:#61a9dc;
    display:inline;
    padding-right:15px;
    }
#d2 {
    width:15px;
    height:15px;
    color:#f0831c;
    display:inline;
    padding-right:15px;
    }
#d3 {
    width:15px;
    height:15px;
    color:#92cd18;
    display:inline;
    padding-right:15px;
    }
</style>
<script type="text/javascript">
    $(document).ready(function() { 
        $("#table-account-detail").tablesorter(); 
    });
    

// piechart ใสจำนวนตรง value ได้เลยนะคะ
    var pieData = [
                // จัดซื้อ
                {
                    value: 300,
                    color:"#61a9dc",
                    highlight: "#7fc0ee",
                    label: "จัดซื้อ"
                },
                {
                    value: 50,
                    color: "#f0831c",
                    highlight: "#fd9635",
                    label: "เงินเดือน"
                },
                {
                    value: 100,
                    color: "#92cd18",
                    highlight: "#a4df29",
                    label: "ขนส่ง"
                },
                

            ];

            window.onload = function(){
                var ctx = document.getElementById("chart-area").getContext("2d");
                window.myPie = new Chart(ctx).Pie(pieData);
            };
        
    $(document).ready(function(){
    $(".a-button-group-account-rate").click(function(){
        $(".a-button-group-account-rate.rate").removeClass("rate");
        $(this).addClass("rate");
    });
});    
</script>
@stop

@section('content')
<div class="header-account">
    <div class="col-md-6 ">
        <div class="header-account-date">
            <h4>ประจำวันที่ 21-04-2558 ถึง21-04-2558</h4>
            
        </div>
    </div>
    <div class="col-md-6 ">
        <!-- "here" is active of menu-account-group class -->
        <div class="head-menu-account-group">
            <a class="btn head-menu-account " href="http://localhost/mubaza/public/backend-account">ภาพรวม</a>
            <a class="btn head-menu-account" href="http://localhost/mubaza/public/backend-account-income">รายรับ</a>
            <a class="btn head-menu-account here" href="http://localhost/mubaza/public/backend-account-expense">รายจ่าย</a>
        </div>
    </div>
    <div class="col-md-12 ">
        <!-- "this" is active of a-sub-menu-account class -->
        <div class="sub-menu-account">
            <a class="a-sub-menu-account this" href="http://localhost/mubaza/public/backend-account-expense">ทั้งหมด</a>
            <a class="a-sub-menu-account" href="http://localhost/mubaza/public/backend-account-expense-purchase">จัดซื้อ</a>
            <a class="a-sub-menu-account" href="#">เงินเดือน</a>
            <a class="a-sub-menu-account" href="#">ขนส่ง</a>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="account-detail">
        <div class="col-md-4">
            <div class="pricetag">
                <h2>3647</h2><p>บาท</p>
            </div>
            รายจ่ายทั้งหมด
        </div>
        <div class="col-md-4">
            <div class="canvas-holder">
                <canvas id="chart-area" width="150" height="150"/>
            </div>
            <div class="canvas-detail">
                <ul>
                    <li><i id="d1" class="fa fa-stop"></i>จัดซื้อ</li>
                    <li><i id="d2" class="fa fa-stop"></i>เงินเดือน</li>
                    <li><i id="d3" class="fa fa-stop"></i>ขนส่ง</li>
                </ul>
            </div>
        </div>
        <div class="col-md-4">
            <div class="button-group-account-rate btn-group-vertical">
                <a class="btn a-button-group-account-rate rate" href="#"><i class="fa fa-clock-o"></i>รายวัน</a>
                <a class="btn a-button-group-account-rate" href="#"><i class="fa fa-clock-o"></i>รายสัปดาห์</a>
                <a class="btn a-button-group-account-rate" href="#"><i class="fa fa-clock-o"></i>รายเดือน</a>
                <a class="btn a-button-group-account-rate" href="#"><i class="fa fa-calendar"></i>เลือกวัน</a>
            </div>
        </div>
        <div class="col-md-12">
            <table id="table-account-detail" class="table-radius">
                <thead>
                    <tr>
                        <th width="5%">ลำดับ</th>
                        <th width="15%">หมายเลขใบสั่งซื้อ</th>
                        <th width="10%">วันที่</th>                
                        <th width="45%">รายการ</th>
                        <th width="10%">จำนวน</th>
                        <th width="15%">เป็นเงิน(บาท)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="clickable-row" data-href="#">
                        <td>001</td>
                        <td>BO100099</td>
                        <td>23-03-2558</td>
                        <td>เสื้อยืดสีขาว</td>
                        <td>150</td>
                        <td>1500</td>
                    </tr>
                    <tr class="clickable-row" data-href="#">
                        <td>002</td>
                        <td>BO100099</td>
                        <td>23-03-2558</td>
                        <td>เสื้อยืดสีขาว</td>
                        <td>150</td>
                        <td>2500</td>
                    </tr>
                    <tr class="clickable-row" data-href="#">
                        <td>003</td>
                        <td>BO100099</td>
                        <td>23-03-2558</td>
                        <td>เสื้อยืดสีขาว</td>
                        <td>150</td>
                        <td>3000</td>
                    </tr>
                    <tr class="clickable-row" data-href="#">
                        <td>004</td>
                        <td>BO100099</td>
                        <td>23-03-2558</td>
                        <td>เสื้อยืดสีขาว</td>
                        <td>150</td>
                        <td>4000</td>
                    </tr>
                    <tr class="clickable-row" data-href="#">
                        <td>005</td>
                        <td>BO100099</td>
                        <td>23-03-2558</td>
                        <td>เสื้อยืดสีขาว</td>
                        <td>150</td>
                        <td>5500</td>
                    </tr>
                    <tr class="clickable-row" data-href="#">
                        <td>006</td>
                        <td>BO100099</td>
                        <td>23-03-2558</td>
                        <td>เสื้อยืดสีขาว</td>
                        <td>150</td>
                        <td>6000</td>
                    </tr>
                    <tr class="clickable-row" data-href="#">
                        <td>007</td>
                        <td>BO100099</td>
                        <td>23-03-2558</td>
                        <td>เสื้อยืดสีขาว</td>
                        <td>150</td>
                        <td>7000</td>
                    </tr>
                    <tr class="clickable-row" data-href="#">
                        <td>008</td>
                        <td>BO100099</td>
                        <td>23-03-2558</td>
                        <td>เสื้อยืดสีขาว</td>
                        <td>150</td>
                        <td>8000</td>
                    </tr>
                    <tr class="clickable-row" data-href="#">
                        <td>009</td>
                        <td>BO100099</td>
                        <td>23-03-2558</td>
                        <td>เสื้อยืดสีขาว</td>
                        <td>150</td>
                        <td>9000</td>
                    </tr>
                    <tr class="clickable-row" data-href="#">
                        <td>0010</td>
                        <td>BO100099</td>
                        <td>23-03-2558</td>
                        <td>เสื้อยืดสีขาว</td>
                        <td>150</td>
                        <td>1010</td>
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
    </div><!-- end account-detail -->
</div><!-- col-md-12 -->
<div class="col-md-12 account-clear"></div>
@stop
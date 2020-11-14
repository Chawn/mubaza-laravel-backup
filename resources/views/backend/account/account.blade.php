@extends('backend.layouts.master')
@section('css')
<style>
h4 {
  margin-left:20%;
  }
#index-title {
  height:50px;
  font-size:24px;
  font-weight:bold;
  text-align:center;
  }
#canvas-holder2 {
  margin: 20px 25%;
  }
#chartjs-tooltip {
  opacity: 1;
  position: absolute;
  background: rgba(0, 0, 0, .7);
  color: white;
  padding: 3px;
  border-radius: 3px;
  -webkit-transition: all .1s ease;
  transition: all .1s ease;
  pointer-events: none;
  -webkit-transform: translate(-50%, 0);
  transform: translate(-50%, 0);
  }
.chartjs-tooltip-key{
  display:inline-block;
  width:10px;
  height:10px;
    }
</style>
<script>
$( document ).ready(function() {
  $('#circle-campaign').circliful();
  $('#circle-new-campaign').circliful();
  $('#circle-balance').circliful();
});

var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
    var lineChartData = {
      labels : ["ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค."],
      datasets : [
        {
          label: "รายรับ",
          fillColor : "rgba(255,255,255,0.2)",
          strokeColor : "#227FC0",
          pointColor : "#61A9DC",
          pointStrokeColor : "#fff",
          pointHighlightFill : "#61A9DC",
          pointHighlightStroke : "#61A9DC",
          /*ใส่ขอมูลดิบได้เลยนะคะ เรียงตามเดือน ส่วนในช่องถัดไป เอาฟังชั่นแรนดอมออก ใส่ตามอาเร*/
          data : ["100","20","30","40","50","60","70","80","70","60","50","40",]
        },
        {
          label: "รายจ่าย",
          fillColor : "rgba(255, 255, 255,0.2)",
          strokeColor : "#C96505",
          pointColor : "#A65100",
          pointStrokeColor : "#fff",
          pointHighlightFill : "#F6C049",
          pointHighlightStroke : "#F6C049",
          data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
        },
        {
          label: "แคมเปญเปิดใหม่",
          fillColor : "rgba(255, 255, 255,0.2)",
          strokeColor : "#76A909",
          pointColor : "#5F8C00",
          pointStrokeColor : "#fff",
          pointHighlightFill : "#93CD18",
          pointHighlightStroke : "#93CD18",
          data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
        }
      ]

    }

  window.onload = function(){
    var ctx = document.getElementById("canvas").getContext("2d");
    window.myLine = new Chart(ctx).Line(lineChartData, {
      responsive: true
    });
  }

</script>

@stop
@section('content')
<div class="col-md-12">
  <div id="index-title">
      เดือนกุมภาพันธ์ 2558
    </div>
</div>
</div>


<!-- ########## col 1 ########## -->
<div class="col-md-8">
    <div>
      <canvas id="canvas" height="350" width="600"></canvas>
    </div>
</div><!-- col -->

<!-- ########## col 2 ########## -->
<div class="col-md-4">
  <h4>รายรับ/รายจ่าย</h4>
  <div id="circle-balance" data-dimension="250" data-width="30" data-fontsize="38" data-percent="80" data-fgcolor="#92cd18" data-bgcolor="#eee" data-fill="#ddd" onclick="location.href='backend-account-revenue';">
      <span class="circle-text">80%</span>
      <span class="circle-info">กำไร</span>
    </div>
  <div class="box-static">
      <h>วันนี้</h>
        <table>
          <tr>
              <td><p1>รายรับ :</p1><p>45678 </p></td>
                <td><p>567</p><p2>: รายจ่าย</p2></td>
            </tr>
        </table>
        <div class="progress">
        <div class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
        </div>
        </div>
    </div><!-- box-static -->
    <div class="box-static">
      <h>เดือนที่แล้ว</h>
        <table>
          <tr>
              <td><p1>รายรับ :</p1><p>45678 </p></td>
                <td><p>567</p><p2>: รายจ่าย</p2></td>
            </tr>
        </table>
        <div class="progress">
        <div class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
        </div>
        </div>
    </div><!-- box-static -->
    <div class="box-static">
      <h>ไตรมาศ 2 (เมษายน - มิถุนายน)</h>
        <table>
          <tr>
              <td><p1>รายรับ :</p1><p>45678 </p></td>
                <td><p>567</p><p2>: รายจ่าย</p2></td>
            </tr>
        </table>
        <div class="progress">
        <div class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
        </div>
        </div>
    </div><!-- box-static -->
    <div class="box-static">
      <h>รายปี</h>
        <table>
          <tr>
              <td><p1>รายรับ :</p1><p>45678 </p></td>
                <td><p>567</p><p2>: รายจ่าย</p2></td>
            </tr>
        </table>
        <div class="progress">
        <div class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
        </div>
        </div>
    </div><!-- box-static -->
    
</div><!-- col -->
@stop
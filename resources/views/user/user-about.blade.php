@extends('user.layouts.master')
@section('css')
<style>
.media{
	border: 1px solid transparent;
	padding: 10px;
}
.media:hover {
	border: 1px solid #ddd;
	box-shadow: 2px 2px 5px #ddd;
}
.media-left {
	width: 120px;
}
.media-left img {
	max-width: 115px;
}
@media(max-width: 480px){
    #user-header #about #u-favorite{
        display: none;
    }
}

</style>
@stop
@section('content')
<div class="row">
   <div class="row ">
        <div class="col-sm-12">
            <div class="box-blank">
                <div class="box-header ">
                   
                </div>
                <div class="box-body box-product">
                    <table class="table borderless margin-center" style="width:500px">
                        <tr>
                            <td>ชื่อ-นามสกุล</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>เบอร์โทรศัพท์</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>อีเมล</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Facbook</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Line ID:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Website:</td>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </div>
       </div>
    </div>
</div>
@stop
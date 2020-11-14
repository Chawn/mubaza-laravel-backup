@extends('manager.layouts.master')
@section('script')
    <script src="{{ asset('js/hashids.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#agree-terms").change(function() {
                var element = $(this);
                if(element.prop("checked")) {
                    $("#register-btn").removeAttr("disabled");
                } else {
                    $("#register-btn").attr("disabled", true);
                }
            });
        });
    </script>
@stop
@section('css')
    <style type="text/css" media="screen">
        .box{
            background: #fff;
            border: solid 1px #ddd;
            border-radius: 4px;
            margin-bottom: 20px;
            padding: 25px;
        }
        i.green {
            color: #00c300;
        }
    </style>
@stop
@section('content')

    <div class="row">
        @include('manager.register.registration-step', ['step' => '3'])
        <div class="col-sm-12">
            <h2><i class="fa fa-check-circle green"></i>&nbsp;การลงทะเบียนสำเร็จแล้ว&nbsp;<a href="{{ action('AssociateController@getCreate') }}">เริ่มออกแบบ</a></h2>
        </div>
    </div>
    </div>
@stop
@extends('manager.layouts.master')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop
@section('script')
    <script src="{{ asset('js/hashids.min.js') }}"></script>
    @if(!\Auth::user()->check())
        <script>
            $(document).ready(function () {
                $("#designer-form input").attr("disabled", true);
                $("#designer-form a").attr("disabled", true);
            });
        </script>
    @else
        <script>
            $(document).ready(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $("#agree-terms").change(function () {
                    var element = $(this);
                    if (element.prop("checked")) {
                        $("#register-btn").removeAttr("disabled");
                    } else {
                        $("#register-btn").attr("disabled", true);
                    }
                });

                $("#send-otp").click(function () {
                    var element = $(this);
                    $.ajax({
                        type: "POST",
                        url: "/manager/send-otp",
                        dataType: "json",
                        success: function (data) {
                            if (data.success) {
                                $("#ref-no").html("(Ref No. " + data.ref_no + ")");
                                $("#otp-input").removeAttr("disabled");
                                $("#activate-button").removeAttr("disabled");
                                $("#otp-input").focus();
                                element.html("ส่งรหัส OTP อีกครั้ง");
                            }
                        },
                        failure: function (errMsg) {
                            alert(errMsg);
                        }
                    });
                });
            });
        </script>
    @endif
@stop
@section('css')
    <style type="text/css" media="screen">
        .box {
            background: #fff;
            border: solid 1px #ddd;
            border-radius: 4px;
            margin-bottom: 20px;
            padding: 25px;
        }
    </style>
@stop
@section('content')
    <div class="row">
        @include('manager.register.registration-step', ['step' => '3'])
        <div class="col-sm-6 col-sm-offset-3">
            <div class="box-create box-border">
                <div class="box-header">
                </div>
                <div class="box-body">
                    @foreach ($errors->all() as $error)
                        <p class="error">{{ $error }}</p>
                    @endforeach
                    <form action="{{ action('AssociateController@postActivate', $type) }}" method="post">
                        {{ csrf_field() }}
                        <table class="table">
                            <tbody>
                            <tr>
                                <td>หมายเลขโทรศัพท์</td>
                                <td>{{ str_pad(substr(\Auth::user()->user()->profile->phone, 6, 4), 10, 'X', STR_PAD_LEFT) }}</td>
                                <td><a href="javascript:void(0)" class="btn btn-warning" id="send-otp">ส่งรหัส OTP</a>
                                </td>
                            </tr>
                            <tr>
                                <td>รหัส OTP</td>
                                <td><input type="text" class="form-control" name="otp" id="otp-input" value="{{ old('otp') }}" required></td>
                                <td><span class="glyphicon glyphicon-exclamation"></span><span id="ref-no"></span></td>
                            </tr>
                            <tr>
                                <td colspan="3" align="right">
                                    <button class="btn btn-success btn-lg btn-block" id="activate-button">ยืนยัน</button>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
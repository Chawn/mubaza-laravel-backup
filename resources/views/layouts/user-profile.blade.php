<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- tag for responsive -->
    <meta name="viewport" content="width=device-width; initial-scale = 1.0; maximum-scale=1.0; user-scalable=no" />
    <title>{{ $title }}</title>

    @yield('meta')
    @include('layouts.include.head')
    <link rel="stylesheet" href="{{ asset('css/user-header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user-dashboard.css') }}">
    <script>
        $(document).ready(function() {

           $('#search-input').keyup(function(e) {
               var code = e.which;
               if(code == 13) {
                   window.location = "{{ url('search') }}/" + $(this).val();
               }
           }) ;

            $('input[name=avatar_file]').change(function() {
                $('#avatar-form').submit();
            });

            $('input[name=cover_file]').change(function() {
                $('#cover-form').submit();
            });

        });        
        $(document).ready(
                function () {
                    $(".un-follow").click(function () {
                        userSubscribe($(this));
                        $(".follow-btn").show();
                        $('.un-follow').hide();
                    });
                     $(".follow-btn").click(function () {
                        userSubscribe($(this));
                        $(".follow-btn").hide();
                        $('.un-follow').show();
                    });
                    function userSubscribe(btn) {
                        $.ajax({
                            type: "GET",
                            url: btn.attr('data-url'),
                            dataType: "json",
                            success: function (data) {
                                if (!data.error) {
                                    console.log(data);
//                                    loadUserSubscribe();
                                }
                            },
                            failure: function (errMsg) {
                                alert(errMsg);
                            }
                        });
                    }
                });
        $(document).ready(function () {
            $('#user-campaign-view-img-back').hide();
            $("#flip-font").click(function () {
                $("#user-campaign-view-img-font").show();
                $("#user-campaign-view-img-back").hide();
            });
            $("#flip-back").click(function () {
                $("#user-campaign-view-img-font").hide();
                $("#user-campaign-view-img-back").show();
            });
            $(".btn-backend-flip-img").click(function() {
                $(".btn-backend-flip-img.flip-choose").removeClass("flip-choose");
                $(this).addClass("flip-choose");
            });
            $('#report-detail').hide();
            $("#radio-other").click(function () {
                $("#detail").show();
            });
            $("#radio-content").click(function () {
                $("#detail").hide();
            });
            $("#radio-copyright").click(function () {
                $("#detail").hide();
            });


            $('#profile-image-lg').load(function()
            {
                if($(this).height > $(this).width)
                {
                    $(this).addClass('full-width');
                    $(this).removeClass('full-height');
                }
                else
                {
                    $(this).addClass('full-height');
                    $(this).removeClass('full-width');
                }
            });
        });
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    @yield('css')
    @yield('script')
</head>
<body>
<div id="container" class="container-fulid">
    @include('layouts.include.header')
    <div class="main">
        @include('layouts.include.user-header')
        <div class="container">
            <div class="user-account">
                <h3><i class="fa fa-user"></i>&nbsp;ตั้งค่าบัญชีผู้ใช้</h3>
                <hr />
                <div class="row">
                    <div class="col-sm-4 ">
                         @include('user_dashboard.profile-menu')
                    </div>           
                    @if(\Auth::user()->check())
                        <input name="_token" type="hidden" id="token" value="{{ csrf_token() }}"/>
                        <input name="user_id" type="hidden" id="user-id" value="{{ \Auth::user()->user()->id }}"/>
                    @endif
                    <div class="col-md-8 col-sm-9 col-xs-9">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.include.footer')
@yield('script-footer')
</body>
</html>

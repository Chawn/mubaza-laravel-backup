<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- tag for responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-site-verification" content="CLbC6KkSq653BZtWUFzlQU4y7TuwAb8CTykUdQwvvoc" />
    <title>{{ $title }} : {{ config('profile.sitename') }}</title>
    @yield('meta')
    @include('layouts.include.head')
    <style>
    .content-header .title{
        font-weight: bold;
    }
    .content-wrapper{
        width: 100%;
        margin: 0;
    }
    
    .main-footer{
        margin-left: 0;
    }
    
    .font-big{
        font-size: 16px;
        font-weight: bold;
       
    }
    .sub-title{
        margin: 25px 0 ;
    }
    .linetext{
        border-bottom: solid 1px #eee;
    }
    .linetext span{
        padding-left:15px;
        color: #999;
    }
    img.show-profile-img{
        width: 100px;
    }
    section{
        padding: 0;
    }
    .wrapper-profile-box .picture{
            height: 235px;
            overflow: hidden;
    }
    .wrapper-profile-box .picture img{
        width: 100%;
    }
    #dropdown-useraccount{
        padding-top: 15px;
        padding-bottom: 15px;
    }
    .inputfile{
        width: 0.1px;
        height: 0.1px;
        opacity: 0;
        overflow: hidden;
        position: absolute;
        z-index: -1;
    }
    #label-avatar:hover{
        text-decoration: underline;
        cursor: pointer;
    }
    @media(min-width: 768px) and (max-width: 991px){
        .nav > li{
            display: inline-block;
        }
    }
    @media(max-width: 767px){
        #useraccount-dropdown-menu{
            background: #BABCBD;
            color:#fff;
        }
        .pagin{
            display: block;
            margin: 25px 0;
        }
    }
    </style>
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
                    $("#input-avatar").on("change", function() {
                        $("#avatar-form").submit();
                    });
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
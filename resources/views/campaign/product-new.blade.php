@extends('layouts.full_width')
@section('meta')
    <meta name="description" content="{!! $campaign->title !!}"/>
    <meta property="og:title" content="{{ $title }}"/>
    <meta property="og:type" content="product"/>
    <meta property="og:url" content="{{ Request::url() }}"/>
    <meta property="og:image" content="{{ $campaign->back_cover ? $campaign->design->image_back_preview : $campaign->design->image_front_preview  }}"/>
    <meta property="og:site_name" content="MUBAZA"/>
    <meta property="fb:admins" content="USER_ID"/>
    <meta property="og:description" content="{{ strip_tags($campaign->description) }}"/>
@stop
@section('css')
    <style>
        #campaign-description {
            font-size: 15px;
            padding: 15px 0;
        }

        .text-indent {
            text-indent: 40px;
        }

        .text-bold {
            font-weight: bold;
        }

        .error {
            border-color: #f00;
        }

        #goal {
            display: table;
            width: 100%;
        }

        #goal .end-text {
            font-size: 24px;
            color: #36465D;
        }

        #goal .box {
            vertical-align: middle;
            display: table-cell;
            padding: 5px 5px 0px 5px;
            color: #36465D;
            text-align: center;
            /*border-right: solid 1px #ddd;*/
        }

        #goal .title {
            font-weight: 400;
            font-size: 20px;
        }

        #goal .detail {
            font-size: 24px;
        }

        #goal .box:last-child {
            border: none;
        }

        /* col 1 img campaign*/
        #campaign-like {
            text-decoration: none !important;
        }

        #flip-btn {
            margin: 15px 0 15px 0;
            text-align: center;
        }

        #campaign-img {
            text-align: center;
            margin-bottom: 20px;
        }

        #campaign-img img {
            width: 100%;
            text-align: center;
        }

        #group-campaign-img {
            text-align: center;
        }

        #group-flip-btn {
            text-align: center;
            margin-top: 15px;
        }

        .btn-flip {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            text-align: center;
            padding-top: 18px;
            border: 1px solid #979797;
            color: #202020;
        }

        .btn-flip:hover {
            border: 1px solid #8a8a8a;
            color: #202020;
            background: #f5f5f5;
        }

        .blue {
            border: 1px solid #2c4257;
            background: #36465d;
            color: #fff;
        }

        .blue:hover {
            color: #eee;
            background: #2c4257;
            border: 1px solid #2c4257;
        }

        .blue:focus {
            color: #eee;
            background: #2c4257;
        }

        #btn-flip-font {
            margin-right: 10px;
        }

        /* col 2 buy*/

        #campaign-show-detail .wrapper {
            margin-bottom: 10px;
            clear: both;
        }

        #group-social {

        }

        #group-social p {
            font-size: 12px;
            font-weight: bold;
        }

        #group-social-btn {
            display: table;
            height: 50px;

        }

        #group-social-btn ul {
            /*background: #f5f5f5;
            text-align: left;
            border-radius: 30px;
            padding: 0px;*/

        }

        #group-social-btn li {
            display: inline;
            list-style: none;
        }

        #group-social-btn i {
            padding: 10px 0 0 0;
            font-size: 20px;
        }

        .share-wrapper {
            height: 40px;
            line-height: 40px;
        }

        #wish {
            margin: 0;
            float: left;
        }

        #wish a {
            color: #999;
        }

        #wish a:hover {
            text-decoration: none;
        }

        #wish img {
            height: 20px;
            width: 20px;
            background: #ccc;
            border-radius: 50%;
            text-align: center;
            vertical-align: middle;
            color: #fafafa;
        }
        .social-wrapper {
            float: right;
        }
        .btn-social {
            clear: both;
            display: inline-block;
            padding: 0;
            margin: 0 0px;
        }

        #btn-social-twitter {
            background: #1BC0FF;
        }

        #btn-social-facebook {
            background: #465D8E;
        }

        #btn-social-googleplus {
            background: #F55E4B;
        }

        #btn-social-pinterest {
            background: #C8171E;
        }

        #btn-social-email {
            background: #D3C8A9;
        }

        .btn-social img {
            height: 30px;
            width: 30px;
            border: 1px solid transparent;
            border-radius: 50%;
            background: #a1a1a1;
        }

        .btn-social img:hover {
            background: #434343;
        }

        .btn-social:hover {
            text-decoration: none;
        }

        .btn-social a:hover {
            text-decoration: none;
        }

        .tooltip {

        }

        #group-like {
            width: 130px;
        }

        #group-like ul {
            background: #f5f5f5;
            text-align: left;
            padding: 0px;
            border-radius: 30px;
        }

        #group-like li {
            display: inline;
            list-style: none;
            vertical-align: middle;
        }

        #group-like p {
            font-size: 24px;
            color: #36465d;
            display: inline;
            font-family: "Courier New";
            font-weight: bold;
            vertical-align: middle;
        }

        .like {
            background: #346EBA;
        }

        #group-like i {
            padding: 10px 0 0 0;
            font-size: 20px;
        }

        #save-wish {

        }

        #save-wish i {
            padding: 11px 0 0 1px;
            font-size: 20px;
        }

        #save-wish.favorite img {
            background: #56BA2D;
        }

        #save-wish.favorite .text {
            color: #56BA2D;
        }

        /*color chart*/
        #btn-buy, #btn-reserve {
            border: none;
            padding: 18px 0;
            width: 100%;
            text-align: center;
            vertical-align: middle;
            font-size: 24px;
            text-decoration: none;
            margin-bottom: 0;
            border-radius: 4px;
        }

        #btn-buy.success {
            background: #56BA2D;
        }

        #btn-buy.reserve {
            background:;
        }

        #goal .end-text {
            font-size: 24px;
            color: #848C93;
        }

        #btn-buy:hover {

        }

        #campaign-choice-detail-left {

        }

        #group-color {
            min-height: 60px;
            max-height: 100px;
            width: 255px;
            float: left;
        }

        .color-box {
            width: 26px;
            height: 26px;
            border: 2px solid;
            border-color: rgba(0, 0, 0, 0.2);
            float: left;
            margin: 5px 0 0 5px;
        }

        .color-box:active {
            border: 13px solid;
            border-color: rgba(0, 0, 0, 0.2);
        }

        .choice {
            border: 3px solid #36465d;
        }

        #group-size {
        }

        #size-chart {
            margin-bottom: 10px;
        }

        .t-size {
            padding: 10px 15px;
            border: 2px solid #DDD;
            margin: 5px 0 5px 5px;
            text-align: center;
            display: inline-block;
            color: #333;
        }

        .t-size:hover {
            text-decoration: none;

        }

        .size {
            border: 3px solid #36465d;
        }

        #group-type select {
            height: 50px;
            border: 1px solid #DDD;
            color: #333;
            background-color: #FFF;
            font-size: 15px;

            padding: 15px;
            box-shadow: none;
        }

        #group-type option {
            height: 35px;
            line-height: 40px;
        }

        /*campaign-count*/
        #campaign-count {
            padding: 15px;
            background: #f5f5f5;
            border-radius: 4px;
        }

        #time-count {
            margin-left: 45px;
            height: 100px;
        }

        .time-count-box {
            padding: 0 15px;
            display: inline-block;
            text-align: center;
            vertical-align: top;
        }

        .time-count-box .number {
            font-weight: bold;
            margin-top: 10px 0px 0px 0px;
        }

        .time-count-box p.unit {
            color: #36465d;
            font-size: 15px;
        }

        #process-count {
        }

        .progress {
            background: #c5c5c5;
            height: 15px;
            border-radius: 10px;
            margin-bottom: 5px;
        }

        .process-green {
            background: #9acb34;
        }

        #campaign-img-front, #campaign-img-back {
            position: relative;
        }

        #service-detail {
            text-align: left;
            margin-top: 15px;
        }

        #service-detail .text {
            font-size: 13px;
            color: #999;
            width: 90%;
            margin: 0 auto;
            padding: 10px;
            border: solid 1px #EEE;
            border-radius: 4px;
        }

        #service-detail h4 {
            font-size: 18px;
            text-align: left;
            margin: 0 5px 0 0;
            display: inline;
        }

        /* designer */
        #group-designer {
            margin-top: 25px;

            margin-bottom: 10px !important;
        }

        #campaign-name {
            margin-bottom: 25px;
            font-size: 40px;
            font-weight: bold;
        }

        #group-left-designer d-name {
            font-size: 18px;
            font-weight: bold;
            color: #36465d;
            display: block;
            padding-bottom: 5px;
        }

        d-detail {
            color: #999;
        }

        #group-left-designer {
            float: left;
            width: 330px;
        }

        #head-group-designer {
            margin-bottom: 25px;
        }

        #fav {
            font-size: 12px;
            font-weight: bold;
            color: #5d7184;
            font-family: "Verdana";
            white-space: normal;
        }

        #designer-img img {
            width: 30px;
            height: 30px;
            float: left;
            display: inline;
            margin-right: 8px;
        }

        #favorit-designer {
            width: 100%;
            /*height: 30px;
            line-height: 30px;*/
        }

        #favorit-designer a {
            text-decoration: none;

        }

        #favorit-designer i {
            font-size: 16px;
            margin-left: 5px;
            color: #ccc;
        }

        .favor {
            color: #fac12f !important;
        }

        #designer-footer {
            margin: 15px 0 30px 0;
        }

        #designer-signature {
            width: 140px;
            height: 100px;
            float: left;
        }

        #designer-signature img {
            max-width: 140px;
            max-height: 100px;
        }

        #designed {
            max-width: 300px;
            max-height: 100px;

        }

        #designed a {
            width: 100px;
            margin-right: 0px;
        }

        #designed img {
            width: 70px;
            float: right;
            margin-right: 20px;
            padding-top: 15px;

        }

        #designed :hover {
            -webkit-filter: grayscale(40%);
        }

        /*comment*/
        #comment {
            border-top: solid 1px #EEE;
            padding-top: 10px;
        }

        #message {
            width: 300px;
            padding: 5px;
            resize: none;
        }
        @media (max-width: 800px){
            #message{
                width: 100%;
                margin-bottom: 10px;
            }
        }
        @media (max-width: 480px){
            #message{
                width: 100%;
                margin-bottom: 0px;
            }
        }
        #img_user {
            margin-top: 0px;
            vertical-align: top;
        }

        #btn-post {
            width: 100px;
            margin-top: 0px;
            vertical-align: top;
        }

        #btn-post:active {

        }

        .group-comment-img {
            float: left;
            width: 450px;
            display: inline;
        }

        .box-comment {
            padding: 10px;
            border-bottom: solid 1px #eee;
            background: #f7f7f7;
        }

        .comment-head {
            font-size: 14px;
        }

        .comment-head a:hover {
            text-decoration: underline;
            color: #36465d;
        }

        .comment-img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            overflow: hidden;
            display: inline-block;
            float: left;
            margin-right: 10px;
            webkit-box-shadow: inset 0 0 0 -2px rgba(255, 255, 255, 0.48), 0 0 0 1px rgba(0, 0, 0, 0.14);
            box-shadow: inset 0 0 0 -2px rgba(255, 255, 255, 0.48), 0 0 0 1px rgba(0, 0, 0, 0.14);
        }
        .c-name {
            font-family: "Verdana";
            font-weight: bold;
            color: #36465d;
        }

        .comment-detail {
            width: 78%;
            color: #303030;
            padding: 5px 0;
            -ms-word-break: break-all;
            word-break: break-all;
            word-break: break-word;

            -webkit-hyphens: auto;
            -moz-hyphens: auto;
            hyphens: auto;
        }

        .box-comment a {
            color: #337ab7;
            font-weight: bold;
        }

        .comment-footer {
            height: 20px;

            color: #aaa;
        }

        .comment-time {

            font-size: 11px;
            text-align: left;
            color: #aaa;
        }

        .comment-like {

        }

        .comment-like a {
            color: #aaa;
            font-size: 12px;
        }

        .comment-like a:hover {
            color: #111;
            text-decoration: none;
        }

        .comment-like i {
            font-size: 12px;
            padding-right: 2px;
        }

        .like-cmm {
            color: #ba1528;
        }

        .see-more {
            display: block;
            width: 100%;
        }
        .table-form{
            margin-left: auto;
            margin-right: auto;
        }
        .table-form thead tr th{
            border-bottom: 2px solid #555;
        }
        .table-form td,th{
            text-align: center;
            padding: 5px 0;
        }
        .table-form td:first-child,th:first-child{
            text-align: center;
            border-right: 1px solid #989898;
        }

        /*btn social*/
        #btn-shared {
            border: 3px solid #aaa;
            height: 40px;
            width: 40px;
            border-radius: 50%;
            text-align: center;
            vertical-align: middle;
            color: #fafafa;
            margin-right: 5px;
        }
        .modal-body {
            background: #fff;
        }
        #modal-campaign-report .modal-body .ul-report {
            list-style: none;
        }
        #modal-campaign-report .modal-body .ul-report li:hover {
            cursor: pointer;
        }
        #modal-campaign-report .modal-body .ul-report li:hover label {
            cursor: pointer;
        }
        #modal-campaign-report select {
            margin-bottom: 15px;
        }
        @media (max-width: 480px){
            .table-form>tbody>tr>td:first-child{
                display: table-cell;}
        }

    </style>
@stop
@section('script')
    <script src="{{ asset('js/jquery.sharrre.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/countdown/jquery.countdown.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#facebook').sharrre({
                share: {
                    facebook: true
                },
                enableHover: false,
                enableTracking: false,
                click: function (api, options) {
                    api.simulateClick();
                    api.openPopup('facebook');
                }
            });

            function formatNumber(num) {
                return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
            }

            var campaign_data = '';

            $("#toggle-location").click(function () {
                $('#campaign-img-front').toggleClass('hidden');
                $('#campaign-img-back').toggleClass('hidden');
                $('.toggle-look').toggleClass('hidden');
                setImagePosition();
            });
            /*
             $("#btn-flip-font").click(function () {
             $("#campaign-img-front").show();
             $("#campaign-img-back").hidden();
             setImagePosition();
             });
             $("#btn-flip-back").click(function () {
             $("#campaign-img-front").hidden();
             $("#campaign-img-back").show();
             setImagePosition();
             });*/
            $('.login-first').click(function () {
                alert('กรุณาเข้าสู่ระบบเพื่อใช้งานในส่วนนี้');
            });
            $("#save-wish ").click(function () {
                $(this).toggleClass("favorite");
                var current_text = $(this).find('.text').html();
                var new_text = $(this).find('.text').attr('data-toggle-text');
                $(this).find('.text').html(new_text);
                $(this).find('.text').attr('data-toggle-text', current_text);
            });
            $("#group-like img.enable").click(function () {
                $(this).toggleClass("like");
            });
            $(".color-box").click(function () {
                $(".color-box.choice").removeClass("choice");
                $(this).addClass("choice");
            });
            $(".t-size").click(function () {
                $(".t-size.size").removeClass("size");
                $(this).addClass("size");
            });
            $("#favorit-designer i.enable").click(function () {
                $(this).toggleClass("favor");
            });
            $(".comment-like-link").click(function () {
                $(this).find('i.enable').toggleClass("like-cmm");
            });
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })
            $(".btn-flip").click(function () {
                $(".btn-flip.blue").removeClass("blue");
                $(this).addClass("blue");
            });

            function loadCampaignData(id) {
                $.ajax({
                    type: "GET",
                    url: $("#available-product-url").attr('data-url') + "/" + id,
                    dataType: "json",
                    success: function (data) {
                        if (data) {
                            campaign_data = data;
                            var html_text = "";
                            $.each(campaign_data.products, function (k, product) {
                                html_text += '<option value="' + product.id + '">'
                                        + product.product.name + '&nbsp;' + product.product_image.color_name
                                        + '&nbsp;' + product.sell_price + '&nbsp;บาท</option>';
                            });

                            $('#type-select').html(html_text);
                            getSize(campaign_data.products[0].product.available_size);
                            changeProductImage(campaign_data.products[0].product_image);
                        }
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            }

            $('#type-select').change(function () {
                $.each(campaign_data.products, function (index, product) {
                    if (product.id == $('#type-select').val()) {
                        changeProductImage(product.product_image);
                        getSize(product.product.available_size);
                        return false;
                    }
                });
            });
            $('.select-product').change(function () {
                var parent = $(this).closest('tr');
                console.log(parent);
                parent.find('.image-preview').attr('src', $(this).attr('data-image-url'));
                parent.find('.price strong').html($(this).attr('data-image-url'));
            });
            function loadLikecomment(obj) {
                $.ajax({
                    type: "GET",
                    url: $('#comment-body').data('url-get') + '/' + obj.attr('data-comment-id'),
                    dataType: "json",
                    success: function (data) {
                        if (!data.error) {
                            $(obj).find("span").html(data.count);
                        }
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            }

            function likeComment(obj) {
                $.ajax({
                    type: "GET",
                    url: $('#comment-body').data('url-set') + '/' + obj.attr('data-comment-id') + '/' + $('#comment-body').data('user-id'),
                    dataType: "json",
                    success: function (data) {
                        if (!data.error) {
                            loadLikecomment(obj);
                        }
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            }

            $('.comment-like-link').click(function () {
                likeComment($(this));
            });

            $('#btn-post').click(function () {
                if ($('#message').val() != "") {
                    $('#message').removeClass('error');
                    $.ajax({
                        type: "POST",
                        url: $(this).attr('data-url'),
                        data: {
                            _token: $('#token').val(),
                            campaign_id: $('#campaign-id').val(),
                            user_id: $('#user-id').val(),
                            message: $('#message').val()
                        },
                        dataType: "json",
                        success: function (data) {

                            if (!data.error) {
                                location.reload();
                                /*console.log(data);
                                 var html_text = "";

                                 html_text += '<div class="box-comment">'
                                 + '<div class="comment-img table-cell">'
                                 + '<img src="' + data.avatar + '">'
                                 + '</div>'
                                 + '<div class="comment-head table-cell">'
                                 + '<a href="#">'
                                 + '<c-name>' + data.full_name + '</c-name>'
                                 + '</a>'
                                 + '<div class="comment-detail">'
                                 + data.comment.message
                                 + '</div>'
                                 + '<div class="comment-footer">'
                                 + '<span class="comment-time">'
                                 + '<p1>' + data.comment.updated_at + '</p1>'
                                 + '</span>'
                                 + '<span class="comment-like">'
                                 + '<a class="comment-like-link" data-comment-id="' + data.comment.id + '">'
                                 + '<i class="fa fa-heart enable "></i>'
                                 + '<span>0</span></a>'
                                 + '</span>'
                                 + '<div class="comment-time">'
                                 + '</div>'
                                 + '<div class="comment-like"><a class="comment-like-link" data-comment-id="' + data.comment.id + '"><i class="fa fa-heart"></i>0</a>'
                                 + '</div></div><div class="border-box-comment"></div></div>';
                                 $('#comment-body').prepend(html_text);
                                 $('#message').val("");
                                 $('html,body').animate({
                                 scrollTop: $("#comment").offset().top
                                 },
                                 'slow');
                                 $('.comment-like-link').click(function () {
                                 likeComment($(this));
                                 });*/
                            }
                        },
                        failure: function (errMsg) {
                            alert(errMsg);
                        }
                    });
                } else {
                    $('#message').addClass("error");
                }
            });

            function loadCampaignLike() {
                $.ajax({
                    type: "GET",
                    url: $('#campaign-like').attr('data-url-get'),
                    dataType: "json",
                    success: function (data) {
                        if (!data.error) {
                            $('#like-count').html(data.count);
                        }
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            }

            function loadUserSubscribe() {
                $.ajax({
                    type: "GET",
                    url: $('#user-subscribe').attr('data-url-get'),
                    dataType: "json",
                    success: function (data) {
                        if (!data.error) {
                            $('#subscribe-count').html(data.count);
                        }
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            }

            $('#campaign-like').click(function () {
                $.ajax({
                    type: "GET",
                    url: $(this).attr('data-url-set'),
                    dataType: "json",
                    success: function (data) {
                        if (!data.error) {
                            loadCampaignLike();
                        }
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            });

            $('#user-subscribe').click(function () {
                $.ajax({
                    type: "GET",
                    url: $(this).attr('data-url-set'),
                    dataType: "json",
                    success: function (data) {
                        if (!data.error) {
                            loadUserSubscribe();
                        }
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            });
            function base_event() {
                $('.remove-item').unbind('click');
                $('.remove-item').click(function() {
                    $(this).closest('tr').remove();
                });
                $('.qty').keyup(function () {
                    var qty = parseInt($(this).val());
                    var total_qty = totalQTY(parseInt(qty));

                    if(total_qty.result)
                    {
                        alert('คุณสามารถสั่งสินค้ารวมกันไม่เกิน 100 ตัว');
                        $(this).val(total_qty.can_order);
                        return false;
                    }

                    var sell_price = parseInt($(this).attr('data-sell-price'));
                    var total = qty * sell_price;

                    var price = $(this).closest('tr').find('.price');
                    price.html(formatNumber(total));
                });
                $('.qty').change(function () {
                    var qty = parseInt($(this).val());
                    var total_qty = totalQTY(parseInt(qty));

                    if(total_qty.result)
                    {
                        alert('คุณสามารถสั่งสินค้ารวมกันไม่เกิน 100 ตัว');
                        $(this).val(total_qty.can_order);
                        return false;
                    }

                    var sell_price = parseInt($(this).attr('data-sell-price'));
                    var total = qty * sell_price;

                    var price = $(this).closest('tr').find('.price');
                    price.html(formatNumber(total));
                });
                $('.select-product').change(function () {
                    var product = '';
                    var selected_id = $(this).val();
                    $.each(campaign_data.products, function (k, v) {
                        if (v.id == parseInt(selected_id)) {
                            product = v;
                            return false;
                        }
                    });
                    var image_preview = $(this).closest('tr').find('.image-preview');
                    var price = $(this).closest('tr').find('.price');
                    var size = $(this).closest('tr').find('.size-select');
                    var qty = $(this).closest('tr').find('.qty');
                    $(this).closest('tr').attr('data-campaign-product-id', product.id);
                    image_preview.attr('src', product.product_image.image_front);
                    price.html(formatNumber(parseInt(product.sell_price) * parseInt(qty.val())));
                    qty.attr('data-sell-price', product.sell_price);
                    var size_text = '';
                    $.each(product.product.available_size.split(','), function (index, size) {
                        size_text += '<option value="' + size + '">' + size + '</option>';
                    });

                    size.html(size_text);
                });
            }

            function totalQTY(value)
            {
                var total = 0;

                $('#order-table tbody tr').each(function()
                {
                    var row = $(this);
                    var qty = parseInt(row.find('.qty').val());
                    total += qty;
                });


                if(total > 100)
                {
                    return {
                        result:true,
                        can_order: (100 - (total - value))
                    };
                }

                return {
                    result:false
                };
            }

            $('#btn-buy').click(function () {
                $('#order-dialog').modal();
                var product = $(campaign_data.products).filter(function () {
                    return this.id == $('#type-select').val();
                })[0];
                var selected = '';
                var html_text = '';
                html_text += '<tr data-campaign-product-id="' + product.id + '">'
                        + '<td class="mobile-hidden"><img src="' + product.product_image.image_front + '"'
                        + 'style="width: 50px" alt="" class="image-preview" /></td>'
                        + '<td><input class="form-control qty" type="number" name="qty" value="1" '
                        + 'data-sell-price="' + product.sell_price + '"/></td>';
                html_text += '<td><select class="form-control select-product" name="product">';
                $.each(campaign_data.products, function (key, value) {
                    selected = "";
                    if (value.id == $('#type-select').val()) {
                        selected = 'selected';
                    }
                    html_text += '<option value="' + value.id + '" ' + selected + '>'
                            + value.product.name + '&nbsp;' + value.product_image.color_name
                            + '&nbsp;' + value.sell_price + '&nbsp;บาท</option>';
                });
                html_text += '</select></td>';
                html_text += '<td><select class="form-control size-select" name="size">';
                $.each(product.product.available_size.split(','), function (k, size) {
                    var s = $('#size-chart').find('.size').data('size');
                    var selected = '';
                    if (s === size) {
                        selected = 'selected';
                    }
                    html_text += '<option value="' + size + '" ' + selected + '>' + size + '</option>';
                });
                html_text += '</select></td>';
                html_text += '<td class="text-bold">฿<span class="price"><strong>' + formatNumber(product.sell_price) + '</strong></span></td>'
                        + '<td class="mobile-hidden"></td></tr>';
                $('#order-table tbody').html(html_text);
                base_event();

                return false;
            });

            $('#confirm-reserve').click(function () {

            });

            $('#add-product').click(function () {
                var html_text = '';
                var product = campaign_data.products[0];

                html_text += '<tr data-campaign-product-id="' + product.id + '"><td class="mobile-hidden"><img src="' + product.product_image.image_front + '"'
                        + 'style="width: 50px" alt="" class="image-preview" /></td>'
                        + '<td><input class="form-control qty" type="number" name="qty" min="1" maxlength="100" value="1" '
                        + 'data-sell-price="' + product.sell_price + '"/></td>';
                html_text += '<td><select class="form-control select-product" name="product">';
                $.each(campaign_data.products, function (key, value) {
                    html_text += '<option value="' + value.id + '">'
                            + value.product.name + '&nbsp;' + value.product_image.color_name
                            + '&nbsp;' + value.sell_price + '&nbsp;บาท</option>';
                });
                html_text += '</select></td>';
                html_text += '<td><select class="form-control size-select" name="size">';

                $.each(product.product.available_size.split(','), function (k, size) {
                    html_text += '<option value="' + size + '">' + size + '</option>';
                });
                html_text += '</select></td>';
                html_text += '<td class="text-bold">฿<span class="price"><strong>' + formatNumber(product.sell_price) + '</strong></span><p class="order-remove"><a href="#">ลบ</a></p></td>'
                        + '<td class="mobile-hidden"><button class="btn btn-small btn-default remove-item"><i class="fa fa-trash" data-product-id="' + product.id + '"></i></button></td></tr>';
                $('#order-table tbody').append(html_text);
                base_event();
            });

            $('.confirm-order').click(function () {
                var orders = {
                    campaign_id: $('#available-product-url').attr('data-campaign-id'),
                    payment_type_id: 1,
                    items: []
                };
                $('#order-table tbody tr').each(function () {
                    var campaign_product_id = $(this).attr('data-campaign-product-id');
                    var size = $(this).find('.size-select').val();
                    var qty = parseInt($(this).find('.qty').val());

                    var product = $(orders.items).filter(function () {
                        return this.campaign_product_id == campaign_product_id && this.size == size;
                    })[0];
                    if(product == undefined) {
                        var item = {
                            size: size,
                            qty: qty,
                            campaign_product_id: campaign_product_id
                        };
                        orders.items.push(item);
                    }
                    else {
                        $.each(orders.items, function(k, v) {
                            if(v.campaign_product_id == campaign_product_id && v.size == size)
                            {
                                v.qty += qty;
                                return false;
                            }
                        });
                    }

                });
                $.ajax({
                    type: "POST",
                    url: $(this).attr('data-url'),
                    data: {
                        _token: $('#token2').val(),
                        orders: orders
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data.success) {
                            window.location = data.redirect_url;
                        }
                        else {
                            console.log(data.message);
                        }
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            });
            function getColor(id) {
                $.ajax({
                    type: "GET",
                    url: $("#type-select").attr('data-get-color-url') + "/" + id,
                    dataType: "json",
                    success: function (data) {
                        if (data) {
                            var html_text = "";
                            $.each(data, function (k, v) {
                                html_text += '<a class="color-box" href="javascript:void(0)"'
                                        + 'data-image-id="' + v.id + '"'
                                        + 'data-image-front="' + v.image_front + '"'
                                        + 'data-image-back="' + v.image_back + '"'
                                        + 'style="background: ' + v.color + ';"'
                                        + 'title="' + v.color_name + '"></a>';
                            });
                            $('#color-chart').html(html_text);
                            $(".color-box").click(function () {
                                $(".color-box.choice").removeClass("choice");
                                $(this).addClass("choice");
                            });

                            changeProductImage($('.color-box'));
                            $('.color-box').click(function () {
                                changeProductImage($(this));
                            });
                        }
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            }

            function getSize(data) {
                var html_text = "";
                $.each(data.split(','), function (k, v) {
                    html_text += '<a data-size="' + v + '" class="t-size">' + v + '</a>';
                });
                $('#size-chart').html(html_text);
                $(".t-size").click(function () {
                    $(".t-size.size").removeClass("size");
                    $(this).addClass("size");
                });
            }

            $('.time').countdown($('.time').attr('data-end-time')).on('update.countdown', function (event) {
                var day = event.strftime('%-D');
                var hour = event.strftime('%-H');
                var minute = event.strftime('%-M');
                var second = event.strftime('%-S');

                var time_left = "";
                if (day > 0) {
                    time_left = day + " วัน " ;
                    if (hour > 0) {
                        time_left = time_left + hour + " ชั่วโมง ";
                    }else{
                        if (minute > 0) {
                            time_left = time_left + minute + " นาที ";
                        }

                    }
                } else if (hour > 0) {
                    time_left = hour + " ชั่วโมง ";
                } else if (minute > 0) {
                    time_left = minute + " นาที";
                } else if (second > 0) {
                    time_left = second + " วินาที";
                } else {
                    time_left = 0;
                }

                if (time_left != 0) {
                    $(".big_unit").html(time_left);
                } else {
                    $(".big_unit").html('0');
                }

                /*$(".big_unit").html(event.strftime(''
                 + '<div class="time-count-box"><p class="number">%-D</p><p class="unit">วัน</p></div>'
                 + '<div class="time-count-box"><p class="number">%-H</p><p class="unit">ชั่วโมง</p></div>'
                 + '<div class="time-count-box"><p class="number">%-M</p><p class="unit">นาที</p></div>'
                 + '<div class="time-count-box" style="border-right:none"><p class="number">%S</p><p class="unit">วินาที</p></div>'
                 ));*/
            });
            function changeProductImage(data) {
                var front_product_image = $('#front-product-image');
                var back_product_image = $('#back-product-image');

                front_product_image.attr('src', data.image_front);
                back_product_image.attr('src', data.image_back);
            }

            function setImagePosition() {
                var front_outline_image = $('#front-outline-image');
                var front_product_image = $('#front-product-image');
                var max_width = 540;
                var max_height = 540;
                var front_product_width = front_product_image.width();
                var front_product_height = front_product_image.height();
                var diff_front_width_percent = ((max_width - front_product_width) * 100) / max_width;
                var diff_front_height_percent = ((max_height - front_product_height) * 100) / max_height;
                var front_frame_width = (front_outline_image.data('outline-width') - (front_outline_image.data('outline-width') * diff_front_width_percent) / 100);
                var front_frame_height = (front_outline_image.data('outline-height') - (front_outline_image.data('outline-height') * diff_front_height_percent) / 100);
                var front_frame_left = ((front_outline_image.data('outline-left') * 100) / max_width);
                var front_frame_top = ((front_outline_image.data('outline-top') * 100) / max_height);
                /*front_outline_image.css('width', front_frame_width + "px");
                 front_outline_image.css('height', front_frame_height + "px");
                 front_outline_image.css('left', front_frame_left + '%');
                 front_outline_image.css('top', front_frame_top + '%');*/

                front_outline_image.css('width', "100%");
                front_outline_image.css('height', "100%");
                front_outline_image.css('left', '0');
                front_outline_image.css('top', '0');

                var back_outline_image = $('#back-outline-image');
                var back_product_image = $('#back-product-image');
                var back_product_width = back_product_image.width();
                var back_product_height = back_product_image.height();
                var diff_back_width_percent = ((max_width - back_product_width) * 100) / max_width;
                var diff_back_height_percent = ((max_height - back_product_height) * 100) / max_height;
                var back_frame_width = (back_outline_image.data('outline-width') - (back_outline_image.data('outline-width') * diff_back_width_percent) / 100);
                var back_frame_height = (back_outline_image.data('outline-height') - (back_outline_image.data('outline-height') * diff_back_height_percent) / 100);
                var back_frame_left = ((back_outline_image.data('outline-left') * 100) / max_width);
                var back_frame_top = ((back_outline_image.data('outline-top') * 100) / max_height);
                /*back_outline_image.css('width', back_frame_width + "px");
                 back_outline_image.css('height', back_frame_height + "px");
                 back_outline_image.css('left', back_frame_left + '%');
                 back_outline_image.css('top', back_frame_top + '%');*/
                back_outline_image.css('width', "100%");
                back_outline_image.css('height', "100%");
                back_outline_image.css('left', '0');
                back_outline_image.css('top', '0');
            }

            $('#send-reserve-button').click(function () {
                $('#reserve-form').submit();
            });

            $('img').bind('contextmenu', function(e) {
                return false;
            });
            $('img').on('dragstart', function(event) {
                event.preventDefault();
            });
            loadCampaignData($('#available-product-url').attr('data-campaign-id'));
            setImagePosition();
        });
    </script>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 col-mobile">
            <div id="mobile-campaign-count">
                @if($campaign->end > Carbon::now())
                    <div class="col-xs-5" data-end-time="{{ $campaign->end->format('Y/m/d H:s:i') }}">
                        <div class="xs-menu">
                            <p>เหลือเวลา</p>
                            <p class="m-detail big_unit"></p>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="">
                            <p>ขายแล้ว</p>
                            <p class="m-detail">{{ $campaign->totalOrder() }}</p>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="xs-menu">
                            <p>เป้าหมาย</p>
                            <p class="m-detail">{{ $campaign->goal }}</p>
                        </div>
                    </div>
                @else
                    <div class="col-xs-12">
                        <div class="xs-menu">
                            <p>แคมเปญสิ้นสุดแล้ว</p>
                            @if($campaign->totalOrder()>5)
                                <p>ขายแล้ว {{ $campaign->totalOrder() }}</p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="campaign-name">
                <h1 class="title">
                    {{ $campaign->title }}</h1>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-xs-12">
        <input name="available_product_url" id="available-product-url" data-campaign-id="{{ $campaign->id }}"
               data-url="{{ action('CampaignController@getAvailableProduct') }}" type="hidden"/>
        <input name="_token2" type="hidden" id="token2" value="{{ csrf_token() }}"/>
        <div class="modal fade modal-fullscreen" id="order-dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h2 class="modal-title">เลือกสินค้าเพื่อสั่งซื้อ</h2>
                    </div>
                    <div class="modal-body">
                        <table id="order-table" class="table">
                            <thead>
                            <tr>
                                <th class="mobile-hidden"></th>
                                <th class="th-value">จำนวน</th>
                                <th>แบบเสื้อ</th>
                                <th class="th-size">ขนาด</th>
                                <th class="th-total">ราคา</th>
                                <th class="mobile-hidden"></th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="6">
                                    <button class="btn btn-default" id="add-product"><i class="fa fa-plus"></i>&nbsp;เพิ่มสินค้า
                                    </button>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success btn-lg confirm-order" data-url="{{ action('SellController@postSaveOrder') }}">ยืนยันการสั่งซื้อ
                        </button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>


    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div id="campaign-img">
                <div id="group-campaign-img">
                    <div id="campaign-img-front" class="{{{ ($campaign->back_cover==1) ? 'hidden' : '' }}}">
                        <img src="{{ $campaign->products[0]->product_image->image_front }}" id="front-product-image">
                        @if($campaign->design->image_front!="")
                            <img src="/{{ $campaign->design->image_front }}" id="front-outline-image"
                                 data-outline-left="{{ $campaign->products[0]->product->outline->outline_left}}"
                                 data-outline-top="{{ $campaign->products[0]->product->outline->outline_top}}"
                                 data-outline-width="{{ $campaign->products[0]->product->outline->outline_width}}"
                                 data-outline-height="{{ $campaign->products[0]->product->outline->outline_height}}"
                                 style="position: absolute">
                        @endif
                    </div>
                    <div id="campaign-img-back" class="{{{ ($campaign->back_cover==0) ? 'hidden' : '' }}}">
                        <img src="{{ $campaign->products[0]->product_image->image_back }}" id="back-product-image">
                        @if($campaign->design->image_back!="")
                            <img src="/{{  $campaign->design->image_back }}" id="back-outline-image"
                                 data-outline-left="{{ $campaign->products[0]->product->outline->outline_left}}"
                                 data-outline-top="{{ $campaign->products[0]->product->outline->outline_top}}"
                                 data-outline-width="{{ $campaign->products[0]->product->outline->outline_width}}"
                                 data-outline-height="{{ $campaign->products[0]->product->outline->outline_height}}"
                                 style="position: absolute">
                        @endif

                    </div>
                </div>
                <div id="toggle-location">
                    <div class="toggle-look {{ ($campaign->back_cover==1) ? 'hidden' : '' }}">
                        ดูด้านหลัง
                    </div>
                    <div class="toggle-look {{ ($campaign->back_cover==0) ? 'hidden' : '' }}">
                        ดูด้านหน้า
                    </div>
                    <img class="look-back" src="{{ asset('images/icon/look-back.png') }}">
                </div>
            </div>
            <div class="wrapper mobile-hidden" id="service-detail">
                <p class="text text-left ">

                    <b>ระยะเวลาผลิต</b><br>
                    <span>
                        เมื่อระยะเวลาแคมเปญสิ้นสุดลง เราจะผลิตภายในระยะเวลาไม่เกิน 7 วันทำการ
                    </span>
                    <br><br>
                    <b>รับประกันการคืนเงิน</b><br>
                    <span>
                        ในกรณีที่จำนวนสั่งซื้อทั้งหมดน้อยเกินไป (ผู้ขายไม่ได้รับกำไร) เราจะไม่ผลิตแคมเปญนี้
ในกรณีที่คุณสั่งซื้อและชำระเงินผ่านการโอนเงิน เราจะโอนเงินคืนให้คุณ 
และหากคุณชำระเงินผ่านบัตรเครดิต/เดบิต เราจะไม่หักเงินจากบัตรของคุณ
                    </span>
                </p>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div id="campaign-show-detail">
                <div class="wrapper" id="campaign-description">
                    <div id="head-group-designer">

                        {!! $campaign->description !!}
                    </div>

                    <div class="wrapper" id="campaign-choice-detail">
                        <div id="campaign-choice-detail-left">
                            <div id="group-type">
                                <h4>เลือกสินค้า</h4>
                                <select class="form-control" id="type-select"
                                        data-get-size-url="{{ action('SellController@getAvailableSizeByCampaignProduct') }}"
                                        data-get-color-url="{{ action('SellController@getAvailableColorByCampaignProduct') }}"
                                        >
                                </select>
                            </div>
                            <p><a data-toggle="modal" data-target="#tshirt-size">ตารางเปรียบเทียบขนาด</a></p>
                        </div>

                    </div>
                    <div class="wrapper" id="campaign-choice-detail-right">

                        @if($campaign->end > Carbon::now() && $campaign->status->name == 'running')
                            <a id="btn-buy" class="btn btn-success btn-lg">
                                สั่งซื้อ
                            </a>
                        @else
                            @if(\Auth::user()->check() && \Auth::user()->user()->isReserved($campaign->id))
                                <a id="btn-reserve" class="reserve btn btn-default btn-lg">
                                    คุณได้จองแคมเปญนี้แล้ว</a>
                            @else
                                <a id="btn-reserve" class="reserve btn btn-primary btn-lg" data-toggle="modal"
                                   data-target="#reserve-modal">
                                    ต้องการสั่งซื้อ</a>

                            @endif
                        @endif
                    </div>

                    <div class="wrapper" id="campaign-count">
                        <div id="goal">
                            @if($campaign->end > Carbon::now() && $campaign->status->name == 'running')
                                <div class="box time" id="time-count"
                                     data-end-time="{{ $campaign->end->format('Y/m/d H:s:i') }}">
                                    <p class="title">เหลือเวลา</p>

                                    <p class="detail big_unit"></p>
                                </div>
                                <div class="box">
                                    <p class="title">ขายแล้ว</p>

                                    <p class="detail">{{ $campaign->totalOrder() }}</p>
                                </div>
                                <div class="box">
                                    <p class="title">เป้าหมาย</p>

                                    <p class="detail">{{ $campaign->goal }}</p>
                                </div>
                            @else
                                <div class="text-center">
                                    <span class="end-text">แคมเปญสิ้นสุดแล้ว</span>
                                    @if($campaign->totalOrder()>5)
                                        <p>ขายแล้ว {{ $campaign->totalOrder() }}</p>
                                    @endif
                                </div>

                            @endif
                        </div>
                    </div>

                    <div class="wrapper share-wrapper">
                        <div id="wish" class="column">
                            <a class="">
                                @if(\Auth::user()->check())
                                    <div id="save-wish"
                                         class="column {{ \Auth::user()->user()->isFavorited($campaign->id) ? 'favorite' : ''}}"
                                         data-toggle="tooltip" title="บันทึกไว้ในรายได้ที่ชื่นชอบ"
                                         data-url-get="{{ action('CampaignController@getFavoriteCampaign', $campaign->id) }}"
                                         data-url-set="{{ action('CampaignController@getSetFavoriteCampaign', [$campaign->id, \Auth::user()->user()->id]) }}">
                                        <img class="wish-img enable" src="{{ asset('images/icon/fav-h-tran_50x50.png') }}">
                                        @if(\Auth::user()->user()->isFavorited($campaign->id))
                                            <span class="text" data-toggle-text="บันทึกไว้ในรายการที่ชอบ">บันทึกแล้ว</span>
                                        @else
                                            <span class="text" data-toggle-text="บันทึกแล้ว">บันทึกไว้ในรายการที่ชอบ</span>
                                        @endif
                                    </div>
                                @else
                                    <div id="save-wish" data-toggle="tooltip" title="บันทึกไว้ในรายได้ที่ชื่นชอบ">
                                        <img class="wish-img login-first"
                                             src="{{ asset('images/icon/fav-h-tran_50x50.png') }}">
                                        <span class="text" data-toggle-text="บันทึกแล้ว">บันทึกไว้ในรายการที่ชอบ</span>
                                    </div>
                                @endif

                            </a>
                        </div>
                        <div class="social-wrapper column">
                            <a onclick="popUp=window.open('https://twitter.com/intent/tweet?original_referer={{ urlencode(Request::url()) }}&text={{ $campaign->title }}&tw_p=tweetbutton&url={{ Request::url() }}','popupwindow', 'scrollbars=yes,width=600,height=400');popUp.focus();return false"
                               class="btn-social" id="twitter" data-toggle="tooltip" title="แบ่งปันบนทวิตเตอร์">
                                <img id="btn-social-twitter" src="{{ asset('images/icon/twitter_tran_30x30.png') }}">
                            </a>
                            <a onclick="popUp=window.open('http://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::url()) }}','popupwindow', 'scrollbars=yes,width=600,height=400');popUp.focus();return false"
                               class="btn-social" data-toggle="tooltip" title="แบ่งปันบนเฟซบุค">
                                <img id="btn-social-facebook" src="{{ asset('images/icon/facebook_tran_30x30.png') }}">
                            </a>
                            <a onclick="popUp=window.open('https://plus.google.com/share?url={{ urlencode(Request::url()) }}','popupwindow', 'scrollbars=yes,width=600,height=400');popUp.focus();return false"
                               class="btn-social" data-toggle="tooltip" title="แบ่งปันบนกูเกิ้ลพลัส">
                                <img id="btn-social-googleplus"
                                     src="{{ asset('images/icon/googleplus_tran_30x30.png') }}">
                            </a>
                            <a onclick="popUp=window.open('http://www.pinterest.com/pin/create/button/?url={{ Request::url() }}&media={{ $campaign->back_cover ? $campaign->design->image_back_preview : $campaign->design->image_front_preview }}&description={{ $campaign->title }})','popupwindow', 'scrollbars=yes,width=600,height=400');popUp.focus();return false"
                               class="btn-social" data-toggle="tooltip" title="แบ่งปันบนพินเทอเรส">
                                <img id="btn-social-pinterest"
                                     src="{{ asset('images/icon/pinterest_tran_30x30.png') }}">
                            </a>
                            <a href="mailto:?subject={{ $campaign->title }}&amp;body={{ urlencode(Request::url()) }}" class="btn-social" data-toggle="tooltip" title="อีเมล์">
                                <img id="btn-social-email" src="{{ asset('images/icon/email_tran_30x30.png') }}">
                            </a>
                            @if(\Auth::user()->check())
                                <div class="dropdown btn-social">
                                    <a href="#" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
                                        <img src="{{ asset('images/icon/other_30x30.png') }}">
                                    </a>
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                                        <li role="presentation">
                                            <a data-toggle="modal" data-target="#modal-campaign-report">รายงานปัญหา</a></li>
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="wrapper" id="group-designer">
                        <div class="row">
                            <div id="created-by" class="col-md-6">
                                <h4>สร้างแคมเปญโดย</h4>
                                <div id="favorit-designer">
                                    <a href="{{ action('UserController@getIndex', $campaign->user->getID()) }}">
                                        <d-name>{{ ($campaign->user->option->show_full_name == 1) ? $campaign->user->full_name : $campaign->user->username }}</d-name>
                                    </a>
                                </div>
                            </div>
                            <div id="view-count" class="col-md-6 text-right">
                                <h4>เข้าชมแล้ว {{ \App\ViewCount::count(\Request::path())}} ครั้ง</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wrapper desktop-hidden mobile-show" id="service-detail">
                <p class="text text-left ">

                    <b>ระยะเวลาผลิต</b><br>
                    <span>
                        เมื่อระยะเวลาแคมเปญสิ้นสุดลง เราจะผลิตภายในระยะเวลาไม่เกิน 7 วันทำการ
                    </span>
                    <br><br>
                    <b>รับประกันการคืนเงิน</b><br>
                    <span>
                        ในกรณีที่จำนวนสั่งซื้อทั้งหมดน้อยเกินไป (ผู้ขายไม่ได้รับกำไร) เราจะไม่ผลิตแคมเปญนี้
ในกรณีที่คุณสั่งซื้อและชำระเงินผ่านการโอนเงิน เราจะโอนเงินคืนให้คุณ 
และหากคุณชำระเงินผ่านบัตรเครดิต/เดบิต เราจะไม่หักเงินจากบัตรของคุณ
                    </span>
                </p>
            </div>
            <div class="wrapper" id="comment">
                <h4>ความคิดเห็น</h4>

                <div id="comment-body"
                     data-url-get="{{ action('CampaignController@getLikeComment')}}"
                     data-url-set="{{ action('CampaignController@getSetLikeComment') }}"
                     data-user-id="{{ \Auth::user()->check() ? \Auth::user()->user()->id : ''}}">
                    @foreach($campaign->comments as $comment)
                        <div class="box-comment"><!--loop-->
                            <div class="table-cell">
                                <a class="comment-img" href="{{ action('UserController@getIndex', $comment->user->getID()) }}">
                                    <span class="profile-image" style="background-image:url('{{ is_null($comment->user->avatar) ? url('/') . '/images/sample_profile.png' : $comment->user->avatar }}')"></span>
                                </a>
                            </div>
                            <div class="comment-head table-cell">
                                <a href="{{ action('UserController@getIndex', $comment->user->getID()) }}">
                                    <c-name>{{ ($comment->user->option->show_full_name == 1) ? $comment->user->full_name : $comment->user->username }}</c-name>
                                </a>
                                <span class="comment-detail">
                                    {{ $comment->message }}
                                </span>

                                <div class="comment-footer">
                                    <span class="comment-time">
                                        <p1>{{ date("d M Y",strtotime($comment->updated_at)) }}</p1>
                                    </span>
                                    &middot;
                                    <span class="comment-like">
                                        @if(\Auth::user()->check())
                                            <a class="comment-like-link"
                                               data-comment-id="{{ $comment->id }}"><i
                                                        class="fa fa-heart enable {{ \Auth::user()->user()->isCommentLiked($comment->id) ? 'like-cmm' : '' }}"></i>
                                                <span>{{ count($comment->likes) }}</span></a>
                                            @if(\Auth::user()->user()->isOwner($comment->user->id))
                                                &nbsp;<a href="{{ action('CampaignController@getDeleteComment', [\Auth::user()->user()->id, $comment->id]) }}"><i class="fa fa-trash"></i>&nbsp;</a>
                                            @endif
                                        @else
                                            <i class="fa fa-heart login-first"></i>
                                            <span>{{ count($comment->likes) }}</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="border-box-comment"></div>
                        </div>
                    @endforeach
                </div>
                <div class="box-comment">
                    @if(Auth::user()->check())
                        <input name="_token" id="token" type="hidden" value="{{ csrf_token() }}"/>
                        <input name="campaign_id" id="campaign-id" type="hidden" value="{{ $campaign->id }}"/>
                        <input name="user_id" id="user-id" type="hidden"
                               value="{{ Auth::user()->user()->id }}"/>

                        <div class="comment-img">
                            <img class="profile-image" src="{{ is_null(Auth::user()->user()->avatar) ? url('/') . '/images/sample_profile.png' : Auth::user()->user()->avatar }}">
                        </div>
                        <div class="comment-head table-cell">
                                <span class="comment-detail">
                                    <textarea rows="1" name="message" id="message"
                                              placeholder="แสดงความคิดเห็นของคุณ"></textarea>
                                    <button class="btn btn-primary btn-sm column" id="btn-post"
                                            data-url="{{ action('CampaignController@postSaveComment') }}">
                                        {{ Lang::get('messages.post') }}
                                    </button>
                                </span>
                        </div>

                    @else
                        <p>กรุณา<a href="{{ url('/user/login') }}" id="login-link">ล็อกอิน</a>เข้าสู่ระบบเพื่อแสดงความคิดเห็น
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if(\Auth::user()->check())
        <div id="modal-campaign-report" class="modal fade modal-fullscreen" tabindex="-1" role="dialog" aria-labelledby="qrcodeline"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-header">
                    <h4 class="modal-title">ช่วยให้เราเข้าใจสิ่งที่กำลังเกิดขึ้น</h4>
                </div>
                <div class="modal-body">
                    <p class="text-bold">คุณต้องการแจ้งในเรื่องใด</p>
                    <select name="report_type_name" id="report-type" class="form-control">
                        <option value="privacy">แคมเปญนี้มีเนื้อหาที่ละเมิดลิขสิทธิ์</option>
                        <option value="abuse">แคมเปญนี้มีเนื้อหาที่ไม่เหมาะสม</option>
                        <option value="etc">รายงานเรื่องอื่นๆ</option>
                    </select>

                    <textarea id="detail" class="form-control" rows="3" placeholder="ใส่รายละเอียดเพื่อให้เราตรวจสอบได้ง่ายขึ้น"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="send-campaign-report"
                            data-token="{{ csrf_token() }}"
                            data-url="{{ action('HomeController@postReport', \Auth::user()->user()->id) }}"
                            data-campaign-id="{{ $campaign->id }}">ส่ง
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    @endif
    <div id="reserve-modal" class="modal fade modal-fullscreen" tabindex="-1" role="dialog"
         aria-labelledby="qrcodeline"
         aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-header">
                <h4 class="modal-title">จองแคมเปญนี้</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form id="reserve-form" method="POST"
                          action="{{ action('CampaignController@postReserve', $campaign->id) }}">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>

                        <div class="form-group">
                            <div class="col-md-3">
                                <label for="email">ที่อยู่อีเมล์:</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" name="email" id="email" class="form-control"
                                       placeholder="ที่อยู่อีเมล์" value="{{ \Auth::user()->check() ? \Auth::user()->user()->email : ''}}"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer" style="background: #fff;">
                <button type="button" class="btn btn-success" id="send-reserve-button">ยืนยัน</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
    <div id="tshirt-size" class="modal fade modal-fullscreen" tabindex="-1" role="dialog"
         aria-labelledby="qrcodeline"
         aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-header" style="border-bottom: 1px solid #ddd;">
                <h4 class="modal-title">ตารางเปรียบเทียบขนาดเสื้อ</h4>
            </div>
            <div class="modal-body">
                <div class="col-md-4 col-sm-4 mobile-hidden">
                    <img width="100%" src="{{asset('images/default/t-size.png')}}">
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <table class="table-form">
                        <thead>
                        <tr>
                            <th>ขนาด</th>
                            <th>รอบอก(นิ้ว)</th>
                            <th>ความยาว(นิ้ว)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>S</td>
                            <td>{{ $campaign->products()->first()->product->description()->first()->s_width}}</td>
                            <td>{{ $campaign->products()->first()->product->description()->first()->s_height}}</td>
                        </tr>
                        <tr>
                            <td>M</td>
                            <td>{{ $campaign->products()->first()->product->description()->first()->m_width}}</td>
                            <td>{{ $campaign->products()->first()->product->description()->first()->m_height}}</td>
                        </tr>
                        <tr>
                            <td>L</td>
                            <td>{{ $campaign->products()->first()->product->description()->first()->l_width}}</td>
                            <td>{{ $campaign->products()->first()->product->description()->first()->l_height}}</td>
                        </tr>
                        <tr>
                            <td>XL</td>
                            <td>{{ $campaign->products()->first()->product->description()->first()->xl_width}}</td>
                            <td>{{ $campaign->products()->first()->product->description()->first()->xl_height}}</td>
                        </tr>
                        <tr>
                            <td>XXL</td>
                            <td>{{ $campaign->products()->first()->product->description()->first()->xxl_width}}</td>
                            <td>{{ $campaign->products()->first()->product->description()->first()->xxl_height}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer" style="background: #fff;">
                <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
@stop
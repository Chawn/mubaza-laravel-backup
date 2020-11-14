$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var front_thumbnail_completed = false;
    var back_thumbnail_completed = false;
    var front_frame_completed = false;
    var back_frame_completed = false;
    loadDesign();
    get_product_list($("#select_category").val());

    function getProductData() {
        $.ajax({
            method: 'POST',
            url: './product/all-products',
            dataType: "json",
            success: function (data) {
                if (data.success) {
                    var hash_data = getHashID();
                    var key = hash_data[0];
                    var item_no = hash_data[1];
                    var campaign = parseOut(key + '/' + item_no);
                    campaign.products = data.products;
                    parseIn(key + '/' + item_no, campaign);
                }
            },
            failure: function (errMsg) {
                alert(errMsg);
            }
        });
    }

    /* input-text-color */
    $("#dialog-text-color").dialog({
        autoOpen: false,
        position: {
            of: $("#input-text-color"),
            my: "left top",
            at: "left bottom"
        },
        resizable: false,
        draggable: false,
        width: 150,
        clickOutside: true,
        clickOutsideTrigger: "#input-text-color"
    });
    $(".ui-dialog-titlebar").hide();


    $("#input-text-color").click(function () {
        $("#dialog-text-color").dialog("open");
    });

    $(".text-color").click(function () {
        var color = $(this).attr('data-color');
        $("#input-text-color").attr('data-color', color);
        $("#input-text-color").css('background-color', color);

        $(".item-active.item-text").attr('data-color', color);
        $(".item-active.item-text").find('.item-inner').css({
            'color': color
        });

        updateTextItem('.item-active');
        //refreshCountBlock();
        //cal_price();
    });

    /* End Input Text Color */
    $('[data-toggle="tooltip"]').tooltip();

    $(".design-dialog").hide();
    $(".item-tool").hide('fast');


    $("#toggle-location").click(function () {
        $('.custom-frame').toggleClass('active');
        $('.frame-front').toggleClass('frame-active');
        $('.frame-back').toggleClass('frame-active');
        $('.toggle-look').toggleClass('hide');
    });

    $("#dialog-font").dialog({
        autoOpen: false,
        position: {
            of: $("#fake-select"),
            my: "left top",
            at: "left bottom",
        },
        resizable: false,
        draggable: false,
        width: 278,
        clickOutside: true,
        clickOutsideTrigger: "#fake-select"
    });

    $(".ui-dialog-titlebar").hide();
    $("#fake-select").click(function () {
        $("#dialog-font").dialog('open');

    });
    function hide_dialog() {
        $(".arrow-dropdown").removeClass('arrow-2');
        $(".arrow-dropdown").addClass('arrow-1');
        $(".dialog").hide();
    }

    $("#select-font-type").change(function () {
        var font_type = $(this).val();
        $(".font-list").addClass('hide');
        $(".font-list." + font_type).removeClass('hide');
    });
    $(".select-font").click(function () {
        $("#fake-select > span").html($(this).text());
        $("#fake-select > span").css({
            'font-family': $(this).css('font-family')
        });
        hide_dialog();
        var fontfamily = $("#fake-select > span").css('font-family');
        $(".text-active").css({
            'font-family': fontfamily
        });
        $(".item-active").attr('data-fontfamily', fontfamily);
        updateTextItem($(".item-active"));
    });
    $(".select-font").mouseover(function () {
        $(".text-active").css({
            'font-family': $(this).css('font-family')
        });
    });
    $(".select-font").mouseout(function () {
        $(".text-active").css({
            'font-family': $("#fake-select > span").css('font-family')
        });
    });
    $.fn.textWidth = function () {
        var html_org = $(this).html();
        var html_calc = '<span>' + html_org + '</span>';
        $(this).html(html_calc);
        var width = $(this).find('span:first').width();
        $(this).html(html_org);
        return width;
    };

    $("#input-font-size").bind("keyup change", function (e) {
        $(".text-active").css({
            'font-size': $(this).val() + "px",
            'line-height': $(this).val() + "px",
            'width': 'auto',
            'height': 'auto'
        });
        $(".item-active").width($(".text-active").textWidth());
        $(".item-active").attr('data-fontsize', $(this).val());
    });

    $("#btn-select-file").click(function () {
        $("#upload-picture").click();
    });

    $("#upload-picture").change(function () {
        $("#form-upload").submit();
    });

    $("#custom-area").click(function () {
        $(".item-blank").remove();
        $(".item").find('.item-inner').removeClass('text-active');

        $(".item").removeClass('item-active');

        $(".text-tool").hide('fast');
        $(".picture-tool").hide('fast');

        clear_input_text();
        hide_dialog();
    });

    /*-- grobal function --*/



    /*-- grobal function --*/
    function clear_input_text() {
        clearListLang();
        $("#input-text").val("");
        $("#input-text").removeClass("edit-text");
        $("#input-text").addClass("new-text");
        $("#input-text-color").attr("data-color", "#000000");
        $("#input-text-color").val("#000000");
        $("#input-text-color").css("background-color", "#000000");
        $("#input-font-size").val("40");
        $(".set-align").removeClass('active');
        $(".set-align-center").addClass('active');
    }

    function set_text_active(item) {
        $('.item').find('.item-inner').removeClass('text-active');
        item.find('.item-inner').addClass('text-active');

        $(".item").removeClass('item-active');
        item.addClass('item-active');

        $("#input-text").val(item.text());
        $("#input-text").addClass("edit-text");
        $("#input-text").removeClass("new-text");

        var fontsize = parseInt(item.attr("data-fontsize"));

        $("#input-font-size").val(fontsize);

        var fontfamily = item.attr('data-fontfamily');

        $("#fake-select > span").text(fontfamily);
        $("#fake-select > span").css({
            'font-family': fontfamily
        });

        var color = item.attr('data-color');
        $("#input-text-color").attr('data-color', color);
        $("#input-text-color").val(color);
        $("#input-text-color").css('background-color', color);

        var align = item.attr('data-align');
        $(".set-align").removeClass('active');
        $(".set-align-" + align).addClass('active');

        $(".text-tool").show('fast');
        $("#tab-text").click();
    }

    function set_picture_active(item) {
        $(".item").removeClass('item-active');
        item.removeClass('item-active');
        item.addClass('item-active');
        $(".item-tool").show('fast');
        $("#tab-picture").click();
    }

    /*-- Input Text --*/
    function setListLangThai() {
        $(".font-list.all").addClass('hide');
        $(".font-list.thai").removeClass('hide');
    }

    function clearListLang() {
        $(".font-list.all").removeClass('hide');
        $(".font-list.thai").addClass('hide');
    }

    $("#input-text").keyup(function (e) {
        /*var value = String.fromCharCode(e.which);
         alert(value);*/
        $.fn.textWidth = function () {
            var html_org = $(this).html();
            var html_calc = '<span>' + html_org + '</span>';
            $(this).html(html_calc);
            var width = $(this).find('span:first').width();
            $(this).html(html_org);
            return width;
        };
        $(".item-active > .item-inner").css('font-size', 'auto');
        $(".item-active").css('width', 'auto');

        if ($(this).hasClass('edit-text')) {
            var value = $(this).val();
            if (value != "") {
                $('.item-active').removeClass('item-blank');
                $(".text-active").text(value);
                updateTextItem(".item-active");
            }
            else {
                $('.text-active').text("ใส่ข้อความ");
                $('.item-active').addClass('item-blank');
                // remove_item($('.item-active'));
                // $("#input-text").removeClass('edit-text');
                // $("#input-text").addClass('new-text');
            }
            guessLanguage.info(this.value, function (info) {
                //alert(info[0]);
                if (info[0] == "th") {
                    setListLangThai();
                    $('.item-active').attr('data-lang', 'th');
                } else {
                    $('.item-active').attr('data-lang', 'en');
                }
            });
        }
        else if ($(this).hasClass('new-text')) {
            var new_id = new_text();
            setTimeout(function () {
                storeNewTextItem(new_id);
            }, 1000);
            guessLanguage.info(this.value, function (info) {
                if (info[0] == "th") {
                    setListLangThai();
                    $('.item-active').attr('data-lang', 'th');
                } else {
                    $('.item-active').attr('data-lang', 'en');
                }
            });
        }
        check_outer_frame();
    });

    function new_text() {
        var active_frame = $("div.active > div.frame");
        var location = active_frame.data('location');
        $(".item").removeClass("item-active");
        $(".text").removeClass("text-active");
        $(".text-tool").show();

        var new_class = "";
        var fontstyle = "";
        $(".fontstyle-active").each(function () {
            if (new_class != "") {
                new_class = new_class + " " + $(this).data('classstyle');
                fontstyle = fontstyle + "," + $(this).data('shortname');
            }
            else {
                new_class = $(this).data('classstyle');
                fontstyle = $(this).data('shortname');
            }
        });
        var font_family = $("#fake-select > span").css('font-family');
        var font_size = $("#input-font-size").val();

        if ($(".item").length == 0) {
            var next_item = 0;
        } else {
            var next_item = $(".item").length;
        }

        if ($(".item-text").length == 0) {
            var next_text = 0;
        } else {
            var next_text = $(".item-text").length;
        }

        var next_zindex = parseInt(next_item) + 9;
        var align = $('.set-align.active').attr('data-align');
        var color = $("#input-text-color").attr('data-color');

        var item = "<div class='item item-active item-text item-text-" + next_text + "'"
            + " data-name='item-text-" + next_text + "'"
            + " style='z-index:" + next_zindex + ";left:0px;top:0px;'"
            + " data-posx='0'"
            + " data-posy='0'"
            + " data-no='" + next_item + "'"
            + " data-rotate='0' data-location='" + location + "'"
            + " data-fontfamily='" + font_family + "'"
            + " data-color='" + color + "'"
            + " data-align='" + align + "'"
            + " data-fontsize='" + font_size + "'>"
            + "<div class='item-inner text text-active " + new_class + "'"
            + " style='font-family: " + font_family + "; color:" + color + "; font-size:" + font_size + "px; text-align:" + align + ";'>"
            + $("#input-text").val()
            + "</div>"
            + "<div class='icon icon-drag'>"
            + "</div>"
            + "<div class='icon icon-remove'>"
            + "</div>"
            + "</div>";
        active_frame.append(item);


        $("#input-text").removeClass('new-text');
        $("#input-text").addClass('edit-text');

        base_text();

        return ".item-text-" + next_text;
    }

    function base_text() {
        $.fn.textWidth = function () {
            var html_org = $(this).html();
            var html_calc = '<span>' + html_org + '</span>';
            $(this).html(html_calc);
            var width = $(this).find('span:first').width();
            $(this).html(html_org);
            return width;
        };

        var onresize = false;

        var div = $(".item-text");
        var span = div.find('.item-inner');

        $(".item-text").resizable({
            /*containment: "parent",*/
            /*ghost: true,*/
            aspectRatio: true,
            distance: 1,
            minHeight: 10,
            minWidth: 10,

            start: function (event, ui) {
                div = $(this);
                span = div.find('.item-inner');
                onresize = true;
                enteredFont = span.css("font-size");
                /*div.css("border", "none");*/
            },
            resize: function (event, ui) {
                var fontsize = "";
                if (onresize) {
                    span.css("line-height", ui.size.height + "px");
                    span.css("font-size", ui.size.height);
                    ui.helper.width(span.textWidth());
                    fontsize = ui.size.height;
                    $(this).attr('data-fontsize', fontsize);
                    $("#input-font-size").val(fontsize);
                }
                check_outer_frame();

            },
            stop: function (e, ui) {
                onresize = false;
                div.width(span.textWidth());
                div.css("height", "auto");
                /*div.css("border", "1px solid #999");*/
                var position = $(".item-active").position();
                $(this).attr('data-posx', position.left);
                $(this).attr('data-posy', position.top);
                updateTextItem(".item-text-" + $(this).data('no'));
            }
        });

        var params = {
            start: function (event, ui) {
            },
            rotate: function (event, ui) {
            },
            stop: function (event, ui) {
            }
        };

        $(".item-text").rotatable({
            stop: function () {
                var el = $(this);
                var Matrix = el.css('transform');
                $(this).attr('data-rotate', Matrix);
                updateTextItem(".item-text-" + $(this).data('no'));
                check_outer_frame();
            }
        });

        $(".item-text").draggable({
            /*containment: "parent",*/
            start: function () {
                set_text_active($(this));
            },
            drag: function () {
                check_outer_frame();
            },
            stop: function () {
                var position = $(this).position();
                $(this).attr('data-posx', position.left);
                $(this).attr('data-posy', position.top);
                updateTextItem($(this));
            }
        });

        $(document).on('click', ".item-text", function () {
            set_text_active($(this));
        });

        $(".icon-remove").click(function () {
            var no = $('.item-active').data('no');
            $(".text-tool").hide('fast');
            removeItem(no);
        });
    }

    function check_outer_frame() {
        var item = "";
        var item_offset = "";
        var item_top = "";
        var item_left = "";
        var item_bottom = "";
        var item_right = "";
        var frame = "";
        var frame_offset = "";
        var frame_top = "";
        var frame_left = "";
        var frame_bottom = "";
        var frame_right = "";

        if ($('.item-active').length > 0) {
            var fail = false;
            item = $('.item-active');
            item_offset = item.offset();
            item_top = item_offset.top;
            item_left = item_offset.left;
            item_bottom = item_offset.top + item.outerHeight();
            item_right = item_offset.left + item.outerWidth();

            frame = $('.frame-active');
            frame_offset = frame.offset();
            frame_top = frame_offset.top;
            frame_left = frame_offset.left;
            frame_bottom = frame_offset.top + frame.outerHeight();
            frame_right = frame_offset.left + frame.outerWidth();

            var border_red = "solid 2px red";
            if (item_right >= frame_right) {
                $(".frame-active").css('border', border_red);
                $(".frame-active").attr('data-out', 'true');
            }
            ;
            if (item_left <= frame_left) {
                $(".frame-active").css('border', border_red);
                $(".frame-active").attr('data-out', 'true');
            }
            ;
            if (item_top <= frame_top) {
                $(".frame-active").css('border', border_red);
                $(".frame-active").attr('data-out', 'true');
            }
            ;
            if (item_bottom >= frame_bottom) {
                $(".frame-active").css('border', border_red);
                $(".frame-active").attr('data-out', 'true');
            }
            ;

            if (item_right <= frame_right && item_left >= frame_left) {
                if (item_top >= frame_top && item_bottom <= frame_bottom) {
                    $(".frame-active").css('border', 'none');
                    $(".frame-active").attr('data-out', 'false');
                }
            }
        }

    }

    function update_data_text(data_name, data) {
        $(".text-active").attr(data_name, data);
        $("#input-font-size").val($(".text-active").attr('data-fontsize'));
    }

    /*-- End Input Text --*/

    /*-- Pictures --*/


    function new_picture(picture) {
        $(".picture-tool").show('fast');
        $(".item").removeClass("item-active");

        var active_frame = $("div.active > div.frame");
        var location = active_frame.data('location');

        var next_item = $(".item").length + 1;
        if ($(".item").length == 0) {
            var next_item = 0;
        } else {
            var next_item = $(".item").length;
        }

        if ($(".item-picture").length == 0) {
            var next_picture = 0;
        } else {
            var next_picture = $(".item-picture").length;
        }

        var picture_price = 20;

        src = picture.data('original');
        id = picture.children('img.picture').data('id');

        var frame_width = parseInt(parseInt($('.frame-active').width()) / 2);

        item = "<div class='item item-active item-picture item-picture-" + next_item + "'"
            + " data-name='item-picture-" + next_item + "'"
            + " data-width='" + frame_width + "'"
            + " data-color='" + picture.attr('data-color') + "'"
            + " data-color-count='" + picture.attr('data-color-count') + "'"
            + " data-posx='" + 0 + "'"
            + " data-posy='" + 0 + "'"
            + " data-location='" + location + "'"
            + " data-url='" + src + "'"
            + " data-no='" + next_item + "'"
            + " data-rotate='0'"
            + " style='top:0; left:0; width:" + frame_width + "px;'>"
            + " <div class='item-inner'>"
            + "<img class='picture' src='" + src + "' style='width:100%; height:100%;'>"
            + "</div>"
            + "<div class='tool'>"
            + "<div class='icon icon-drag'>"
            + "</div>"
            + "<div class='icon icon-remove'>"
            + "</div>"
            + "</div>"
            + "</div>";


        $(".frame-active").append(item);

        var img_height = parseInt($(".item-active").find('img.picture').height()) + 2;
        $(".item-active").attr('data-height', img_height);
        $(".item-active").css('height', $(this));
        $(".item-active").css("z-index", next_item + 9);

        base_picture();

        return $(".item-picture-" + next_item);
    }

    function base_picture() {
        var item_active = $(".item-active");
        var item_picture = $(".item-picture");
        /*

         item_active.attr('data-height', item_active.height());
         item_active.attr('data-width', item_active.width());
         var position = item_active.position();
         item_active.attr('data-posx', position.left);
         item_active.attr('data-posy', position.top);*/

        item_picture.resizable({
            aspectRatio: true,
            /*containment: "parent",*/
            create: function () {
            },
            resize: function (event, ui) {
                var size = ui.size;

                $(this).find('img').css({
                    "height": "100%",
                    "width": "100%"
                });

                check_outer_frame();
            },
            stop: function (e, ui) {
                $(this).css('height', parseInt(ui.size.height) + 'px');
                $(this).css('width', parseInt(ui.size.width) + 'px')
                $(this).attr('data-height', parseInt(ui.size.height));
                $(this).attr('data-width', parseInt(ui.size.width));

                var position = item_picture.position();
                $(this).attr('data-posx', position.left);
                $(this).attr('data-posy', position.top);

                updatePictureItem($(this));
            }
        });

        var params = {
            start: function (event, ui) {
            },
            rotate: function (event, ui) {
            },
            stop: function (event, ui) {
            }
        };

        item_picture.rotatable({
            rotate: function () {
                check_outer_frame();
            },
            stop: function () {
                var el = $(this);
                var Matrix = el.css('transform');
                $(this).attr('data-rotate', Matrix);
                updatePictureItem($(this));
            }
        });

        item_picture.draggable({
            start: function () {
                set_picture_active($(this));
            },
            drag: function () {
                check_outer_frame();
            },
            /*containment: "parent",*/
            stop: function () {
                var position = $(".item-active").position();
                $(this).attr('data-posx', position.left);
                $(this).attr('data-posy', position.top);
                updatePictureItem($(this));
            }
        });

        $(document).on('click', ".item-picture", function () {
            set_picture_active($(this));
        });

        $(".icon-remove").click(function () {
            var no = $('.item-active').data('no');

            removeItem(no);
        });
    }

    /*-- End Pictures--*/
    /*-- Select Product --*/

    function loadProduct() {
        var hash_id = getHashID();
        var key = hash_id[0] + '/' + hash_id[1];
        var campaign = parseOut(key);
        data = campaign.campaign.product[0];

        $(".frame").css({
            left: data.outline.left + "px",
            top: data.outline.top + "px",
            width: data.outline.width + "px",
            height: data.outline.height + "px"
        });
        $(".frame").removeClass('hide');

        var product_front_now = $("#product-front-now");
        product_front_now.attr('src', data.image_front);
        $("#product-back-now").attr('src', data.image_back);
        product_front_now.attr('data-product-id', data.id);
        product_front_now.attr('data-product-name', data.name);
        product_front_now.attr('data-color', data.color);
        product_front_now.attr('data-color-name', data.color_name);
        product_front_now.attr('data-color-id', data.image_id);
        product_front_now.attr('data-one-side-price', data.one_side_price);
        product_front_now.attr('data-two-side-price', data.two_side_price);
        product_front_now.attr('data-left', data.outline.left);
        product_front_now.attr('data-top', data.outline.top);
        product_front_now.attr('data-width', data.outline.width);
        product_front_now.attr('data-height', data.outline.height);

        var current_product_id = $("#product-front-now").attr('data-product-id');
        var current_color = $("#product-front-now").attr('data-color');
        var product_color = $("#product-" + current_product_id).closest('li').find('[data-color=' + current_color + ']');


        $('.select-product-color').removeClass('active');
        product_color.addClass('active');

        $('.product-row').remove();
        $(".badge-amount").text("0");


        var hash_data = getHashID();
        var key = hash_data[0];
        var item_no = hash_data[1];
        var campaign = parseOut(key + '/' + item_no);
        var next_key = key + '/' + (parseInt(item_no) + 1);
        parseIn(next_key, campaign);
        setUrl(next_key);

        //updateOrder();
        updateCampaignTitle();
        updateProductItem();
    }

    function clear_order() {
        $('.product-row').remove();
        $(".badge-amount").text("0");
    }

    function change_product(id) {
        $.ajax({
            type: "GET",
            url: $("#product-front-now").attr('data-url') + "/" + id,
            dataType: "json",
            success: function (data) {
                var hash_id = getHashID();
                var key = hash_id[0] + '/' + hash_id[1];
                var campaign = parseOut(key);
                console.log(data);
                //campaign.campaign.order.product_unit_cost = parseInt(data.price);
                var product = {
                    id: id,
                    name: data.name,
                    one_side_price: data.one_side_price,
                    two_side_price: data.two_side_price,
                    color_id: data.product_color_id,
                    color: data.color,
                    color_name: data.color_name,
                    image_front: data.image_front,
                    image_back: data.image_back,
                    outline : {
                        left: data.left,
                        top: data.top,
                        width: data.width,
                        height: data.height
                    }
                };
                //campaign.product = data;
                parseIn(key, campaign);

                $(".frame").css({
                    left: data.left + "px",
                    top: data.top + "px",
                    width: data.width + "px",
                    height: data.height + "px"
                });
                $(".frame").removeClass('hide');

                var product_front_now = $("#product-front-now");
                product_front_now.attr('src', data.image_front);
                $("#product-back-now").attr('src', data.image_back);
                product_front_now.attr('data-product-id', data.id);
                product_front_now.attr('data-category-id', data.category_id);
                product_front_now.attr('data-product-name', data.name);
                product_front_now.attr('data-one-side-price', data.one_side_price);
                product_front_now.attr('data-two-side-price', data.two_side_price);
                product_front_now.attr('data-color', data.color);
                product_front_now.attr('data-color-name', data.color_name);
                product_front_now.attr('data-color-id', data.product_color_id);
                product_front_now.attr('data-size', data.size);
                product_front_now.attr('data-left', data.left);
                product_front_now.attr('data-top', data.top);
                product_front_now.attr('data-width', data.width);
                product_front_now.attr('data-height', data.height);

                var current_product_id = $("#product-front-now").attr('data-product-id');
                var current_color = $("#product-front-now").attr('data-color');
                var product_color = $("#product-" + current_product_id).closest('li').find('[data-color=' + current_color + ']');


                $('.select-product-color').removeClass('active');
                product_color.addClass('active');

                clear_order();


                var hash_data = getHashID();
                var key = hash_data[0];
                var item_no = hash_data[1];
                var campaign = parseOut(key + '/' + item_no);
                var next_key = key + '/' + (parseInt(item_no) + 1);
                parseIn(next_key, campaign);
                setUrl(next_key);

                //updateOrder();
                updateCampaignTitle();
                updateProductItem();
            },
            failure: function (errMsg) {
                alert(errMsg);
            }
        });


    }

    function change_color(button_color) {

        $("#product-front-now").attr('data-color', button_color.attr('data-color'));
        $("#product-front-now").attr('data-color-name', button_color.attr('data-color-name'));
        $("#product-front-now").attr('data-color-id', button_color.attr('data-color-id'));

        //$("#product-front-now").attr('data-sizehas',button_color.attr('data-sizehas'))

        $(".product-now-front").attr('src', button_color.attr('data-img-front'));
        $(".product-now-back").attr('src', button_color.attr('data-img-back'));

        $(".select-product-color").removeClass("active");
        $(".select-product-color").removeClass("disabled");
        button_color.addClass("active");
        button_color.addClass("disabled");

        var hash_data = getHashID();
        var key = hash_data[0];
        var item_no = hash_data[1];
        var campaign = parseOut(key + '/' + item_no);
        var next_key = key + '/' + (parseInt(item_no) + 1);
        campaign.campaign.product.color = button_color.attr('data-color');
        campaign.campaign.product.color_name = button_color.attr('data-color-name');
        campaign.campaign.product.image_id = button_color.attr('data-color-id');
        campaign.campaign.product.image_front = button_color.attr('data-img-front');
        campaign.campaign.product.image_back = button_color.attr('data-img-back');
        parseIn(next_key, campaign);
        setUrl(next_key);

        clear_order();

        //updateOrder();
        updateProductItem();
    }


    function get_product_list(id) {
        $.ajax({
            type: "GET",
            url: $("#product-list").attr("data-url") + "/" + id,
            dataType: "json",
            success: function (data) {
                $("#product-list").text("");
                $("#product-list").append(data.html);

                /*-- Select Product --*/
                var current_product_id = $("#product-front-now").attr('data-product-id');
                $("#product-list li").find("#product-" + current_product_id).addClass('active');
                $("#product-" + current_product_id).closest('li').find('.color-box').removeClass('hide');

                var current_color = $("#product-front-now").attr('data-color');
                var product_color = $("#product-" + current_product_id).closest('li').find('[data-color=' + current_color + ']');
                product_color.addClass('active');

                $("#product-" + current_product_id).closest('li').find('.color-box').find('.select-product-color');

                $(".btn-select-product").click(function () {
                    if (!$(this).hasClass('active')) {
                        change_product($(this).attr('data-id'));
                        $(".btn-select-product").removeClass('active');
                        $(this).addClass('active');
                        $('.color-box').addClass('hide');
                        $(this).closest('li').find('.color-box').removeClass('hide');
                    }
                });

                /*-- End Select Product--*/

                $(".select-product-color").click(function () {
                    change_color($(this));
                });

                $(".select-product-color").attr('data-color')

            },
            failure: function (errMsg) {
                alert(errMsg);
            }
        });
    }

    $("#select_category").change(function () {
        get_product_list($(this).val());
    });

    /*-- End Select Product --*/

    /*-- Text Tool--*/
    $('.set-align').click(function () {
        $('.set-align').removeClass('active');
        $(this).addClass('active');
        $('.item-active.item-text').attr('data-align', $(this).attr('data-align'));
        $('.text-active').css('text-align', $(this).attr('data-align'));
        updateTextItem('.item-active');
    })

    $(".text-tool > .move-down").click(function () {
        var active = parseInt($(".item-active").css('z-index'));
        var new_index = active - 1;
        var pre_index = active + 1

        $(".item").each(function () {
            var this_index = parseInt($(this).css("z-index"));
            if (this_index <= new_index) {
                var min = this_index;
                $(this).css("z-index", this_index + 1);

            }
            if (min < active) {
                $(".item-active").css('z-index', new_index);
            }
        });

        updateTextItem($(".item-active"));
    });

    $(".text-tool > .move-center").click(function () {
        var frame_width = $(".frame").width();
        var item_width = $(".item-active").width();
        var left_center = ((frame_width - item_width) / 2) - 1;
        $(".item-active").attr('data-posx', left_center);
        $(".item-active").css({
            'left': left_center + "px"
        });
        updateTextItem($(".item-active"));
    })

    $(".text-tool > .copy-item").click(function () {
        var new_id = new_text();
        storeNewTextItem(new_id);
    });

    /*-- End Text Tool--*/

    /*-- Picture Tool--*/

    $(".picture-tool > .move-down").click(function () {
        var active = parseInt($(".item-active").css('z-index'));
        var new_index = active - 1;
        var pre_index = active + 1

        $(".item").each(function () {
            var this_index = parseInt($(this).css("z-index"));
            if (this_index <= new_index) {
                var min = this_index;
                $(this).css("z-index", this_index + 1);

            }
            if (min < active) {
                $(".item-active").css('z-index', new_index);
            }
            ;
        });

        updatePictureItem($(".item-active"));
    });

    $(".picture-tool > .move-center").click(function () {
        var frame_width = $(".frame").width();
        var item_width = $(".item-active").width();
        var left_center = ((frame_width - item_width) / 2) - 1;
        $(".item-active").css({
            'left': left_center + "px"
        });
        updatePictureItem($(".item-active"));
    })

    /*-- End Picture Tool--*/

    /*-- Choose Size --*/
    $("#btn-choose-size").click(function () {
        //var color = $('#product-front-now').attr('data-color').replace('#', '');
        var product_id = $('#product-front-now').attr('data-product-id');
        var image_id = $('#product-front-now').attr('data-color-id');
        var category_id = $('#product-front-now').attr('data-category-id');
        addRow(category_id, product_id, image_id);
        //set_choose_size_modal(id, image_id);
    });

    function addRow(category_id, product_id, image_id)
    {
        var hash_id = getHashID();
        var key = hash_id[0] + '/' + hash_id[1];
        var campaign = parseOut(key);
        console.log(campaign.products);
        //var html = '<tr id="current-product-row" class="product-row product-row-1" data-row="1" data-size="no_selected" data-color-id="1" data-color="#ffffff" data-color-name="สีขาว" data-qty="1">
        //    <td><select name="" class="form-control set-size"><option value="no_selected">เลือก</option><option value="S">S</option><option value="M">M</option><option value="L">L</option><option value="XL">XL</option><option value="XXL">XXL</option></select></td>
        //    <td><input type="number" class="qty form-control" name="qty" value="1" min="1"></td>
        //        <td><div class="btn-group">
        //            <button class="selected-color btn-color btn-lg dropdown-toggle disabled" data-color-id="1" data-color="#ffffff" data-color-name="สีขาว" style="background-color:#ffffff;" data-toggle="dropdown" aria-expanded="false">
        //            </button><div class="dropdown-color dropdown-menu" role="menu"><div class="new-color btn-color btn-lg" data-color-id="4" data-color="#000000" data-color-name="สีดำ" style="background-color:#000000;"></div><div class="new-color btn-color btn-lg" data-color-id="5" data-color="#67686b" data-color-name="สีเทาเข้ม" style="background-color:#67686b;"></div><div class="new-color btn-color btn-lg" data-color-id="6" data-color="#cbcdd0" data-color-name="สีเทาท็อปดราย" style="background-color:#cbcdd0;"></div><div class="new-color btn-color btn-lg" data-color-id="7" data-color="#5a5a59" data-color-name="สีเทาท็อปดรายเข้ม" style="background-color:#5a5a59;"></div><div class="new-color btn-color btn-lg" data-color-id="8" data-color="#00d6ff" data-color-name="สีฟ้า" style="background-color:#00d6ff;"></div><div class="new-color btn-color btn-lg" data-color-id="9" data-color="#4bd4c5" data-color-name="สีเขียวมิ้น" style="background-color:#4bd4c5;"></div><div class="new-color btn-color btn-lg" data-color-id="10" data-color="#ab72ac" data-color-name="สีม่วง" style="background-color:#ab72ac;"></div><div class="new-color btn-color btn-lg" data-color-id="11" data-color="#040c5d" data-color-name="สีกรมท่า" style="background-color:#040c5d;"></div><div class="new-color btn-color btn-lg" data-color-id="12" data-color="#871012" data-color-name="สีเลือดหมู" style="background-color:#871012;"></div><div class="new-color btn-color btn-lg" data-color-id="13" data-color="#f88ac5" data-color-name="สีชมพู" style="background-color:#f88ac5;"></div><div class="new-color btn-color btn-lg" data-color-id="14" data-color="#fde05d" data-color-name="สีเหลือง" style="background-color:#fde05d;"></div><div class="new-color btn-color btn-lg" data-color-id="15" data-color="#ff7b17" data-color-name="สีส้ม" style="background-color:#ff7b17;"></div><div class="new-color btn-color btn-lg" data-color-id="16" data-color="#ef2316" data-color-name="สีแดง" style="background-color:#ef2316;"></div></div></div></td>
        //        <td>
        //            <button class="btn-remove btn btn-default disabled">
        //                <span class="glyphicon glyphicon-trash"></span>
        //            </button>
        //        </td>
        //    </tr>';
    }

    function cal_qty() {
        var sum = 0;
        $('.qty').each(function () {
            sum += parseFloat($(this).val());
        });
        if (isNaN(sum)) {
            sum = 0;
        }

        return sum;
    }

    function set_choose_size_modal(id, image_id) {
        if ($('.product-row').length < 1) {
            $.ajax({
                type: "GET",
                url: $('#choose-size-modal').data('url') + "/" + id + "/" + image_id,
                dataType: "json",
                success: function (data) {
                    function cal_qty() {
                        var sum = 0;
                        $('.qty').each(function () {
                            sum += parseFloat($(this).val());
                        });
                        if (isNaN(sum)) {
                            sum = 0;
                        }
                        $("#product_amount").text(sum);
                        $(".badge-amount").text(sum);

                        if (sum > 0) {
                            $(".btn-add-basket").attr('title', '');
                            $(".btn-add-basket").attr('data-original-title', '');
                            $(".btn-add-basket").attr('data-toggle', '');
                        } else {
                            $(".btn-add-basket").attr('title', 'กรุณาเลือกขนาดและจำนวนก่อน');
                            $(".btn-add-basket").attr('data-original-title', 'กรุณาเลือกขนาดและจำนวนก่อน');
                            $(".btn-add-basket").attr('data-toggle', 'tooltip');
                        }
                        ;
                    }

                    function base_product_row() {
                        $(".new-color").click(function () {
                            new_color($(this));
                        });
                        $(".qty").change(function (event) {
                            $(this).closest('tr').attr('data-qty', $(this).val());
                            var sum_qty = 0;
                            $(".qty").each(function (index, e) {
                                sum_qty = sum_qty + parseInt($(this).val());
                            });
                            $("#product_amount").text(sum_qty);
                        });
                        $(".btn-remove").click(function () {
                            remove_row($(this));
                        });

                        $(".set-size").on('change', function (e) {
                            $(this).closest('tr').attr('data-size', $(this).val());
                        });
                    }


                    function remove_row(btn) {
                        btn.closest('.product-row').remove();
                        new_row_no = parseInt($(".product-row").length);
                        if (new_row_no == 1) {
                            $('.btn-remove').addClass('disabled');
                        }
                    }

                    function new_color(btn) {
                        var selected = btn.closest('.btn-group').find('.selected-color');
                        var current_image_id = selected.attr('data-color-id');
                        var new_image_id = btn.attr('data-color-id');

                        var current_color = selected.attr('data-color');
                        var current_color_name = selected.attr('data-color-name');
                        var new_color = btn.attr('data-color');
                        var new_color_name = btn.attr('data-color-name');

                        btn.closest('tr').attr('data-color-id', new_image_id);
                        btn.attr('data-color-id', current_image_id);
                        selected.attr('data-color-id', new_image_id);

                        btn.closest('tr').attr('data-color', new_color);
                        btn.closest('tr').attr('data-color-name', new_color_name);
                        btn.attr('data-color', current_color);
                        btn.attr('data-color-name', current_color_name);
                        selected.attr('data-color', new_color);
                        selected.attr('data-color-name', new_color_name);

                        selected.css('background-color', new_color);
                        btn.css('background-color', current_color);
                    }

                    $("#choose-size-body").text("");
                    $("#choose-size-body").append(data.html);
                    var new_row_no = 1;

                    base_product_row();

                    $("#add_new_product").click(function () {
                        var current_product = $("#current-product-row");
                        new_row_no = parseInt($(".product-row").length + 1);
                        var row_id = '.product-row-' + new_row_no;
                        var new_row_html = '<tr class="product-row product-row-' + new_row_no + '"'
                            + ' data-row="' + new_row_no + '"'
                            + ' data-size="' + $("#current-product-row").attr('data-size') + '"'
                            + ' data-color="' + $("#current-product-row").attr('data-color') + '"'
                            + ' data-color-name="' + $("#current-product-row").attr('data-color-name') + '"'
                            + ' data-color-id="' + $("#current-product-row").attr('data-color-id') + '"'
                            + ' data-qty="1">'
                            + $("#current-product-row").html() + '</tr>';
                        $("#product_body").append(new_row_html);
                        $('.product-row-' + new_row_no).find('.selected-color').removeClass('disabled');

                        $("#current-product-row").clone();
                        if (new_row_no > 1) {
                            $("#choose-size-modal").find(".btn-remove").removeClass('disabled');
                        }
                        else {
                            $("#choose-size-modal").find(".btn-remove").addClass('disabled');
                        }
                        base_product_row();
                    });

                    /*$('#save-order').click(function() {
                     cal_qty();
                     updateOrder();
                     });*/

                    $('#choose-size-modal').on('hidden.bs.modal', function () {
                        var qty = 0;
                        var total = 0;
                        var product_unit_cost = 0;


                        //alert(total);
                        /* ลบ product-row ที่ซ้ำกับที่มีอยู่ก่อนแล้ว */
                        var product_id = "", product_id2 = "", row = "", row2 = "";
                        $('.product-row').each(function () {
                            size = $(this).attr('data-size');
                            color = $(this).attr('data-color');
                            row = $(this).attr('data-row');
                            $('.product-row').each(function () {
                                size2 = $(this).attr('data-size');
                                if (size2 != "no_selected") {
                                    color2 = $(this).attr('data-color');
                                    row2 = $(this).attr('data-row');
                                    if (row2 != row && row2 > row) {
                                        if (size2 == size && color2 == color) {
                                            $(".product-row-" + row2).remove();
                                        }
                                        ;
                                    }
                                    ;
                                } else {
                                    $(this).remove();
                                }

                            });

                        });
                        cal_qty();
                        //updateOrder();
                    })

                },
                failure: function (errMsg) {
                    alert(errMsg);
                }
            });
        }
        $('#choose-size-modal').on('hidden.bs.modal', function () {
            var qty = 0;
            var total = 0;
            var product_unit_cost = 0;


            //alert(total);
            /* ลบ product-row ที่ซ้ำกับที่มีอยู่ก่อนแล้ว */
            var product_id = "", product_id2 = "", row = "", row2 = "";
            $('.product-row').each(function () {
                size = $(this).attr('data-size');
                color = $(this).attr('data-color');
                row = $(this).attr('data-row');
                $('.product-row').each(function () {
                    size2 = $(this).attr('data-size');
                    if (size2 == "no_selected") {
                        $(this).remove();
                    } else {
                        color2 = $(this).attr('data-color');
                        row2 = $(this).attr('data-row');
                        if (row2 != row && row2 > row) {
                            if (size2 == size && color2 == color) {
                                $(".product-row-" + row2).remove();
                            }
                            ;
                        }
                        ;

                    }

                });

            });

            cal_qty();
            //updateOrder();
        })
    }



    /*-- End Choose Size Modal --*/


    /*---------- Custom Design -----------*/


    $("#refresh").click(function () {
        $(".item").remove();
    });

    var location = "front";

    $(".btn-choose-product").click(function () {
        var image_front = $(this).data('img-front');
        var image_back = $(this).data('img-back');
        $(".product-now-front").attr('src', image_front);
        $(".product-now-back").attr('src', image_back);
    });


    $(".btn-switch-back").click(function () {
        location = "back";
        $(".frame-back").addClass("frame-active");
        $(".frame-back").removeClass("hidden");
        $(".frame-front").removeClass("frame-active");
        $(".frame-front").addClass("hidden");
        $(".btn-location").removeClass('active');
        $(this).addClass("active");

        url = $(this).children('img').attr('src');
        $("#product-front-now").addClass('hidden');
        $("#product-back-now").removeClass('hidden');
    });

    $(".font-style").click(function () {
        $(this).toggleClass("active");
        $(this).toggleClass("fontstyle-active");
    });


    function do_skin() {
        var height = $(".item-active").height();
        var width = $(".item-active").width();
        $(".item-active").attr('data-height', height);
        $(".item-active").attr('data-width', width);
        var position = $(".item-active").position();
        $(".item-active").attr('data-posx', position.left);
        $(".item-active").attr('data-posy', position.top);

        $(".item-skin").resizable({
            /*aspectRatio: 16 / 9 ,*/
            containment: "parent",
            aspectRatio: true,
            start: function () {
                $(".item").removeClass("item-active");
                $(this).addClass("item-active");
            },
            resize: function (event, ui) {
                // handle fontsize here
                // gives you the current size of the div
                var size = ui.size;
                // something like this change the values according to your requirements
                $(this).find('img').css({
                    "height": "100%",
                    "width": "100%"
                });
            },
            stop: function () {
                var height = $(".item-active").css('height');
                var width = $(".item-active").css('width');
                $(this).attr('data-height', height);
                $(this).attr('data-width', width);
                var position = $(".item-active").position();
                $(".item-active").attr('data-posx', position.left);
                $(".item-active").attr('data-posy', position.top);
            }
        });

        $(".item-skin").draggable({
            start: function () {
                $('.item').removeClass('item-active');
                $(this).addClass('item-active');
            },
            containment: "parent",
            stop: function () {
                var position = $(".item-active").position();
                $(this).attr('data-posx', position.left);
                $(this).attr('data-posy', position.top);
            }
        });


    }

    function check_complete(btn_submit) {
        var design_type = $("#design-type").val();
        var complete = false;
        var hash_id = getHashID();
        var key = hash_id[0] + '/' + hash_id[1];
        var campaign = parseOut(key);

        if (design_type == "design") {
            var message = "error message";
            //campaign.campaign.order.total
            if (campaign.campaign.order.total > 0) {
                complete = true;
            } else {
                message = $("#error-qty-message").val();
            }
        } else { //sell
            var item = $(".item");
            if (item.length > 0) {
                complete = true;
            } else {
                message = $("#error-item-message").val();
            }
        }



            if (complete == true) {
                startSave();
            } else {
                alert(message)
            }
        }


    $('.btn-add-basket').click(function () {
        check_complete($('.btn-add-basket'));
    });
    function setupGenerateThumbnail() {
        $(".custom-frame").css({
            '-ms-transform': 'scale(2)',
            '-webkit-transform': 'scale(2)',
            'transform': 'scale(2)',
            'transform-origin': '0 0',
            'z-index': '999999',
            'position': 'absolute',
        });
        var scale_width = $('.custom-frame')[0].getBoundingClientRect().width;
        var scale_height = $('.custom-frame')[0].getBoundingClientRect().height;
        generate_thumbnail_image()
    }
    function generate_thumbnail_image(targen_element, scale_width, scale_height) {
        $("#wait-text-title").text('กรุณารอสักครู่ กำลังบันทึกรูปภาพตัวอย่าง');
        html2canvas($('#location-front'), {
            onrendered: function (canvas) {
                //ดึงข้อมูลจาก canvas มาเก็บไว้ที่ตัวแปล image_front
                console.log("start get front canvas data for uploading");
                var image_front = canvas.toDataURL("image/png")/*.replace("image/png", "image/octet-stream")*/;
                //$(".front-thumbnail").append(Canvas2Image.convertToPNG(canvas));
                //var image_data = $(".front-thumbnail").find("img").attr("src");
                $.ajax({ //บันทึก image_front ลงฐานข้อมูล
                    type: "POST",
                    url: "/design/gen-thumbnail",
                    data: {
                        "location": 'front',
                        "image_data": image_front
                    },
                    dataType: "json",
                    success: function (data) { //บันทึกลงฐานข้อมูลเสร็จแล้ว รับ data กลับมา บันทึกลง localStorage
                        console.log("create front thumbnail response data");
                        updateCampaignImage('thumbnail_front', data.thmb);
                        updateCampaignImage('thumbnail_medium_front', data.thmb_medium);
                        updateCampaignImage('thumbnail_mini_front', data.thmb_mini);
                        //$('#location-front').attr('data-thumbnail-front', data.thmb);
                        front_thumbnail_completed = true;
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            },
            width: scale_width,
            height: scale_height,
            logging: false
        });

        // เพิ่มรอ front_thumnail_completed = true
        // $('#wait-text-title').text('กรุณารอสักครู่ กำลังบันทึกรูปภาพด้านหน้า ');


        html2canvas($('#location-back'), {
            onrendered: function (canvas) {
                console.log("start get back canvas data for uploading");
                var image_back =  canvas.toDataURL("image/png")/*.replace("image/png", "image/octet-stream")*/;
                //$(".back-thumbnail").append(Canvas2Image.convertToPNG(canvas));
                //var image_data = $(".back-thumbnail").find("img").attr("src");
                $.ajax({
                    type: "POST",
                    url: "/design/gen-thumbnail",
                    data: {
                        "location": "back",
                        "image_data": image_back
                    },
                    dataType: "json",
                    success: function (data) {
                        console.log("create front thumbnail response data");
                        updateCampaignImage('thumbnail_back', data.thmb);
                        updateCampaignImage('thumbnail_medium_back', data.thmb_medium);
                        updateCampaignImage('thumbnail_mini_back', data.thmb_mini);
                        $('#location-back').attr('data-thumbnail-back', data.thmb);
                        back_thumbnail_completed = true;
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });
            },
            width: scale_width,
            height: scale_height,
            logging: false
        });
        $('.frame-back').removeClass('transparent-border');
    }

    function generate_frame_image(next_url) {
        var hash_id = getHashID();
        var key = hash_id[0] + '/' + hash_id[1];
        var campaign = parseOut(key);

        var image_url = [];
        var back = '';
        var front = '';
        //$('.frame').css('border-color', 'transparent');
        //$('.frame > .item-active').removeClass('item-active');
        var item_front = $('.frame-front .item').length;
        var item_back = $('.frame-back .item').length;


        $('.item').removeClass('item-active');
        $('#location-front').addClass('active');
        $('#location-back').removeClass('active');
        $('.frame-front').addClass('transparent-border');

        $(".custom-frame").css({
            '-ms-transform': 'scale(10)',
            '-webkit-transform': 'scale(10)',
            'transform': 'scale(10)',
            'transform-origin': '0 0',
            'z-index': '999999',
            'position': 'absolute',

        });
        var scale_width = $('.custom-frame')[0].getBoundingClientRect().width;
        var scale_height = $('.custom-frame')[0].getBoundingClientRect().height;

        var front_url = $('.frame-front').data('url');
        $("#product-front-now").addClass('hidden');

        $("#wait-text-title").text('กรุณารอสักครู่ กำลังบันทึกรูปภาพลาย');

        html2canvas($('#location-front'), {
            onrendered: function (canvas) {
                var image_front = canvas.toDataURL("image/png");

                $.ajax({
                    type: "POST",
                    url: "/design/save-preview-image",
                    data: {
                        "_token": $("#token").val(),
                        "location": 'front',
                        "image_data": image_front
                    },
                    dataType: "json",
                    success: function (data) {
                        updateCampaignImage('front', data.image_url);
                        $('#location-front').attr('data-preview-front', data.image_url);
                        front_frame_completed = true;
                    },
                    failure: function (errMsg) {
                        alert(errMsg);
                    }
                });

            },
            width: scale_width,
            height: scale_height,
            logging: false
        });


        $('.frame-front').removeClass('transparent-border');
        $('#location-back').addClass('active');
        $('#location-front').removeClass('active');
        $('.frame-back').addClass('transparent-border');
        //$(".frame-front").css('zoom', '500%');
        var back_url = $('.frame-back').data('url');

        $("#product-back-now").addClass('hidden');
        html2canvas($('#location-back'), {
            onrendered: function (canvas) {
                var image_back = canvas.toDataURL("image/png");
                var image_url = '';
                if (item_back > 0) {
                    $.ajax({
                        type: "POST",
                        url: "/design/save-preview-image",
                        data: {
                            "_token": $("#token").val(),
                            "location": "back",
                            "image_data": image_back
                        },
                        dataType: "json",
                        success: function (data) {
                            image_url = data.image_url;
                            updateCampaignImage('back', data.image_url);
                            $('#location-back').attr('data-preview-back', data.image_url);
                            back_frame_completed = true;
                        },
                        failure: function (errMsg) {
                            alert(errMsg);
                        }
                    });
                } else {
                    updateCampaignImage('back', image_url);
                    $('#location-back').attr('data-preview-back', image_url);
                    back_frame_completed = true;
                }
            },
            width: scale_width,
            height: scale_height,
            logging: false
        });
        $('.frame-back').removeClass('transparent-border');
            var saveCampaignLoop = setInterval(function () {
                if (front_frame_completed && back_frame_completed) {
                    saveCampaign();
                    clearInterval(saveCampaignLoop);
                }
            }, 1000);
    }
    //
    //
    //$('.btn-add-basket').click(function () {
    //    check_complete($('.btn-add-basket'));
    //});
    //
    function startSave() {
        generate_thumbnail_image();
        var generate_loop = setInterval(function () {
            if (front_thumbnail_completed && back_thumbnail_completed) {
                //generate_frame_image();
                clearInterval(generate_loop);
            }
        }, 1000);
    }
    function saveCampaign() {
        var campaign = getCurrentData();
        $.ajax({
            type: "POST",
            url: "/campaign/save-design-to-buy",
            data: {
                "campaign": campaign.campaign
            },
            dataType: "json",
            success: function (data) {
                if(data.success) {
                    campaign.campaign.id = data.campaign.id;
                    campaign.campaign.base_folder = data.base_folder;
                    setCurrentData(campaign, false);
                    window.location = "/design/choose-product" + getCurrentHashKey();
                } else {
                    alert(data.message);
                }
            },
            failure: function (errMsg) {
                alert(errMsg);
            }
        });

    }
    //function generate_thumbnail_image() {
    //    var back = '';
    //    var front = '';
    //    $('#location-front').addClass('active');
    //    $('#location-back').removeClass('active');
    //    $('.frame-front').addClass('transparent-border');
    //    //$("body").append('<div id="load-bg"></div><div id="loader-text"><div id="wait-text"><span id="wait-text-title">กรุณารอสักครู่</span><span id="dot"></span></div></div>');
    //    //window.scrollTo(0, 0);
    //    //$("body").css('overflow', 'hidden');
    //    //var dot = document.getElementById('dot');
    //    //var int = setInterval(function () {
    //    //    if ((dot.innerHTML += '.').length == 4)
    //    //        dot.innerHTML = '';
    //    //}, 500);
    //
    //    $(".custom-frame").css({
    //        '-ms-transform': 'scale(2)',
    //        '-webkit-transform': 'scale(2)',
    //        'transform': 'scale(2)',
    //        'transform-origin': '0 0',
    //        'z-index': '999999',
    //        'position': 'absolute'
    //    });
    //    var scale_width = $('.custom-frame')[0].getBoundingClientRect().width;
    //    var scale_height = $('.custom-frame')[0].getBoundingClientRect().height;
    //
    //    $("#wait-text-title").text('กรุณารอสักครู่ กำลังบันทึกรูปภาพตัวอย่าง');
    //
    //    html2canvas($('#location-front'), {
    //        onrendered: function (canvas) {
    //            //ดึงข้อมูลจาก canvas มาเก็บไว้ที่ตัวแปล image_front
    //            var image_front = canvas.toDataURL("image/png")/*.replace("image/png", "image/octet-stream")*/;
    //            $.ajax({ //บันทึก image_front ลงฐานข้อมูล
    //                type: "POST",
    //                url: "/design/gen-thumbnail",
    //                data: {
    //                    "location": 'front',
    //                    "image_data": image_front
    //                },
    //                dataType: "json",
    //                success: function (data) { //บันทึกลงฐานข้อมูลเสร็จแล้ว รับ data กลับมา บันทึกลง localStorage
    //                    updateCampaignImage('base_folder', data.base_folder);
    //                    updateCampaignImage('thumbnail_front', data.thmb);
    //                    updateCampaignImage('thumbnail_medium_front', data.thmb_medium);
    //                    updateCampaignImage('thumbnail_mini_front', data.thmb_mini);
    //                    //$('#location-front').attr('data-thumbnail-front', data.thmb);
    //                    front_thumbnail_completed = true;
    //                },
    //                failure: function (errMsg) {
    //                    alert(errMsg);
    //                }
    //            });
    //        },
    //        width: scale_width,
    //        height: scale_height,
    //        logging: false
    //    });
    //
    //    // เพิ่มรอ front_thumnail_completed = true
    //    // $('#wait-text-title').text('กรุณารอสักครู่ กำลังบันทึกรูปภาพด้านหน้า ');
    //    var saveBackPreview = setInterval(function () {
    //        if (front_thumbnail_completed) {
    //            $('.frame-front').removeClass('transparent-border');
    //            $('#location-back').removeClass("active");
    //            $('#location-front').addClass("active");
    //            $('.frame-back').addClass('transparent-border');
    //            html2canvas($('#location-back'), {
    //                onrendered: function (canvas) {
    //                    var image_back = canvas.toDataURL("image/png");
    //                    $.ajax({
    //                        type: "POST",
    //                        url: "/design/gen-thumbnail",
    //                        data: {
    //                            "location": "back",
    //                            "image_data": image_back
    //                        },
    //                        dataType: "json",
    //                        success: function (data) {
    //                            updateCampaignImage('thumbnail_back', data.thmb);
    //                            updateCampaignImage('thumbnail_medium_back', data.thmb_medium);
    //                            updateCampaignImage('thumbnail_mini_back', data.thmb_mini);
    //                            $('#location-back').attr('data-thumbnail-back', data.thmb);
    //                            back_thumbnail_completed = true;
    //                        },
    //                        failure: function (errMsg) {
    //                            alert(errMsg);
    //                        }
    //                    });
    //                },
    //                width: scale_width,
    //                height: scale_height,
    //                logging: false
    //            });
    //            clearInterval(saveBackPreview);
    //        }
    //    }, 1000);
    //    $('.frame-back').removeClass('transparent-border');
    //}
    //
    //function generate_frame_image() {
    //    var back = '';
    //    var front = '';
    //    var item_front = $('.frame-front .item').length;
    //    var item_back = $('.frame-back .item').length;
    //    updateDesignCount(item_front, item_back);
    //
    //    $('.item').removeClass('item-active');
    //    $('#location-front').addClass('active');
    //    $('#location-back').removeClass('active');
    //    $('.frame-front').addClass('transparent-border');
    //
    //    $(".custom-frame").css({
    //        '-ms-transform': 'scale(10)',
    //        '-webkit-transform': 'scale(10)'
    //    });
    //    var scale_width = $('.custom-frame')[0].getBoundingClientRect().width;
    //    var scale_height = $('.custom-frame')[0].getBoundingClientRect().height;
    //
    //    //$("#product-front-now").addClass('hidden');
    //
    //    $("#wait-text-title").text('กรุณารอสักครู่ กำลังบันทึกรูปภาพลาย');
    //    console.log("Frame capture");
    //    html2canvas($("#location-front"), {
    //        onrendered: function (canvas) {
    //            console.log("Frame onrender");
    //            var image_front = canvas.toDataURL("image/png");
    //
    //            $.ajax({
    //                type: "POST",
    //                url: "/design/save-preview-image",
    //                data: {
    //                    "location": 'front',
    //                    "image_data": image_front
    //                },
    //                dataType: "json",
    //                success: function (data) {
    //                    updateCampaignImage('front', data.image_url);
    //                    $("#location-front").attr('data-preview-front', data.image_url);
    //                    front_frame_completed = true;
    //                },
    //                failure: function (errMsg) {
    //                    alert(errMsg);
    //                }
    //            });
    //
    //        },
    //        width: scale_width,
    //        height: scale_height,
    //        logging: false
    //    });
    //
    //
    //    $('.frame-front').removeClass('transparent-border');
    //    $('#location-back').addClass('active');
    //    $('#location-front').removeClass('active');
    //    $('.frame-back').addClass('transparent-border');
    //    //$(".frame-front").css('zoom', '500%');
    //
    //    $("#product-back-now").addClass('hidden');
    //    html2canvas($('#location-back'), {
    //        onrendered: function (canvas) {
    //            var image_back = canvas.toDataURL("image/png");
    //            var image_url = '';
    //            if (item_back > 0) {
    //                $.ajax({
    //                    type: "POST",
    //                    url: "/design/save-preview-image",
    //                    data: {
    //                        "location": "back",
    //                        "image_data": image_back
    //                    },
    //                    dataType: "json",
    //                    success: function (data) {
    //                        image_url = data.image_url;
    //                        updateCampaignImage('back', data.image_url);
    //                        $('#location-back').attr('data-preview-back', data.image_url);
    //                        back_frame_completed = true;
    //                    },
    //                    failure: function (errMsg) {
    //                        alert(errMsg);
    //                    }
    //                });
    //            } else {
    //                updateCampaignImage('back', image_url);
    //                $('#location-back').attr('data-preview-back', image_url);
    //                back_frame_completed = true;
    //            }
    //        },
    //        width: scale_width,
    //        height: scale_height,
    //        logging: false
    //    });
    //    $('.frame-back').removeClass('transparent-border');
    //    var saveCampaignLoop = setInterval(function () {
    //        if (front_frame_completed && back_frame_completed) {
    //            //var hash_id = getHashID();
    //            //var key = hash_id[0] + '/' + hash_id[1];
    //            //window.location =  + "#!/" + key;
    //            saveCampaign();
    //            clearInterval(saveCampaignLoop);
    //        }
    //    }, 1000);
    //}

    //$('.frame').css('border-color', 'solid');


    /*
     Upload picture AJAX
     */
    loadPicture();
    $(".drop").dropper({
        action: $('.drop').data('url'),
        label: 'ลากและวางไฟล์ หรือ คลิกเพื่อเลือก'
    })
//                    .on("start.dropper", onStart)
        .on("complete.dropper", onComplete)
        .on("fileStart.dropper", onFileStart)
        .on("fileProgress.dropper", onFileProgress)
        .on("fileComplete.dropper", onFileComplete)
//                    .on("fileError.dropper", onFileError);

    function onFileStart() {
        $('.progress').addClass('show');
        $('.progress').removeClass('hide');
        $('.progress-bar').width('0%');
    }

    function onComplete() {
        loadPicture();
    }

    function onFileProgress(e, file, percent) {
        $('.progress-bar').width(percent + '%');
    }

    function onFileComplete(e, file, response) {
        $('.progress').addClass('hide');
        $('.progress').removeClass('show');
        $('.dropper-input').val('');
    }

    function loadPicture() {
        $.ajax({
            type: "GET",
            url: $(".show-picture").attr("data-url"),
            dataType: "json",
            success: function (data) {
                $('.show-picture').text('');
                if (data.length > 0) {
                    $('.show-picture').append('<div class="row-fluid remove-picture"><a onclick="javascript:void(0)" class="select-remove text-right">เลือกลบ</a></div>');
                }
                $.each(data, function (key, value) {
                    $('.show-picture').append('<div class="wrapper wrapper-picture">' +
                        '<span class="pull-right btn-remove-picture hidden glyphicon glyphicon-remove" data-index="' + key + '"  data-original="' + value['original'] + '" data-thumbnail="' + value['thumbnail'] + '"' +
                        'data-real-original="' + value['real_original'] + '" data-real-thumbnail="' + value['real_thumbnail'] + '"></span>' +
                        '<div class="btn-choose-picture" id="picture-' + value.id + '" data-original="' + value['original'] + '">' +
                        '<img class="picture" src="' + value['thumbnail'] + '"></div></div>');
                });
                $(".btn-choose-picture").click(function () {
                    var new_pic = new_picture($(this));
                    storeNewPictureItem(new_pic);
                    //cal_price();
                });
                $(".btn-remove-picture").click(function () {
                    $(this).parent(".wrapper-picture").remove();
                    $.ajax({
                        type: "POST",
                        url: "/design/delete-upload-picture",
                        data: {
                            "index": $(this).attr('data-index'),
                            "original": $(this).attr('data-real-original'),
                            "thumbnail": $(this).attr('data-real-thumbnail')
                        },
                        dataType: "json",
                        success: function (data) {
                        },
                        failure: function (errMsg) {
                            alert(errMsg);
                        }
                    });

                });
                $(".select-remove").click(function () {
                    $(".btn-remove-picture").toggleClass('hidden');
                    var path = $('.btn-remove-picture').attr('data-original');
                    $(this).html($(this).text() == 'เลือกลบ' ? 'ยกเลิก' : 'เลือกลบ');
                })
            },
            failure: function (errMsg) {
                alert(errMsg);
            }
        });
    }


    /*
     End upload picture AJAX
     */

    function getCurrentHashKey() {
        var key = getHashID();

        return "#!/" + key[0] + "/" + key[1];
    }
    function getCurrentData() {
        var hash_id = getHashID();
        var key = hash_id[0] + '/' + hash_id[1];
        return parseOut(key);
    }

    function setCurrentData(data, new_key) {
        var hash_id = getHashID();
        var key = hash_id[0] + '/' + hash_id[1];
        if(new_key) {
            var next_key = key + '/' + (parseInt(item_no) + 1);
            parseIn(next_key, campaign);
            setUrl(next_key);
        } else {
            parseIn(key, data);
        }
    }
    function getHashID() {
        var url_hash = window.location.hash;
        var key = '';
        var hash_id = new Hashids("mubaza");
        if (url_hash == "") {
            key = hash_id.encode(Date.now());
            return [key, 0];
        }
        else {
            var url_split = url_hash.split('/');
            return [url_split[1], url_split[2]];
        }
    }

    function initializeDesign(key) {
        var data = {
            campaign: {
                id: null,
                title: '',
                goal: 0,
                limit: 0,
                end_amount: '',
                description: '',
                tags: [],
                type_name: $('#campaign-type').val(),
                status_id: 1,
                user_id: '',
                base_folder: '',
                image_front: '',
                image_back: '',
                thumbnail_front: '',
                thumbnail_back: '',
                thumbnail_medium_front: '',
                thumbnail_medium_back: '',
                thumbnail_mini_front: '',
                thumbnail_mini_back: '',
                back_cover: '',
                product: [{
                    id: '',
                    name: '',
                    color_id: '',
                    color: '',
                    color_name: '',
                    image_front: '',
                    image_back: '',
                    one_side_price: 0,
                    two_side_price: 0,
                    outline: {
                        left: 0,
                        top: 0,
                        width: 0,
                        height: 0
                    }
                }],
                design: {
                    front_design: 0,
                    back_design: 0,
                    items: []
                }
            },
            products: {},
            user: {}
        };
        parseIn(key + '/0', data);
        getProductData();
        setUrl(key + '/0');
    }

    function updateDesignCount(front, back)
    {
        var hash_id = getHashID();
        var key = hash_id[0] + '/' + hash_id[1];
        var campaign = parseOut(key);
        if(front > 0)
        {
            campaign.campaign.design.front_design = 1;
        }
        if(back > 0)
        {
            campaign.campaign.design.back_design = 1;
        }

        parseIn(key, campaign);
    }

    function updateCampaignImage(location, image_url) {
        var hash_id = getHashID();
        var key = hash_id[0] + '/' + hash_id[1];
        var campaign = parseOut(key);

        if(location == "base_folder")
        {
            campaign.campaign.base_folder = image_url;
        }

        if (location == "front") {
            campaign.campaign.image_front = image_url
        }
        if (location == "back") {
            campaign.campaign.image_back = image_url
        }
        if (location == "thumbnail_mini_front") {
            campaign.campaign.thumbnail_mini_front = image_url
        }
        if (location == "thumbnail_mini_back") {
            campaign.campaign.thumbnail_mini_back = image_url
        }
        if (location == "thumbnail_medium_front") {
            campaign.campaign.thumbnail_medium_front = image_url
        }
        if (location == "thumbnail_medium_back") {
            campaign.campaign.thumbnail_medium_back = image_url
        }
        if (location == "thumbnail_front") {
            campaign.campaign.thumbnail_front = image_url
        }
        if (location == "thumbnail_back") {
            campaign.campaign.thumbnail_back = image_url
        }

        parseIn(key, campaign);
    }

    function parseOut(key) {
        return JSON.parse(localStorage.getItem(key));
    }

    function parseIn(key, data) {
        localStorage.setItem(key, JSON.stringify(data))
    }

    function updateTextItem(item_id) {
        var text_item = $(item_id);
        var no = text_item.data('no');
        var data = {
            no: text_item.data('no'),
            type: "text",
            text: $("#input-text").val(),
            color: text_item.attr('data-color'),
            align: text_item.attr('data-align'),
            location: text_item.data('location'),
            left: text_item.attr('data-posx'),
            top: text_item.attr('data-posy'),
            rotate: text_item.attr('data-rotate'),
            z_index: text_item.css('z-index'),
            font_family: text_item.attr('data-fontfamily'),
            font_size: text_item.attr('data-fontsize'),
            active: 1
        };
        var hash_data = getHashID();
        var key = hash_data[0];
        var item_no = hash_data[1];
        var campaign = parseOut(key + '/' + item_no);
        campaign.campaign.design.items[no] = data;
        var next_key = key + '/' + (parseInt(item_no) + 1);
        parseIn(next_key, campaign);
        setUrl(next_key);
        //refreshCountBlock();
    }

    function storeNewTextItem(item_id) {
        var text_item = $(item_id);
        var no = text_item.data('no');
        var data = {
            no: text_item.data('no'),
            type: "text",
            text: $("#input-text").val(), //text_item.find('.item-inner').text(),
            color: text_item.attr('data-color'),
            //color_amount: amount_color,
            align: text_item.attr('data-align'),
            price: text_item.data('price'),
            location: text_item.data('location'),
            left: text_item.attr('data-posx'),
            top: text_item.attr('data-posy'),
            rotate: text_item.attr('data-rotate'),
            z_index: parseInt(text_item.data('no') + 9),
            font_family: text_item.attr('data-fontfamily'),
            font_size: text_item.attr('data-fontsize'),
            lang: text_item.attr('data-lang'),
            active: 1
        };

        var hash_data = getHashID();
        var key = hash_data[0];
        var item_no = hash_data[1];
        var campaign = parseOut(key + '/' + item_no);
        campaign.campaign.design.items[no] = data;
        var next_key = key + '/' + (parseInt(item_no) + 1);
        parseIn(next_key, campaign);
        setUrl(next_key);
        //refreshCountBlock();
        //cal_price();
    }

    function updatePictureItem(item) {
        var picture_item = item;
        var no = picture_item.data('no');
        var data = {
            no: picture_item.data('no'),
            type: "picture",
            url: picture_item.attr('data-url'),
            location: picture_item.attr('data-location'),
            height: picture_item.attr('data-height'),
            width: picture_item.attr('data-width'),
            left: picture_item.attr('data-posx'),
            top: picture_item.attr('data-posy'),
            color: picture_item.attr('data-color'),
            rotate: picture_item.attr('data-rotate'),
            z_index: parseInt(picture_item.data('no') + 9),
            active: 1
        };

        var hash_data = getHashID();
        var key = hash_data[0];
        var item_no = hash_data[1];
        var campaign = parseOut(key + '/' + item_no);
        campaign.campaign.design.items[no] = data;
        var next_key = key + '/' + (parseInt(item_no) + 1);
        parseIn(next_key, campaign);
        setUrl(next_key);
    }

    function storeNewPictureItem(item) {
        var picture_item = item;
        var no = picture_item.attr('data-no');
        var data = {
            no: picture_item.data('no'),
            type: "picture",
            url: picture_item.attr('data-url'),
            location: picture_item.attr('data-location'),
            height: picture_item.attr('data-height'),
            width: picture_item.attr('data-width'),
            left: picture_item.attr('data-posx'),
            top: picture_item.attr('data-posy'),
            color: picture_item.attr('data-color'),
            rotate: picture_item.attr('data-rotate'),
            z_index: parseInt(picture_item.attr('data-no') + 9),
            active: 1
        };


        var hash_data = getHashID();
        var key = hash_data[0];
        var item_no = hash_data[1];
        var campaign = parseOut(key + '/' + item_no);
        campaign.campaign.design.items[no] = data;
        var next_key = key + '/' + (parseInt(item_no) + 1);
        parseIn(next_key, campaign);
        setUrl(next_key);
        //refreshCountBlock();
        //cal_price();
    }

    Array.prototype.remove = function (from, to) {
        var rest = this.slice((to || from) + 1 || this.length);
        this.length = from < 0 ? this.length + from : from;
        return this.push.apply(this, rest);
    };

    function removeItem(index) {
        var item = $(".item-active");
        var remove_index = parseInt(item.css('z-index'));
        var remove_no = parseInt(item.attr('data-no'));

        if (item.hasClass('item-text')) {
            clear_input_text();
        }

        //item.find removeItem(item);
        item.remove();
        $(".item").each(function () {
            var current_index = parseInt($(this).css('z-index'));
            var new_index = 0;
            if (current_index > remove_index) {
                new_index = current_index - 1;
                $(this).css("z-index", new_index);
            }
            var current_no = parseInt($(this).attr('data-no'));
            var new_no = 0;
            if (current_no > remove_no) {
                new_no = current_no - 1;
                $(this).attr('data-no', new_no);
            }
        });

        var hash_data = getHashID();
        var key = hash_data[0];
        var item_no = hash_data[1];
        var campaign = parseOut(key + '/' + item_no);

        var next_key = key + '/' + (parseInt(item_no) + 1);
        campaign.campaign.design.items.remove(index);

        parseIn(next_key, campaign);
        setUrl(next_key);
        //refreshCountBlock();
        //cal_price();

    }

    function setUrl(key) {
        window.location.hash = "!/" + key;
        var campaign = parseOut(key);
    }

    function loadDesign() {
        var hash_id = getHashID();
        if (hash_id[1] == 0) {
            if (JSON.stringify(localStorage).length > 1000000) {
                localStorage.clear();
                window.location.replace("sell");
            }

            initializeDesign(hash_id[0]);
            change_product(0);
        }
        else {
            loadProduct();
            var campaign = parseOut(hash_id[0] + '/' + hash_id[1]);
            /*change_product(campaign.campaign.product.id);*/
            var items = campaign.campaign.design.items;
            $.each(items, function (k, item) {
                if (item != null) {
                    if (item.active == 1) {
                        if (item.type == "text") {
                            loadTextItem(item);
                        }
                        else if (item.type == "picture") {
                            loadPictureItem(item);
                        }
                    }
                }
            });

        }
    }

    function loadTextItem(item) {
        //alert("loadTextItem:" +item.no);
        var item_data = "<div class='item item-text item-text-" + item.no + "'"
            + " style='z-index:" + item.z_index + ";"
            + " left: " + item.left + "px;"
            + " top: " + item.top + "px;"
            + " transform: " + item.rotate + ";'"
            + " data-no='" + item.no + "'"
            + " data-rotate='" + item.rotate + "'"
            + " data-location='" + item.location + "'"
            + " data-posx='" + item.left + "'"
            + " data-posy='" + item.top + "'"
            + " data-fontfamily='" + item.font_family + "'"
            + " data-color='" + item.color + "'"
                /* + " data-align='"+ item.align +"'"*/
            + " data-fontsize='" + item.font_size + "'>"
            + "<div class='item-inner text text-active'"
            + " style='font-family: " + item.font_family + ";"
            + " color:" + item.color + ";"
            + " font-size:" + item.font_size + "px;"
            + " line-height:" + item.font_size + "px;'>"
                /*+   " text-align:"+ item.align +"'>"*/
            + item.text
            + "</div>"
            + "<div class='icon icon-drag'>"
            + "</div>"
            + "<div class='icon icon-remove'>"
            + "</div>"
            + "</div>";
        if (item.location == "front") {
            $(".frame-front").append(item_data);
        } else if (item.location == "back") {
            $(".frame-back").append(item_data);
        }


        $("#input-text").removeClass('new-text');
        $("#input-text").addClass('edit-text');

        //cal_price();
        base_text();
    }

    function loadPictureItem(item) {
        var item_data = "<div class='item item-picture item-picture-" + item.no + "'"
            + " style='z-index: " + item.z_index + ";"
            + " width: " + item.width + "px;"
            + " height: " + item.height + "px;"
            + " left: " + item.left + "px;"
            + " top: " + item.top + "px;"
            + " transform: " + item.rotate + ";'"
            + " data-location='" + item.location + "'"
            + " data-url='" + item.url + "'"
            + " data-no='" + item.no + "'"
            + " data-width='" + item.width + "'"
            + " data-height='" + item.height + "'"
            + " data-posx='" + item.left + "'"
            + " data-poxy='" + item.top + "'"
            + ' data-color="' + item.color + '"'
            + " data-rotate='" + item.rotate + "'"
            + " data-z_index='" + item.z_index + "'>"
            + "<div class='item-inner'><img class='picture' src='" + item.url + "' style='height:100%;width:100%;'></div>"
            + "<div class='tool'>"
            + "<div class='icon icon-drag'>"
            + "</div>"
            + "<div class='icon icon-remove'>"
            + "</div>"
            + "</div>";
        +"</div>";
        if (item.location == "front") {
            $(".frame-front").append(item_data);
        } else if (item.location == "back") {
            $(".frame-back").append(item_data);
        }

        $(".item-active").css("z-index", item.z_index);
        base_picture();
        //cal_price();
    }

    function updateProductItem() {
        var hash_id = getHashID();
        var campaign = parseOut(hash_id[0] + '/' + hash_id[1]);
        var product = campaign.campaign.product[0]
        var product_front_now = $('#product-front-now');
        var product_back_now = $('#product-back-now');
        product.id = parseInt(product_front_now.attr('data-product-id'));

        product.name = product_front_now.attr('data-product-name');
        product.color = product_front_now.attr('data-color');
        product.color_name = product_front_now.attr('data-color-name');
        product.color_id = parseInt(product_front_now.attr('data-color-id'));
        product.one_side_price = parseInt(product_front_now.attr('data-one-side-price'));
        product.two_side_price = parseInt(product_front_now.attr('data-two-side-price'));
        product.outline.left = product_front_now.attr('data-left');
        product.outline.top = product_front_now.attr('data-top');
        product.outline.width = product_front_now.attr('data-width');
        product.outline.height = product_front_now.attr('data-height');
        product.image_front = product_front_now.attr('src');
        product.image_back = product_back_now.attr('src');
        campaign.campaign.product[0] = product;
        parseIn(hash_id[0] + '/' + hash_id[1], campaign);
    }

    function updateCampaignTitle() {
        var hash_id = getHashID();
        var key = hash_id[0] + '/' + hash_id[1];
        var campaign = parseOut(key);

        campaign.campaign.title = $("#product-front-now").data('product-name');
        parseIn(key, campaign);
    }

    /*--- End Design ---*/
});


/* Widget Clik Ouside Dialog Hide */
$.widget("ui.dialog", $.ui.dialog, {
    options: {
        clickOutside: false, // Determine if clicking outside the dialog shall close it
        clickOutsideTrigger: "" // Element (id or class) that triggers the dialog opening
    },
    open: function () {
        var clickOutsideTriggerEl = $(this.options.clickOutsideTrigger);
        var that = this;

        if (this.options.clickOutside) {
            // Add document wide click handler for the current dialog namespace
            $(document).on("click.ui.dialogClickOutside" + that.eventNamespace, function (event) {
                if ($(event.target).closest($(clickOutsideTriggerEl)).length == 0 && $(event.target).closest($(that.uiDialog)).length == 0) {
                    that.close();
                }
            });
        }

        this._super(); // Invoke parent open method
    },

    close: function () {
        var that = this;

        // Remove document wide click handler for the current dialog
        $(document).off("click.ui.dialogClickOutside" + that.eventNamespace);

        this._super(); // Invoke parent close method
    }

});


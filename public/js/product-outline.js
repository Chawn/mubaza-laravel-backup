$(document).ready(function() {
    $("#frame").draggable({
        containment: "parent" ,
        drag: function() {
            var position = $(this).position();
            var top = position.top;
            var left = position.left;
            $("#input-posx").val(left);
            $("#input-posy").val(top);
        },
        stop:function(){
            var top = $(this).css('top');
            var left = $(this).css('left');
            top = top.replace('px','') ;
            left = left.replace('px','') ;
            $(this).attr('data-posx', left);
            $(this).attr('data-posy', top);
        }
    });

    $("#frame").resizable({
        containment: "parent" ,
        resize: function() {
            var height = $(this).css('height');
            var width = $(this).css('width');
            new_height = height.replace('px','') ;
            new_width = width.replace('px','') ;
            $("#input-height").val(new_height);
            $("#input-width").val(new_width);

        },
        stop:function(){
            var height = $(this).css('height');
            var width = $(this).css('width');
            height = height.replace('px','') ;
            width = width.replace('px','') ;
            $(this).attr('data-height', height);
            $(this).attr('data-width', width);
            var top = $(this).css('top');
            var left = $(this).css('left');
            top = top.replace('px','') ;
            left = left.replace('px','') ;
            $(this).attr('data-posx', left);
            $(this).attr('data-posy', top);
        }
    });

    $("#btn-save").click(function () {
        $.ajax({
            type: "POST",
            url: $('#frame').attr('data-save-link'),
            data: {
                "product_id": $("#frame").attr("data-id"),
                "_token": $("#frame").attr("data-token"),
                "outline_height": $("#frame").attr("data-height"),
                "outline_width": $("#frame").attr("data-width"),
                "outline_left": $("#frame").attr("data-posx"),
                "outline_top": $("#frame").attr("data-posy")
            },
            dataType: "json",
            success: function (data) {
                if (data.result == 'success') {
                    alert('บันทึกพื้นที่การออกแบบเรียบร้อยแล้ว');
                    window.location = data.url;
                }
                else {

                }
            },
            failure: function (errMsg) {
                alert(errMsg);
            }
        })
    });

    $(".move-center").click(function () {
        var custom_frame_width = $(".custom-frame").width();
        var frame_width = $("#frame").width();
        var left_center = ((custom_frame_width - frame_width) / 2) - 1;
        $("#frame").attr('data-posx',left_center);
        $("#frame").css({
            'left': left_center + "px"
        });
    })

});
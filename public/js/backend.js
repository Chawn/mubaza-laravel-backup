/**
 * Created by Akaradech on 21/2/2558.
 */
$(document).ready(function () {
    $("#input-posx").change(function () {
        $("#frame").css({left: $(this).val() + "px"});
    });
    $("#input-posy").change(function () {
        $("#frame").css({top: $(this).val() + "px"});
    });

    $("#input-height").change(function () {
        $("#frame").css({height: $(this).val() + "px"});
    });
    $("#input-width").change(function () {
        $("#frame").css({width: $(this).val() + "px"});
    });

    //CKEDITOR.replace( 'ckeditor' );

    //$("#datepicker-th2").datepicker({
    //    dateFormat: 'yy-mm-dd', isBuddhist: true, dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
    //    dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
    //    monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
    //    monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']
    //});
    //
    //$("#datepicker-th2").datepicker({ changeMonth: true, changeYear: true,dateFormat: 'dd/mm/yy', isBuddhist: true,dayNames: ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
    //    dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
    //    monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
    //    monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']
    //});
    //$("#datepicker-en").datepicker({
    //    dateFormat: 'yy-mm-dd'
    //});
    //$("#inline").datepicker({
    //    dateFormat: 'yy-mm-dd', inline: true
    //});

    $('#add-shirt-color').click(function () {
        var item_length = ($('input.img_front').length + 1);

        $('#color-table tr:last').after('<tr><td><input name="new_color_id[]" value="new-' + item_length + '" type="hidden"/>' +
        '<input type="color" name="color[]" class="color" value="#999888"></td>' +
            '<td><input type="text" name="color_name[]" class="form-control" /></td>' +
        '<td><input type="file" multiple name="img_front[]" class="img_front"></td>' +
        '<td><input type="file" multiple name="img_back[]" class="img_back"></td>' +
        '<td><label><input type="radio" name="set_cover" value="new-' + item_length + '" > ตั้งเป็นรูปหน้าปก</label></td></tr>');
    });
    $('#add-shirt-color-edit').click(function () {
        var item_id = 'new-' + ($('input.new').length + 1);

        $('#color-table tr:last').after('<tr><td>&nbsp;</td><td><input name="image_id[]" value="' + item_id + '" type="hidden" class="new" />' +
        '<input type="hidden" name=is_old[' + item_id + '] value="false" />' +
        '<input type="color" name="color[' + item_id + ']" class="color" value="#000000"></td>' +
        '<td><input type="text" name="color_name[' + item_id + ']" class="color_name" value=""></td>' +
        '<td><input type="file" multiple name="img_front[' + item_id + ']" class="img_front"></td>' +
        '<td><input type="file" multiple name="img_back[' + item_id + ']" class="img_back"></td>' +
        '<td><label><input type="radio" name="set_cover" value="' + item_id + '" > ตั้งเป็นรูปหน้าปก</label></td></tr>');
    });
    $('#add-skin-color-input').click(function () {
        $('.skin-table tr:last').after('<tr><td><input name="new_color_id[]" value="new-' + ($('input.skin_picture').length + 1) + '" type="hidden"/><input type="color" name="color[]" id="color' +
        ($('input[name^="color"]').length + 1) +
        '" value="#000"></td><td><input type="file" multiple="multiple" name="skin_picture[]" class="skin_picture"></td><td><label><input type="radio" name="set_cover" value="new-' + ($('input.skin_picture').length + 1) + '" > ตั้งเป็นรูปหน้าปก</label></td></tr>');
    });

    $('#add-skin-color-edit').click(function () {
        $('.skin-table tr:last').after('<tr><td>&nbsp;<input name="new_color_id[]" value="new-' + ($('input.new_skin').length + 1) + '" type="hidden"/></td><td><input type="color" name="new_color[]" id="new-color' +
        ($('input[name^="new-color"]').length + 1) +
        '" value="#000"></td><td><input type="file" multiple="multiple" name="new_skin[]" class="new_skin"></td><td><label><input type="radio" name="set_cover" value="new-' + ($('input.skin_picture').length + 1) + '"  > ตั้งเป็นรูปหน้าปก</label></td></tr>');
    });
    //CKEDITOR.replace( 'full-detail' );
	
	//tooltip
	$(function () {
  		$('[data-toggle="tooltip"]').tooltip()
	})
	
	// table row color 
	//$(function() {
     //   $("table tr:nth-child(odd)").addClass("odd-row");
	//});
	// click row link
	$(function() {
		$(".clickable-row").click(function() {
			window.document.location = $(this).data("href");
		});
	});
});



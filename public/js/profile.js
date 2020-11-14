/**
 * Created by execter on 6/11/15 AD.
 */
var save_profile = function(data) {
    var keys = data.split(',');
    var values = [];
    $.each(keys, function (k, v) {
        var item = v.split('|');
        if (item[2] === "text" || item[2] === 'date' || item[2] === 'url') {
            values.push({table:item[0], column:item[1], data:$('#' + item[1]).val(), type:item[2]});
        } else if (item[2] === "checkbox") {
            if ($('#' + item[1]).is(":checked")) {
                values.push({table:item[0], column:item[1], data:1, type:item[2]});
            } else {
                values.push({table:item[0], column:item[1], data:0, type:item[2]});
            }
        } else if (item[2] === "radio") {
            values.push({table:item[0], column:item[1], data:$('input[name=' + item[1] + ']:checked').val(), type:item[2]});
        }
    });
    $.ajax({
        type: "POST",
        url: '/user/save-data',
        data: {
            _token: $('#token').val(),
            user_id: $('#user-id').val(),
            data: values
        },
        dataType: "json",
        success: function (data) {
            if(data.error) {
                alert(data.message);
            } else {
                if(data.url == null)
                {
                    document.location.reload();
                }
                else
                {
                    document.location = data.url;
                }
            }
        },
        failure: function (errMsg) {
            alert(errMsg);
        }
    });
};
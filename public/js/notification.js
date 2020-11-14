$(document).ready(function() {
    $("#btn-notification").on("click", function() {
        setReadNotification();
    });

    function setReadNotification() {
        $.ajax({
            type: "GET",
            url: "/set-read-notification",
            dataType: "json",
            success: function (data) {
                if (!data.success) {
                    console.log(data.message);
                }
            },
            failure: function (errMsg) {
                alert(errMsg);
            }
        });
    }
});
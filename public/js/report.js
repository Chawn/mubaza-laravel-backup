$(document).ready(function() {
   $('#send-report-button').click(function() {
       $.ajax({
           type: "POST",
           url: $(this).data('url'),
           data: {
               "_token": $(this).data("token"),
               "report_type_name": $('input[name=report_type_name]:checked').val(),
               "detail": $('#detail').val(),
               "user_id": $(this).data('user-id')
           },
           dataType: "json",
           success: function (data) {
               if (!data.error) {
                   $('#modal-report').modal('hide');
                   $('input[value=abuse]').prop('checked', true);
                   $('#detail').val('');
               }
           },
           failure: function (errMsg) {
               alert(errMsg);
           }
       });
   }) ;
   $('#send-campaign-report').click(function() {
       $.ajax({
           type: "POST",
           url: $(this).data('url'),
           data: {
               "_token": $(this).data("token"),
               "report_type_name": $('select[name=report_type_name]').val(),
               "detail": $('#detail').val(),
               "campaign_id": $(this).data('campaign-id')
           },
           dataType: "json",
           success: function (data) {
               if (!data.error) {
                   $('#modal-campaign-report').modal('hide');
                   $('#detail').val('');
               }
           },
           failure: function (errMsg) {
               alert(errMsg);
           }
       });
   }) ;
});
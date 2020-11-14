(function ($) {
  $.extend({
    uploadPreview : function (options) {

      // Options + Defaults
      var settings = $.extend({
        input_field: ".image-input",
        preview_box: ".image-preview",
        label_field: ".image-label",
        label_default: "อัพโหลดรูปภาพ",
        label_selected: "เปลี่ยนรูปภาพ",
        no_label: false
      }, options);

      // Check if FileReader is available
      if (window.File && window.FileList && window.FileReader) {
        if (typeof($(settings.input_field)) !== 'undefined' && $(settings.input_field) !== null) {
          $(settings.input_field).change(function() {
            var files = event.target.files;

            if (files.length > 0) {
              var file = files[0];
              var reader = new FileReader();

              // Load file
              reader.addEventListener("load",function(event) {
                var loadedFile = event.target;

                // Check format
                if (file.type.match('image')) {
                  // Image
                  

                  var imgCoverHeight = $('.campaign-cover img').height();
                  var imgCoverWidth = $('.campaign-cover img').width();
                  if (imgCoverHeight < 350 || imgCoverWidth < 1000) {
                    alert("กรุณาเลือกรูปที่มีความกว้างมากกว่า 800 พิกเซลและความสูงมากกว่า 350 พิกเซล");
                  }else{
                    $(settings.preview_box_img).attr("src", ""+loadedFile.result+"");
                    $(settings.preview_box).css("background-image", "url("+loadedFile.result+")");

                    if (imgCoverHeight < 460){
                        $(this).css({
                          'height' : '100' + '%',
                          'position' : 'absolute',
                          'top' : '0',
                          'left' : '0',
                          'right' : '0',
                          'bottom' : '0'
                        });
                    }else if (imgCoverHeight > imgCoverWidth){
                      $(this).css({
                        'width' : '100' + '%',
                        'position' : 'absolute',
                        'top' : '0',
                        'left' : '0',
                        'right' : '0',
                        'bottom' : '0'
                      });

                    } else {
                      $(this).css({
                        'width' : '100' + '%',
                      });
                    }
                  }
                    
                } else if (file.type.match('audio')) {
                  // Audio
                  $(settings.preview_box).html("<audio controls><source src='" + loadedFile.result + "' type='" + file.type + "' />Your browser does not support the audio element.</audio>");
                } else {
                  alert("This file type is not supported yet.");
                }
              });

              if (settings.no_label == false) {
                // Change label
                $(settings.label_field).html(settings.label_selected);
                $('.group-btn-control').show();
              }

              $('.cover-tools-close').click(function() {
                $(settings.label_field).html(settings.label_default);
              });
              // Read the file
              reader.readAsDataURL(file);
            } else {
              if (settings.no_label == false) {
                // Change label
                $(settings.label_field).html(settings.label_default);
              }

              // Clear background
              $(settings.preview_box).css("background-image", "none");

              // Remove Audio
              $(settings.preview_box + " audio").remove();
            }
          });
        }
      } else {
        alert("You need a browser with file reader support, to use this form properly.");
        return false;
      }
    }
  });
})(jQuery);
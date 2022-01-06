jQuery(document).ready(function ($) {
 
    $(document).on("click", ".upload_image_button", function (e) {
       e.preventDefault();
       var $button = $(this);
  
       // Create the media frame.
       var file_frame = wp.media.frames.file_frame = wp.media({
          title: 'Select or upload file',
          library: { // remove these to show all
             type: 'application/pdf' // specific mime
          },
          button: {
             text: 'Select'
          },
          multiple: false  // Set to true to allow multiple files to be selected
       });
  
       // When an image is selected, run a callback.
       file_frame.on('select', function () {
          // We set multiple to false so only get one image from the uploader
  
          var attachment = file_frame.state().get('selection').first().toJSON();
  
          $button.siblings('input').val(attachment.url);
         //  var save_Button = document.getElementById("widget-downloader_widget-2-savewidget");
         //  save_Button.disabled = false;
         //  save_Button.value = "Save";

       });
  
       // Finally, open the modal
       file_frame.open();
    });
 });
jQuery(document).ready(function($){

  var mediaUploader;
  var target_input;

  $('.upload-button').click(function(e) {
    target_input = $(this).prev().attr('id');
    e.preventDefault();
    // If the uploader object has already been created, reopen the dialog
      if (mediaUploader) {
      mediaUploader.open();
      return;
    }
    // Extend the wp.media object
    mediaUploader = wp.media.frames.file_frame = wp.media({
      title: 'Chercher une image',
      button: {
      text: 'Chercher une image'
    }, multiple: false });

    // When a file is selected, grab the URL and set it as the text field's value
    mediaUploader.on('select', function() {
      attachment = mediaUploader.state().get('selection').first().toJSON();
      $('#'+ target_input).val(attachment.url);
    });
    // Open the uploader dialog
    mediaUploader.open();
  });

});

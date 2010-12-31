jQuery(function($) {
    var MessageEl = $("#J_Message");
        MessageEl.hide(), timer = null;

    MessageEl.click(function(e) {
        $(this).hide();
    });

    function showMessage(message, timeout) {
        MessageEl.html(message).fadeIn();
        clearTimeout(timer);
        timer = setTimeout(function() {
            MessageEl.fadeOut();
        }, timeout || 1500);
    };
            
    var Uploader = new qq.FileUploader({
        debug: false,
        action: './compiler/',
        fileParam: 'upload_file',
        element: document.getElementById('uploader'),
        onSubmit: function(id, fileName){
            MessageEl.html("<em></em>Uploading<br />&lt;"+ fileName +"&gt;").fadeIn();
        },
        sizeLimit: 10000 * 100, // 1mb
        onComplete: function(id, fileName, responseJSON){
            MessageEl.hide();
            if (responseJSON.success) {
                var original_size = Math.round(responseJSON.original_size/1000),
                    minized_size  = Math.round(responseJSON.minized_size/1000),
                    saved_size    = Math.round(original_size - minized_size);

                    showMessage("Compiled Success<br />&lt;"+ fileName +"&gt;<br/>"+
                            "<br />saved "+ saved_size +"kb", 5000);

                setTimeout(function() {
                    location.href = responseJSON.url;
                }, 500);
            } else {
                responseJSON.message && showMessage(responseJSON.message, 5000);
            }
        },
        allowedExtensions: ['js', 'css'],
        showMessage: showMessage,
        messages: {
            typeError: "Only aollowed to upload {extensions} file.",
            sizeError: "The {file} is too large.",
           emptyError: "The {file} is empty.",
              onLeave: "The files are being uploaded, if you leave now the upload will be cancelled."
        }
    });
});

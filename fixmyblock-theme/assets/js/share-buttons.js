function fallbackCopyTextToClipboard(text) {
    var success = false;
    var textArea = document.createElement("textarea");
    textArea.value = text;

    // Avoid scrolling to bottom
    textArea.style.top = "0";
    textArea.style.left = "0";
    textArea.style.position = "fixed";

    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();

    try {
        var success = document.execCommand('copy');
    } catch (err) { }

    document.body.removeChild(textArea);

    return success;
}

function copyTextToClipboard(text) {
    var dfd = jQuery.Deferred();

    if ( navigator.clipboard ) {
        navigator.clipboard.writeText(text).then(function() {
            dfd.resolve();
        }, function(err) {
            dfd.reject();
        });
    } else {
        var success = fallbackCopyTextToClipboard(text);
        if ( success ) {
            dfd.resolve();
        } else {
            dfd.reject();
        }
    }

    return dfd.promise();
}

jQuery(function($){
    $('.btn-copylink').on('click', function(e){
        e.preventDefault();
        var $btn = $(this);
        copyTextToClipboard( $btn.attr('href') ).done(function(){
            var originalText = $btn.html();
            $btn.html('Copied!');
            setTimeout(function(){
                $btn.html(originalText);
            }, 4000);
        });
    });
});

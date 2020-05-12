jQuery(function($){
    var backgroundColorInput = document.getElementsByName('carbon_fields_compact_input[_background_color]')[0];
    var textColorInput = document.getElementsByName('carbon_fields_compact_input[_text_color]')[0];

    var updateUI = function() {
        var backgroundHex = $(backgroundColorInput).val();
        var textHex = $(textColorInput).val();
        var $layout = $('.editor-block-list__layout');

        $layout.css( 'backgroundColor', formatHexAsRgba(backgroundHex) );
        $layout.css( 'color', formatHexAsRgba(textHex) );
    };

    var observerConfig = { attributes: true };
    var valueObserver = new MutationObserver(updateUI);

    valueObserver.observe( backgroundColorInput, observerConfig );
    valueObserver.observe( textColorInput, observerConfig );

    var check = setInterval(function(){
        var $layout = $('.editor-block-list__layout');
        if ( $layout.length ){
            $layout.addClass('site-banner');
            updateUI();
            clearInterval(check);
        }
    }, 500);
});

function formatHexAsRgba(hex) {
    if ( hex.length === 3 ) {
        hex = '' + hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2] + 'ff';
    } else if ( hex.length === 4 ) {
        hex = '' + hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2] + hex[3] + hex[3];
    } else if ( hex.length === 6 ) {
        hex = '' + hex + 'ff';
    }
    var groups = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    if ( groups ) {
        var c = {
            r: parseInt(groups[1], 16),
            g: parseInt(groups[2], 16),
            b: parseInt(groups[3], 16),
            a: parseInt(groups[4], 16) / 255
        }
        return 'rgba(' + c['r'] + ', ' + c['g'] + ', ' + c['b'] + ', ' + c['a'] + ')';
    }
}

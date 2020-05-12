var dismissBanner = function( $el ){
    var t = new Date(); t.setFullYear(t.getFullYear() + 1);
    var id = $el.attr('data-dismissable-id');
    document.cookie = '__dismissed-' + id + '=1; path=/; expires=' + t.toUTCString();
    $el.remove();
};

jQuery(function($){
    $(document).on('click', '[data-dismiss="banner"]', function(e){
        e.preventDefault();
        var $banner = $(this).closest('[data-dismissable-id]');
        dismissBanner( $banner );
    });
});

<?php

# https://wordpress.org/support/topic/45-causes-infinite-redirect-on-static-front-page/
function disable_front_page_redirect_madness($redirect_url) {
    if( is_front_page() ) {
        $redirect_url = false;
    }
    return $redirect_url;
}
add_filter( 'redirect_canonical', 'disable_front_page_redirect_madness' );

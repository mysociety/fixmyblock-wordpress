<?php

function get_sidebar_id_for_page() {
    if ( is_front_page() ) {
        return 'frontpage-sidebar';
    } elseif ( is_home() ) {
        return 'blog-sidebar';
    } elseif ( is_single() ) {
        return 'post-sidebar';
    } elseif ( is_page() ) {
        return 'page-sidebar';
    } elseif ( is_search() ) {
        return 'search-sidebar';
    } else {
        return 'generic-sidebar';
    }
}


function the_sidebar() {
    if ( is_active_sidebar( get_sidebar_id_for_page() ) ) {
        echo '<aside class="sidebar">' . "\n";
        dynamic_sidebar( get_sidebar_id_for_page() );
        echo '</aside>' . "\n";
    }
}

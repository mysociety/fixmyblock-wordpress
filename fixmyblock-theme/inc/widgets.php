<?php

function register_widgets() {
    $defaults = array(
        'before_widget' => '<div class="sidebar-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="sidebar-widget__title">',
        'after_title' => '</h2>',
    );

    register_sidebar( wp_parse_args( array(
        'name' => 'Front page sidebar',
        'id' => 'frontpage-sidebar',
        'description' => 'Shown on the front page.',
    ), $defaults ) );

    register_sidebar( wp_parse_args( array(
        'name' => 'Blog sidebar',
        'id' => 'blog-sidebar',
        'description' => 'Shown on the main blog page.',
    ), $defaults ) );

    register_sidebar( wp_parse_args( array(
        'name' => 'Blog post sidebar',
        'id' => 'post-sidebar',
        'description' => 'Shown beside blog posts.',
    ), $defaults ) );

    register_sidebar( wp_parse_args( array(
        'name' => 'Page sidebar',
        'id' => 'page-sidebar',
        'description' => 'Shown beside non-blog pages.',
    ), $defaults ) );

    register_sidebar( wp_parse_args( array(
        'name' => 'Search page sidebar',
        'id' => 'search-sidebar',
        'description' => 'Shown on the search results page.',
    ), $defaults ) );

    register_sidebar( wp_parse_args( array(
        'name' => 'Generic sidebar',
        'id' => 'generic-sidebar',
        'description' => 'Shown when no other, more specific, sidebar is suitable.',
    ), $defaults ) );
}
add_action( 'widgets_init', 'register_widgets' );


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

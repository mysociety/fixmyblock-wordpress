<?php

// Helper functions for dealing with "show on front:" options.
// Literally cannot believe Wordpress doesn’t include these functions.
function get_posts_page_url() {
    if( 'page' == get_option('show_on_front', false) ) {
        return get_permalink( get_option('page_for_posts') );
    } else {
        return home_url();
    }
}

function get_posts_page_path() {
    if( 'page' == get_option('show_on_front', false) ) {
        $p = get_post(get_option('page_for_posts'));
        return '/' . $p->post_name;
    } else {
        return '/';
    }
}

function get_posts_page_title() {
    $posts_page_id_or_false = get_option('page_for_posts', false);
    if( $posts_page_id_or_false ) {
        return get_the_title( $posts_page_id_or_false );
    } else {
        return 'Blog';
    }
}


function start_site_content() {
    echo '<div class="site-content">' . "\n";
    echo '<div class="container">' . "\n";
}

function end_site_content() {
    echo '</div>' . "\n";
    echo '</div>' . "\n";
}


function the_page_title_and_description() {
    $queried_object = get_queried_object();

    // Work out what page title to display, in roughly the same way
    // that wp_get_document_title() does it, so the in-page title
    // roughly matches the <title> in the <head>.
    if ( is_404() ) {
        $title = __( 'Page not found' );

    } elseif ( is_front_page() ) {
        $title = get_bloginfo( 'name', 'display' );

    } elseif ( is_post_type_archive() ) {
        $title = post_type_archive_title( '', false );

    } elseif ( is_tax() || is_category() || is_tag() ) {
        $title = ucfirst( single_term_title( '', false ) );

    } elseif ( is_home() || is_singular() ) {
        $title = single_post_title( '', false );

    } elseif ( is_author() && $queried_object ) {
        $title = $queried_object->display_name;

    } elseif ( is_year() ) {
        $title = get_the_date( _x( 'Y', 'yearly archives date format' ) );

    } elseif ( is_month() ) {
        $title = get_the_date( _x( 'F Y', 'monthly archives date format' ) );

    } elseif ( is_day() ) {
        $title = get_the_date();

    } elseif ( is_search() ) {
        $title = sprintf( __( 'Search Results for &#8220;%s&#8221;' ), get_search_query() );
    }

    echo sprintf(
        '<h1>%s</h1>',
        $title
    );

    $description = get_the_archive_description();

    if ( $description ) {
        echo sprintf(
            '<p>%s</p>',
            $description
        );
    }
}


function the_feature_section() {
    $html = '';

    $feature_html = get_the_post_thumbnail( null, get_layout_meta( 'thumbnail_size' ) );
    if ( $feature_html ) {
        $html .= get_layout_meta( 'thumbnail_before' );
        $html .= $feature_html;
        $html .= get_layout_meta( 'thumbnail_after' );
    }

    echo $html;
}


// Record the current template name when including a template.
// (Handy for debugging which templates are being rendered!)
function record_current_template( $template ) {
    $GLOBALS['current_theme_template'] = basename($template);
    return $template;
}
add_action('template_include', 'record_current_template', 1000);


// Make the requested URL available to the templates, without
// having to mess around with $wp or $SERVER['REQUEST_URI'].
function record_request_url( $template ) {
    global $wp;
    $GLOBALS['current_request_url'] = home_url( add_query_arg( array(), $wp->request ) );
    return $template;
}
add_action('template_include', 'record_request_url', 1000);
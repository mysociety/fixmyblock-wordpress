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


function the_page_title_and_description() {
    // The title as displayed at the start of the page <title>.
    // Use slashes as the separator, so that dates look sensible.
    $title = wp_title( '/', false );

    // Strip whitespace, then remove the leading slash, then
    // strip whitespace again.
    $title = trim( $title );
    if ( substr($title, 0, 1) == '/' ) {
        $title = substr( $title, 1 );
    }
    $title = trim( $title );

    // Tags and categories might be all lowercase, but that looks silly
    // in a page heading. So uppercase the first letter.
    $title = ucfirst( $title );

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
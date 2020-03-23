<?php

// Remove some default gubbins from wp_head.
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rest_output_link_wp_head' );
remove_action( 'wp_head', 'wp_generator' );


// Prevent a load of emoji gunk being inserted into wp_head.
function disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}
add_action( 'init', 'disable_emojis' );


// Prevent Wordpress from wrapping shortcodes in paragraph tags.
remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'wpautop' , 99 );
add_filter( 'the_content', 'shortcode_unautop', 100 );


// Enable tags, categories, and custom excerpt text box for Pages.
function enable_full_meta_for_pages() {
    add_post_type_support( 'page', 'excerpt' );
    register_taxonomy_for_object_type( 'post_tag', 'page' );
    register_taxonomy_for_object_type( 'category', 'page' );
}
add_action( 'init', 'enable_full_meta_for_pages' );


// Display pages (as well as posts) on category and tag archive pages.
function modify_post_types_shown_on_taxonomy_archive_pages( $query ) {
    if ( $query->is_main_query() )  {
        if ( $query->is_category() || $query->is_tag() ) {
            $query->set( 'post_type',
                array(
                    'post',
                    'page'
                )
            );
        }
    }
    return $query;
}
add_filter( 'pre_get_posts', 'modify_post_types_shown_on_taxonomy_archive_pages' );

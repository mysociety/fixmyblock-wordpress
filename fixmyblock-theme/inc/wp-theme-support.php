<?php

// https://codex.wordpress.org/Automatic_Feed_Links
add_theme_support( 'automatic-feed-links' );


// https://codex.wordpress.org/Title_Tag
add_theme_support( 'title-tag' );


// https://developer.wordpress.org/reference/functions/add_theme_support/#html5
// We also include 'script' and 'style' here, so that WordPress 5.3+ uses
// the HTML5-style tags without `type` attributes.
add_theme_support( 'html5', array(
    'comment-list',
    'comment-form',
    'search-form',
    'gallery',
    'caption',
    'script',
    'style',
) );


// https://developer.wordpress.org/reference/functions/add_theme_support/#post-thumbnails
add_theme_support( 'post-thumbnails' );


// https://developer.wordpress.org/reference/functions/add_theme_support/#customize-selective-refresh-widgets
add_theme_support( 'customize-selective-refresh-widgets' );


// https://developer.wordpress.org/block-editor/developers/themes/theme-support/#wide-alignment
add_theme_support( 'align-wide' );


// https://developer.wordpress.org/block-editor/developers/themes/theme-support/#editor-styles
add_theme_support('editor-styles');


https://developer.wordpress.org/block-editor/developers/themes/theme-support/#default-block-styles
add_theme_support( 'wp-block-styles' );


// https://developer.wordpress.org/block-editor/developers/themes/theme-support/#responsive-embedded-content
add_theme_support( 'responsive-embeds' );


// https://developer.wordpress.org/themes/functionality/custom-logo/
add_theme_support( 'custom-logo' );

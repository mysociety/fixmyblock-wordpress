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


// https://developer.wordpress.org/block-editor/developers/themes/theme-support/#block-color-palettes
add_theme_support( 'editor-color-palette', array(
    // Arranged with gold at the start of the colour wheel,
    // since that’s the primary site colour.
    array(
        'name' => 'Gold',
        'slug' => 'gold',
        'color' => '#ffc80a',
    ),
    array(
        'name' => 'Yellow',
        'slug' => 'yellow',
        'color' => '#ffe000',
    ),
    array(
        'name' => 'Orange',
        'slug' => 'orange',
        'color' => '#FD9B14',
    ),
    array(
        'name' => 'Red',
        'slug' => 'red',
        'color' => '#F50400',
    ),
    array(
        'name' => 'Pink',
        'slug' => 'pink',
        'color' => '#F6449C',
    ),
    array(
        'name' => 'Blue',
        'slug' => 'blue',
        'color' => '#006FD6',
    ),
    array(
        'name' => 'Cyan',
        'slug' => 'cyan',
        'color' => '#00B7EB',
    ),
    array(
        'name' => 'Teal',
        'slug' => 'teal',
        'color' => '#00CECB',
    ),
    array(
        'name' => 'Green',
        'slug' => 'green',
        'color' => '#0EB43A',
    ),
    array(
        'name' => 'White',
        'slug' => 'white',
        'color' => '#fff',
    ),
    array(
        'name' => 'Very light gray',
        'slug' => 'gray-100',
        'color' => '#F8F9FA',
    ),
    array(
        'name' => 'Mid gray',
        'slug' => 'gray-600',
        'color' => '#718590',
    ),
    array(
        'name' => 'Black',
        'slug' => 'black',
        'color' => '#212529',
    ),
    array(
        'name' => 'Pale gold',
        'slug' => 'gold-100',
        'color' => '#FFF6D9',
    ),
    array(
        'name' => 'Pale yellow',
        'slug' => 'yellow-100',
        'color' => '#FFFBD7',
    ),
    array(
        'name' => 'Pale orange',
        'slug' => 'orange-100',
        'color' => '#FFF3E1',
    ),
    array(
        'name' => 'Pale red',
        'slug' => 'red-100',
        'color' => '#FFE6E6',
    ),
    array(
        'name' => 'Pale pink',
        'slug' => 'pink-100',
        'color' => '#FFEEF7',
    ),
    array(
        'name' => 'Pale cyan',
        'slug' => 'cyan-100',
        'color' => '#DDF6FD',
    ),
    array(
        'name' => 'Pale blue',
        'slug' => 'blue-100',
        'color' => '#EBF5FF',
    ),
    array(
        'name' => 'Pale teal',
        'slug' => 'teal-100',
        'color' => '#DCF9F9',
    ),
    array(
        'name' => 'Pale green',
        'slug' => 'green-100',
        'color' => '#E4FEEB',
    ),
) );

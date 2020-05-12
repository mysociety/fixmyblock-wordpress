<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

$colors = array(
    '#f78da7ff', // Pale pink
    '#cf2e2eff', // Vivid red
    '#ff6900ff', // Luminous vivid orange
    '#fcb900ff', // Luminous vivid amber
    '#ffe000ff', // FixMyBlock yellow
    '#fffbd7ff', // FixMyBlock pale yellow
    '#7bdcb5ff', // Light green cyan
    '#00d084ff', // Vivid green cyan
    '#8ed1fcff', // Pale cyan blue
    '#0693e3ff', // Vivid cyan blue
    '#9b51e0ff', // Vivid purple
    '#eeeeeeff', // Very light grey
    '#abb8c3ff', // Cyan bluish grey
    '#212529ff', // Bootstrap black
);

function enqueue_banner_frontend_script() {
    wp_enqueue_script(
        'dismiss-banner',
        get_theme_file_uri('/assets/js/banner-frontend.js'),
        array('jquery'),
        null
    );
}
add_action( 'wp_enqueue_scripts', 'enqueue_banner_frontend_script' );

function enqueue_banner_admin_script( $hook_suffix ) {
    $screen = get_current_screen();
    if ( $screen->post_type == 'banner' && $hook_suffix == 'post.php' ) {
        wp_enqueue_script(
            'dismiss-banner',
            get_theme_file_uri('/assets/js/banner-admin.js'),
            array('jquery'),
            null
        );
    }
}
add_action( 'admin_enqueue_scripts', 'enqueue_banner_admin_script' );

Container::make(
    'post_meta',
    'Banner options'
)->where(
    'post_type', '=', 'banner'
)->add_fields(
    array(
        Field::make(
            'color',
            'background_color',
            'Background color'
        )->set_palette(
            $colors
        )->set_alpha_enabled(
            true
        )->set_default_value(
            $colors[4] // FixMyBlock yellow
        ),
        Field::make(
            'color',
            'text_color',
            'Text color'
        )->set_palette(
            $colors
        )->set_alpha_enabled(
            true
        )->set_default_value(
            $colors[13] // Bootstrap black
        ),
        Field::make(
            'checkbox',
            'dismissable',
            'Allow visitors to hide banner'
        ),
        Field::make(
            'checkbox',
            'sticky',
            'Fix to top of screen as visitor scrolls down'
        ),
    )
);

function display_banners() {
    $posts = get_posts( array(
        'post_type' => 'banner',
        'post_status' => 'publish',
        'numberposts' => -1,
        'order'    => 'ASC',
        'orderby' => 'menu_order'
    ) );

    if ( $posts ) {
        foreach ( $posts as $p ) {
            global $post;
            $post = $p;
            setup_postdata( $post );

            $banner_id = 'banner-' . $post->ID;

            if ( isset( $_COOKIE['__dismissed-' . $banner_id] ) ) {
                // User has previously dismissed this banner.
                continue;
            }

            $classes = array();
            $classes[] = 'site-banner';
            if ( carbon_get_the_post_meta( 'sticky' ) ) {
                $classes[] = 'site-banner--sticky';
            }

            echo sprintf(
                '<div class="%s" %s data-dismissable-id="%s" style="color: %s; background: %s">',
                esc_attr( implode(' ', $classes) ),
                carbon_get_the_post_meta( 'dismissable' ) ? 'role="alert"' : '',
                esc_attr( $banner_id ),
                esc_attr( format_hex_as_rgba( carbon_get_the_post_meta( 'text_color' ) ) ),
                esc_attr( format_hex_as_rgba( carbon_get_the_post_meta( 'background_color' ) ) )
            );
            echo '<div class="container">';

            if ( carbon_get_the_post_meta( 'dismissable' ) ) {
                echo '<button type="button" class="close" data-dismiss="banner" aria-label="Close">';
                echo '<span aria-hidden="true">&times;</span>';
                echo '</button>';
            }

            the_content();

            echo '</div>';
            echo '</div>';
        }

        wp_reset_postdata();
    }
}

function format_hex_as_rgba( $hex ) {
    $r = carbon_hex_to_rgba( $hex );
    return sprintf(
        'rgba(%s, %s, %s, %s)',
        $r['red'],
        $r['green'],
        $r['blue'],
        $r['alpha']
    );
}


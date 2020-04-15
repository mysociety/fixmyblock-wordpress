<?php

function get_navbar_brand() {
    $html = '';
    $custom_logo_id = get_theme_mod( 'custom_logo' );

    if ( $custom_logo_id ) {
        $custom_logo_attr = array(
            'class' => 'custom-logo',
        );

        // If the logo alt attribute is empty, get the site title and explicitly
        // pass it to the attributes used by wp_get_attachment_image().
        $image_alt = get_post_meta( $custom_logo_id, '_wp_attachment_image_alt', true );
        if ( empty( $image_alt ) ) {
            $custom_logo_attr['alt'] = get_bloginfo( 'name', 'display' );
        }

        // If the alt attribute is not empty, there's no need to explicitly pass
        // it because wp_get_attachment_image() already adds the alt attribute.
        $html = sprintf(
            '<a href="%1$s" class="navbar-brand custom-logo-link" rel="home">%2$s</a>',
            esc_url( home_url( '/' ) ),
            wp_get_attachment_image( $custom_logo_id, 'full', false, $custom_logo_attr )
        );

    } else {
        $html = sprintf(
            '<a href="%1$s" class="navbar-brand" rel="home">%2$s</a>',
            esc_url( home_url( '/' ) ),
            get_bloginfo( 'name', 'display' )
        );
    }

    return $html;
}

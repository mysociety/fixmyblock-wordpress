<?php

function register_custom_image_sizes() {
    set_post_thumbnail_size( 360, 360, true );               // 1:1
    add_image_size( 'feature-narrow', 640, 360, true );      // 16:9
    add_image_size( 'feature-wide', 1110, 370, true );       // 3:1
    add_image_size( 'feature-full-width', 1400, 350, true ); // 4:1
}
add_action( 'after_setup_theme', 'register_custom_image_sizes' );

<?php

// wp-compat.php
// Monkeypatches for compatibility with WordPress versions back to 4.7.0.

// Shim for wp_body_open in WordPress <5.2.
if ( ! function_exists( 'wp_body_open' ) ) {
    function wp_body_open() {
        do_action( 'wp_body_open' );
    }
}

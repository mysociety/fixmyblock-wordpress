<?php

function scripts_and_styles() {
    wp_enqueue_style(
        'fixmyblock-style',
        get_theme_file_uri('/assets/css/main.css'),
        array(),
        filemtime(get_theme_file_path('/assets/css/main.css'))
    );
}
add_action( 'wp_enqueue_scripts', 'scripts_and_styles' );

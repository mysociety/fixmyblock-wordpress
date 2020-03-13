<?php

function enqueue_frontend_stylesheet() {
    wp_enqueue_style(
        'fixmyblock-style',
        get_theme_file_uri('/assets/css/main.css'),
        array(),
        filemtime(get_theme_file_path('/assets/css/main.css'))
    );
}
add_action( 'wp_enqueue_scripts', 'enqueue_frontend_stylesheet' );

function enqueue_admin_stylesheet() {
    wp_enqueue_style(
        'fixmyblock-admin-style',
        get_theme_file_uri('/assets/css/admin-style.css'),
        array(),
        filemtime(get_theme_file_path('/assets/css/admin-style.css'))
    );
}
add_action( 'admin_enqueue_scripts', 'enqueue_admin_stylesheet' );

<?php

function enqueue_frontend_stylesheet() {
    wp_enqueue_style(
        'fixmyblock-frontend-style',
        get_theme_file_uri('/assets/css/frontend-style.css'),
        array(),
        filemtime(get_theme_file_path('/assets/css/frontend-style.css'))
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

function enqueue_editor_stylesheet() {
    add_editor_style(
        '/assets/css/editor-style.css'
    );
}
add_action( 'admin_init', 'enqueue_editor_stylesheet' );

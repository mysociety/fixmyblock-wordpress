<?php

function enqueue_frontend_stylesheets() {
    wp_enqueue_style(
        'fixmyblock-frontend-style',
        get_theme_file_uri('/assets/css/frontend-style.css'),
        array(),
        filemtime(get_theme_file_path('/assets/css/frontend-style.css'))
    );
}
add_action( 'wp_enqueue_scripts', 'enqueue_frontend_stylesheets' );

function enqueue_frontend_scripts() {
    wp_enqueue_script(
        'html5shiv',
        get_theme_file_uri('/assets/js/html5shiv.min.js'),
        array(),
        '3.7.3'
    );
    wp_script_add_data(
        'html5shiv',
        'conditional',
        'lt IE 9'
    );
    wp_enqueue_script(
        'bootstrap-js',
        get_theme_file_uri('/assets/js/bootstrap.bundle.min.js'),
        array('jquery'),
        '3.3.7'
    );
}
add_action( 'wp_enqueue_scripts', 'enqueue_frontend_scripts' );

function enqueue_admin_stylesheets() {
    wp_enqueue_style(
        'fixmyblock-admin-style',
        get_theme_file_uri('/assets/css/admin-style.css'),
        array(),
        filemtime(get_theme_file_path('/assets/css/admin-style.css'))
    );
}
add_action( 'admin_enqueue_scripts', 'enqueue_admin_stylesheets' );

function enqueue_editor_stylesheet() {
    add_editor_style(
        '/assets/css/editor-style.css'
    );
}
add_action( 'admin_init', 'enqueue_editor_stylesheet' );

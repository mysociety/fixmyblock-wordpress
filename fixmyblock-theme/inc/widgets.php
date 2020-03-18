<?php

function register_widgets() {
    register_sidebar( array(
        'name' => 'Generic sidebar',
        'id' => 'generic-sidebar',
        'description' => 'Shown beside blog posts, pages, and guides.',
        'before_widget' => '<div class="sidebar-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="sidebar-widget__title">',
        'after_title' => '</h2>'
    ) );
}
add_action( 'widgets_init', 'register_widgets' );

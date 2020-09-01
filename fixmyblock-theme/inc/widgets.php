<?php

function register_widgets() {
    $defaults = array(
        'before_widget' => '<div class="sidebar-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="sidebar-widget__title">',
        'after_title' => '</h2>',
    );

    register_sidebar( wp_parse_args( array(
        'name' => 'Front page sidebar',
        'id' => 'frontpage-sidebar',
        'description' => 'Shown on the front page.',
    ), $defaults ) );

    register_sidebar( wp_parse_args( array(
        'name' => 'Blog sidebar',
        'id' => 'blog-sidebar',
        'description' => 'Shown on the main blog page.',
    ), $defaults ) );

    register_sidebar( wp_parse_args( array(
        'name' => 'Blog post sidebar',
        'id' => 'post-sidebar',
        'description' => 'Shown beside blog posts.',
    ), $defaults ) );

    register_sidebar( wp_parse_args( array(
        'name' => 'Page sidebar',
        'id' => 'page-sidebar',
        'description' => 'Shown beside non-blog pages.',
    ), $defaults ) );

    register_sidebar( wp_parse_args( array(
        'name' => 'Search page sidebar',
        'id' => 'search-sidebar',
        'description' => 'Shown on the search results page.',
    ), $defaults ) );

    register_sidebar( wp_parse_args( array(
        'name' => 'Generic sidebar',
        'id' => 'generic-sidebar',
        'description' => 'Shown when no other, more specific, sidebar is suitable.',
    ), $defaults ) );

    register_sidebar( wp_parse_args( array(
        'name' => 'Footer widget area',
        'id' => 'footer-sidebar',
        'description' => 'Shown below the footer menu.',
        'class' => 'footer-sidebar',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => "</div>\n",
        'before_title'  => '<h2 class="widget__title">',
        'after_title'   => "</h2>\n",
    ), $defaults ) );

    register_sidebar( wp_parse_args( array(
        'name' => 'Posts and pages: before title',
        'id' => 'pre-title-sidebar',
        'description' => 'Shown above the title on blog posts and pages, but not on the front page or any archive pages.',
        'class' => 'pre-title-sidebar',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => "</div>\n",
        'before_title'  => '<h2 class="widget__title">',
        'after_title'   => "</h2>\n",
    ), $defaults ) );

    register_sidebar( wp_parse_args( array(
        'name' => 'Posts and pages: before content',
        'id' => 'pre-content-sidebar',
        'description' => 'Shown between the title and the content on blog posts and pages, but not on the front page or any archive pages.',
        'class' => 'pre-content-sidebar',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => "</div>\n",
        'before_title'  => '<h2 class="widget__title">',
        'after_title'   => "</h2>\n",
    ), $defaults ) );

    register_sidebar( wp_parse_args( array(
        'name' => 'Posts and pages: after content',
        'id' => 'post-content-sidebar',
        'description' => 'Shown below the content on blog posts and pages, but not on the front page or any archive pages.',
        'class' => 'post-content-sidebar',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => "</div>\n",
        'before_title'  => '<h2 class="widget__title">',
        'after_title'   => "</h2>\n",
    ), $defaults ) );
}
add_action( 'widgets_init', 'register_widgets' );

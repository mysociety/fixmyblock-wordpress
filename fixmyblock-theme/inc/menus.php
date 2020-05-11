<?php

function register_navwalker(){
    require get_parent_theme_file_path( '/vendor/class-wp-bootstrap-navwalker.php' );
}
add_action( 'after_setup_theme', 'register_navwalker' );

register_nav_menus(
    array(
        'header' => 'Header menu',
        'footer' => 'Footer menu',
    )
);

<?php

// index.php
// Used by WordPress if a more specific template cannot be found.
// https://developer.wordpress.org/themes/basics/template-hierarchy/

get_header();

include get_parent_theme_file_path( '/templates/post-list.php' );

get_footer();

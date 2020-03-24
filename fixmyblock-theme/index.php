<?php

// index.php
// Used by WordPress if a more specific template cannot be found.
// https://developer.wordpress.org/themes/basics/template-hierarchy/

get_header(); ?>

<div class="container">
    <div class="py-3 py-sm-4 py-md-5">

      <?php if ( is_search() ) { global $wp_query; ?>

        <h1><?php echo get_search_query(); ?></h1>
      <?php if ( ! $wp_query->found_posts ) { ?>
        <p>We could not find any results for your search.</p>
      <?php } ?>

      <?php } elseif ( is_archive() ) { ?>

        <h1><?php echo get_the_archive_title(); ?></h1>
      <?php if ( get_the_archive_description() ) { ?>
        echo '<p><?php echo get_the_archive_description(); ?></p>
      <?php } ?>

      <?php } ?>

<?php include get_parent_theme_file_path( '/templates/post-list.php' ); ?>

    </div>
</div>

<?php get_footer();

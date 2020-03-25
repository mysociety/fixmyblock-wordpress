<?php

// index.php
// Used by WordPress if a more specific template cannot be found.
// https://developer.wordpress.org/themes/basics/template-hierarchy/

get_header(); ?>

<div class="container">
    <div class="py-3 py-sm-4 py-md-5">

      <?php if ( is_search() ) { global $wp_query; ?>

        <div class="row mb-3 mb-md-5">
            <div class="col-md-7">
                <h1><?php echo get_search_query(); ?></h1>
              <?php if ( ! $wp_query->found_posts ) { ?>
                <p>We could not find any results for your search.</p>
              <?php } ?>
            </div>
        </div>

      <?php } elseif ( is_archive() ) { ?>

        <div class="row mb-3 mb-md-5">
            <div class="col-md-7">
                <h1><?php echo get_the_archive_title(); ?></h1>
              <?php if ( get_the_archive_description() ) { ?>
              echo '<p><?php echo get_the_archive_description(); ?></p>
              <?php } ?>
            </div>
        </div>

      <?php } ?>

        <div class="row">
            <div class="col-md-7">
                <?php include get_parent_theme_file_path( '/templates/post-list.php' ); ?>
            </div>
            <div class="col-md-4 offset-md-1 col-xl-3 offset-xl-2">
              <?php if ( is_active_sidebar( get_sidebar_id_for_page() ) ) { ?>
                <aside class="sidebar sidebar--archive">
                    <?php dynamic_sidebar( get_sidebar_id_for_page() ); ?>
                </aside>
              <?php } ?>
            </div>
        </div>

    </div>
</div>

<?php get_footer();

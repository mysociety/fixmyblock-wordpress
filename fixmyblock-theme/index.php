<?php

// index.php
// Used by WordPress if a more specific template cannot be found.
// https://developer.wordpress.org/themes/basics/template-hierarchy/

get_header(); ?>

<?php if ( is_search() ) { ?>
    <div class="search-header">
        <div class="container">
            <div class="py-3 pb-sm-4 pt-md-4 pb-md-5">
                <?php get_search_form(); ?>
            </div>
        </div>
    </div>
<?php } ?>

<div class="container">
    <div class="py-3 py-sm-4 py-md-5">

      <?php if ( is_archive() ) { ?>

        <div class="row mb-3 mb-md-5">
            <div class="col-md-7">
                <?php the_page_title_and_description(); ?>
            </div>
        </div>

      <?php } ?>

        <div class="row">
            <div class="col-md-7">
              <?php if ( is_search() ) { global $wp_query; ?>
                <?php if ( ! $wp_query->found_posts ) { ?>
                  <p>We could not find any results for your search.</p>
                <?php } ?>
              <?php } ?>
                <?php get_template_part( 'templates/post-list' ); ?>
                <?php the_posts_pagination(); ?>
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

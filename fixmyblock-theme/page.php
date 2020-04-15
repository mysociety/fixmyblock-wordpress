<?php

// page.php
// Static "pages" (ie: not blog posts!) will be presented via this template.
// https://developer.wordpress.org/themes/basics/template-hierarchy/

get_header();

if ( is_front_page() ) { ?>
    <div class="page-header">
        <div class="container">
            <h1><?php the_title(); ?></h1>
            <?php get_search_form(); ?>
        </div>
    </div>
<?php }

start_site_content();

if ( have_posts() ) {
    while ( have_posts() ) {
        the_post(); ?>

      <?php if ( ! is_front_page() ) { ?>
        <div class="page-section">
            <div class="page-section__primary">
                <h1><?php the_title(); ?></h1>
            </div>
        </div>
      <?php } ?>

      <?php the_table_of_contents(); ?>

      <?php the_feature_section(); ?>

        <div class="page-section">
            <div class="page-section__primary">
                <?php the_content(); ?>
            </div>
            <div class="page-section__secondary">
                <?php the_sidebar(); ?>
            </div>
        </div>

<?php
    }
}

end_site_content();

get_footer();

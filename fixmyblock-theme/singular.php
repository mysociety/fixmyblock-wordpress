<?php

// singular.php
// Individual posts and pages will be presented via this template.
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

if ( is_layout( 'feature-full-width' ) ) {
    the_feature_section();
}

start_site_content();

if ( have_posts() ) {
    while ( have_posts() ) {
        the_post(); ?>

      <?php if ( is_layout( 'feature-narrow' ) || is_layout( 'feature-wide' ) ) {
          the_feature_section();
      } ?>

      <?php if ( ! is_front_page() ) { ?>
        <div class="page-section">
            <div class="page-section__primary">
                <?php dynamic_sidebar( 'pre-title-sidebar' ); ?>
                <h1><?php the_title(); ?></h1>
              <?php if ( get_post_type() == 'post' ) { ?>
                <time datetime="<?php the_time( 'Y-m-d' ); ?>"><?php the_time('jS F Y'); ?></time>
              <?php } elseif ( get_post_type() == 'page' ) { ?>
                <?php the_table_of_contents(); ?>
              <?php } ?>
            </div>
        </div>
      <?php } ?>

        <div class="page-section">
            <div class="page-section__primary">
                <?php if ( ! is_front_page() ) { dynamic_sidebar( 'pre-content-sidebar' ); } ?>
                <?php the_content(); ?>
                <?php if ( ! is_front_page() ) { dynamic_sidebar( 'post-content-sidebar' ); } ?>
                <?php the_media_credits(); ?>
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

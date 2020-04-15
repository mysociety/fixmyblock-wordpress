<?php

// single.php
// Individual blog posts will be presented via this template.
// https://developer.wordpress.org/themes/basics/template-hierarchy/

get_header();

start_site_content();

if ( have_posts() ) {
    while ( have_posts() ) {
        the_post(); ?>

        <div class="page-section">
            <div class="page-section__primary">
                <h1><?php the_title(); ?></h1>
              <?php if ( get_post_type() == 'post' ) { ?>
                <time datetime="<?php the_time( 'Y-m-d' ); ?>"><?php the_time('jS F Y'); ?></time>
              <?php } ?>
            </div>
        </div>

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

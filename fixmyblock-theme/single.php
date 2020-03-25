<?php

// single.php
// Individual blog posts will be presented via this template.
// https://developer.wordpress.org/themes/basics/template-hierarchy/

get_header();

if ( have_posts() ) {
    while ( have_posts() ) {
        the_post(); ?>

<div class="container">
    <div class="py-3 py-sm-4 py-md-5">

        <div class="row mb-3 mb-md-5">
            <div class="col-md-7">
                <h1><?php the_title(); ?></h1>
              <?php if ( get_post_type() == 'post' ) { ?>
                <time datetime="<?php the_time( 'Y-m-d' ); ?>"><?php the_time('jS F Y'); ?></time>
              <?php } ?>
            </div>
        </div>

      <?php if ( has_post_thumbnail() ) { ?>
        <p>
            <a href="<?php echo esc_url( get_permalink() ); ?>">
                <?php the_post_thumbnail(); ?>
            </a>
        </p>
      <?php } ?>

        <div class="row">
            <div class="col-md-7">
                <?php the_content(); ?>
            </div>
            <div class="col-md-4 ofset-md-1 col-xl-3 offset-xl-2">
              <?php if ( is_active_sidebar( get_sidebar_id_for_page() ) ) { ?>
                <aside class="sidebar sidebar--post">
                    <?php dynamic_sidebar( get_sidebar_id_for_page() ); ?>
                </aside>
              <?php } ?>
            </div>
        </div>

    </div>
</div>

<?php
    }
}

get_footer();

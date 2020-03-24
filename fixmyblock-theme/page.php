<?php

// page.php
// Static "pages" (ie: not blog posts!) will be presented via this template.
// https://developer.wordpress.org/themes/basics/template-hierarchy/

get_header();

if ( have_posts() ) {
    while ( have_posts() ) {
        the_post(); ?>

<?php if ( is_front_page() ) { ?>
    <div class="home-header">
        <div class="container">
            <div class="py-3 py-sm-4 py-md-5">
                <h1><?php the_title(); ?></h1>
                <?php get_search_form(); ?>
            </div>
        </div>
    </div>
<?php } ?>

<div class="container">
    <div class="py-3 py-sm-4 py-md-5">

      <?php if ( ! is_front_page() ) { ?>
        <div class="row">
            <div class="col-md-8">
                <h1><?php the_title(); ?></h1>
            </div>
        </div>
      <?php } ?>

      <?php if ( has_post_thumbnail() ) { ?>
        <p>
            <a href="<?php echo esc_url( get_permalink() ); ?>">
                <?php the_post_thumbnail(); ?>
            </a>
        </p>
      <?php } ?>

        <div class="row">
            <div class="col-md-8">
                <?php the_content(); ?>
            </div>
            <div class="col-md-4">
              <?php if ( is_active_sidebar( 'generic-sidebar' ) ) { ?>
                <aside class="blog-sidebar">
                    <?php dynamic_sidebar( 'generic-sidebar' ); ?>
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

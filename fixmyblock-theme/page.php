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
            <div class="py-3 pb-sm-4 pt-md-4 pb-md-5">
                <h1><?php the_title(); ?></h1>
                <?php get_search_form(); ?>
            </div>
        </div>
    </div>
<?php } ?>

<div class="container">
    <div class="py-3 py-sm-4 py-md-5">

      <?php if ( ! is_front_page() ) { ?>
        <div class="row mb-3 mb-md-5">
            <div class="col-md-7">
                <h1><?php the_title(); ?></h1>
            </div>
        </div>
      <?php } ?>

      <?php the_table_of_contents(); ?>

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
            <div class="col-md-4 offset-md-1 col-xl-3 offset-xl-2">
              <?php if ( is_active_sidebar( get_sidebar_id_for_page() ) ) { ?>
                <aside class="sidebar sidebar--page">
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

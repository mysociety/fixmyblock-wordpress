<?php

// single.php
// Individual blog posts will be presented via this template.
// https://developer.wordpress.org/themes/basics/template-hierarchy/

get_header();

if ( have_posts() ) {
    while ( have_posts() ) {
        the_post(); ?>
    <div class="py-3 py-sm-4 py-md-5">
        <h1>
            <a href="<?php echo esc_url( get_permalink() ); ?>">
                <?php the_title(); ?>
            </a>
        </h1>
      <?php if ( get_post_type() == 'post' ) { ?>
        <time datetime="<?php the_time( 'Y-m-d' ); ?>"><?php the_time('jS F Y'); ?></time>
      <?php } ?>
      <?php if ( has_post_thumbnail() ) { ?>
        <p>
            <a href="<?php echo esc_url( get_permalink() ); ?>">
                <?php the_post_thumbnail(); ?>
            </a>
        </p>
      <?php } ?>
        <div>
            <?php the_content(); ?>
        </div>
    </div>
    <?php
    }
}

get_footer();

<?php

// index.php
// Used by WordPress if a more specific template cannot be found.
// https://developer.wordpress.org/themes/basics/template-hierarchy/

get_header();

if ( have_posts() ) :
    while ( have_posts() ) :
        the_post(); ?>
  <?php if ( has_post_thumbnail() ): ?>
    <?php the_post_thumbnail(); ?>
  <?php endif; ?>
    <h2>
        <a href="<?php echo esc_url( get_permalink() ); ?>">
            <?php the_title(); ?>
        </a>
    </h2>
    <time datetime="<?php the_time( 'Y-m-d' ); ?>"><?php the_time('jS F Y'); ?></time>
    <div><?php the_content(); ?></div>
<?php
    endwhile;
endif;

get_footer();

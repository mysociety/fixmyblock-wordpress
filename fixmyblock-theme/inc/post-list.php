<?php if ( have_posts() ) {
    while ( have_posts() ) {
        the_post(); ?>
    <div class="post-preview py-3 border-bottom">
        <h2>
            <a href="<?php echo esc_url( get_permalink() ); ?>">
                <?php the_title(); ?>
            </a>
        </h2>
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
        <div><?php
            the_excerpt();
            if ( has_excerpt() ) {
                echo '<p><a href="' . get_the_permalink() . '" class="read-more">Read More</a></p>';
            }
        ?></div>
    </div>
<?php
    }
}
?>

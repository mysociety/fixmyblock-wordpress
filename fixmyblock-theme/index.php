<?php

// index.php
// Used by WordPress if a more specific template cannot be found.
// https://developer.wordpress.org/themes/basics/template-hierarchy/

$cover_page = get_cover_page();

get_header();

if ( is_search() ) { ?>
    <div class="page-header">
        <div class="container">
              <?php get_search_form(); ?>
        </div>
    </div>
<?php }

if ( $cover_page && $cover_page['layout'] == 'feature-full-width' ) {
    echo $cover_page['the_feature_section'];
}

start_site_content();

?>

      <?php if ( $cover_page && ( $cover_page['layout'] == 'feature-narrow' || $cover_page['layout'] == 'feature-wide' ) ) { ?>
        <?php echo $cover_page['the_feature_section']; ?>
      <?php } ?>

      <?php if ( is_archive() ) { ?>
        <div class="page-section">
            <div class="page-section__primary">
              <?php if ( $cover_page ) { ?>
                <h1><?php echo $cover_page['the_title']; ?></h1>
                <?php echo $cover_page['the_content']; ?>
              <?php } else { ?>
                <?php the_page_title_and_description(); ?>
              <?php } ?>
            </div>
        </div>
      <?php } ?>

        <div class="page-section">
            <div class="page-section__primary">
                <?php echo post_list(); ?>
                <?php the_posts_pagination(); ?>
            </div>
            <div class="page-section__secondary">
                <?php the_sidebar(); ?>
            </div>
        </div>

<?php get_footer();

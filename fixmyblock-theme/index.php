<?php

// index.php
// Used by WordPress if a more specific template cannot be found.
// https://developer.wordpress.org/themes/basics/template-hierarchy/

get_header();

if ( is_search() ) { ?>
    <div class="page-header">
        <div class="container">
              <?php get_search_form(); ?>
        </div>
    </div>
<?php }

start_site_content();

?>

      <?php if ( is_archive() ) { ?>
        <div class="page-section">
            <div class="page-section__primary">
                <?php the_page_title_and_description(); ?>
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

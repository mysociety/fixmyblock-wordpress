<?php

// archive-group.php
// Used for listing items with a post_type of "group".
// https://developer.wordpress.org/themes/basics/template-hierarchy/

get_header();

start_site_content();

?>

        <div class="page-section">
            <div class="page-section__primary">
                <?php the_page_title_and_description(); ?>
            </div>
        </div>

        <div class="page-section">
            <div class="page-section__primary">
                <form class="mb-4">
                    <div class="form-group">
                        <label for="group_s">Search groups by name</label>
                        <input class="form-control" type="search" id="group_s" name="s" value="<?php echo get_query_var('s'); ?>">
                    </div>
                    <div class="row">
                        <div class="col-6 col-xl-5">
                            <div class="form-group">
                                <label for="group_type">Type of group</label>
                                <select class="form-control" id="group_type" name="group_type">
                                    <option value="">Any type</option>
                                    <option disabled>────────</option>
                                    <?php echo get_taxonomy_terms_as_html_options( 'group_type'); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-6 col-xl-5">
                            <div class="form-group">
                                <label for="group_type">Area covered</label>
                                <select class="form-control" id="group_area" name="group_area">
                                    <option value="">Any area</option>
                                    <option disabled>────────</option>
                                    <?php echo get_taxonomy_terms_as_html_options( 'group_area' ); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-2 d-flex flex-column justify-content-end">
                            <button type="submit" class="btn btn-primary mb-3 mt-2">Search</button>
                        </div>
                    </div>
                </form>
                <!-- TODO: Display something useful if no results -->
                <?php get_template_part( 'templates/post-list' ); ?>
                <?php the_posts_pagination(); ?>
            </div>
            <div class="page-section__secondary">
                <?php the_sidebar(); ?>
            </div>
        </div>

<?php get_footer();

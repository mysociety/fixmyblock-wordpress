<?php

// We do something clever here.
//
// If we’re viewing an archive of posts, and there's a *page* with the same
// slug as the archive page (eg: "tag/foobar") then we extract details about
// that page, including the feature image, title, and processed page content,
// so that they can be output on the archive page.
//
// This enables us to create fully customisable (and optional) "landing pages"
// for an post archives.

function get_cover_page() {
    $cover_page = array();

    $queried_object = get_queried_object();

    if ( is_tax() || is_tag() || is_category() ) {
        $taxonomy = get_taxonomy( $queried_object->taxonomy );
        $pagename = $taxonomy->rewrite['slug'] . '/' . $queried_object->slug;

    } elseif ( is_post_type_archive() ) {
        $pagename = $queried_object->rewrite['slug'];
    }

    if ( isset($pagename) ) {
        $cover_page_query = new WP_Query(array(
            'pagename' => $pagename,
            'post_type' => 'any',
        ));

        while ( $cover_page_query->have_posts() ) {
            $cover_page_query->the_post();

            // TODO: Need to work out a way to extract the <title>
            // for this page, and pass that along too, so it can be
            // used instead of the archive <title>.

            set_layout( get_the_layout() );

            ob_start();
            the_feature_section();
            $cover_page['the_feature_section'] = ob_get_clean();

            ob_start();
            the_title();
            $cover_page['the_title'] = ob_get_clean();

            ob_start();
            the_content();
            $cover_page['the_content'] = ob_get_clean();
        }

        wp_reset_postdata();
    }

    return $cover_page;
}

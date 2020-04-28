<?php

function post_list( $posts, $args = array() ) {
    // Set defaults for any arguments we care about in post_list.
    // We’ll leave the rest to the default handling in post_list_item.
    $defaults = array(
        'extra_list_classes' => '',
    );
    $a = wp_parse_args( $args, $defaults );

    echo sprintf(
        '<div class="%s">' . "\n",
        esc_attr( trim( 'post-list ' . $a['extra_list_classes'] ) )
    );

    foreach( $posts as $p ) {
        echo post_list_item( $p, $args );
    }

    echo '</div>' . "\n";
}

function post_list_item( $post, $args = array() ) {
    $defaults = array(
        'show_excerpts' => true,
        'show_thumbnails' => true,
        'heading_tag' => 'h2',
    );
    $a = wp_parse_args( $args, $defaults );

    echo '<div class="post-list__item">' . "\n";

    if ( $a['show_thumbnails'] ) {
        $thumbnail_html = get_the_post_thumbnail( $post );
        if ( $thumbnail_html == '' ) {
            $thumbnail_html = sprintf(
                '<img src="%s" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" width="360" height="360">',
                esc_attr( get_template_directory_uri() . '/assets/img/default-post-thumbnail-360x360.png' )
            );
        }
        echo sprintf(
            '<div class="post-list__item__image">%s</div>' . "\n",
            $thumbnail_html
        );
    }

    echo '<div class="post-list__item__content">' . "\n";

    echo sprintf(
        '<%s class="post-list__item__title"><a href="%s">%s</a></%s>' . "\n",
        esc_html( $a['heading_tag'] ),
        esc_url( get_permalink($post) ),
        esc_html( get_the_title($post) ),
        esc_html( $a['heading_tag'] )
    );
    if ( get_post_type($post) == 'post' ) {
        echo sprintf(
            '<time class="post-list__item__date" datetime="%s">%s</time>' . "\n",
            get_the_time( 'Y-m-d', $post ),
            get_the_time( 'jS F Y', $post )
      );
    }
    if ( $a['show_excerpts'] ) {
        echo sprintf(
            '<div class="post-list__item__excerpt">%s</div>' . "\n",
            get_the_excerpt($post)
        );
    }

    echo '</div>' . "\n";

    echo '</div>' . "\n";
}

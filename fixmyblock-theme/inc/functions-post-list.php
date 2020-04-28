<?php

function post_list( $posts, $args = array() ) {
    // Set defaults for any arguments we care about in post_list.
    // We’ll leave the rest to the default handling in post_list_item.
    $defaults = array(
        'extra_list_classes' => '',
        'more_url' => '',
    );
    $a = wp_parse_args( $args, $defaults );

    echo sprintf(
        '<div class="%s">' . "\n",
        esc_attr( trim( 'post-list ' . $a['extra_list_classes'] ) )
    );

    foreach( $posts as $p ) {
        echo post_list_item( $p, $args );
    }

    if ( $a['more_url'] ) {
        echo '<div class="post-list__item post-list__item--more">' . "\n";
        echo sprintf(
            '<a href="%s">Show more</a>',
            $a['more_url']
        );
        echo '</div>' . "\n";
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
        echo sprintf(
            '<a href="%s" class="post-list__item__image">%s</a>' . "\n",
            esc_url( get_permalink( $post ) ),
            get_post_list_thumbnails( $post )
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

function get_post_list_thumbnails( $post ) {
    $html = '';

    if ( has_post_thumbnail( $post ) ) {
        $html .= get_the_post_thumbnail( $post, 'post-thumbnail' ) . "\n";
        $html .= get_the_post_thumbnail( $post, 'feature-narrow' ) . "\n";
    } else {
        $html .= sprintf(
            '<img src="%s" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" width="360" height="360">' . "\n",
            esc_attr( get_template_directory_uri() . '/assets/img/default-post-thumbnail-360x360.png' )
        );
        $html .= sprintf(
            '<img src="%s" class="attachment-post-thumbnail size-feature-narrow wp-post-image" alt="" width="640" height="360">' . "\n",
            esc_attr( get_template_directory_uri() . '/assets/img/default-post-thumbnail-640x360.png' )
        );
    }

    return $html;
}

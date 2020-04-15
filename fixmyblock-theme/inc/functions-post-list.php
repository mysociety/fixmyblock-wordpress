<?php

function post_list( $posts, $args = array() ) {
    echo '<div class="post-list">' . "\n";
    foreach( $posts as $p ) {
        echo post_list_item( $p, $args );
    }
    echo '</div>' . "\n";
}

function post_list_item( $post, $args = array() ) {
    $defaults = array(
        'show_excerpt' => true,
        'heading_tag' => 'h2',
    );
    $a = wp_parse_args( $args, $defaults );

    echo '<div class="post-list__item">' . "\n";

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
    if ( $a['show_excerpt'] ) {
        echo sprintf(
            '<div class="post-list__item__excerpt">%s</div>' . "\n",
            get_the_excerpt($post)
        );
    }

    echo '</div>';
}

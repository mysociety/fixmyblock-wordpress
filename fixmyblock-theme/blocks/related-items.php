<?php

use Carbon_Fields\Block;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

function define_related_items_block() {
    Block::make(
        __( 'Related items' )
    )->set_icon(
        'randomize'
    )->add_fields(
        array(
            Field::make(
                'text',
                'title',
                __( 'Title' )
            )->set_default_value(
                __( 'Related guides' )
            ),
            Field::make(
                'association',
                'related_items',
                __( 'Related items' )
            )->set_types(
                array(
                    array( 'type' => 'post', 'post_type' => 'post' ),
                    array( 'type' => 'post', 'post_type' => 'page' ),
                )
            ),
        )
    )->set_render_callback( 'render_related_items_block' );
}

function render_related_items_block( $fields, $attributes, $inner_blocks ) {
    $className = 'related-items';
    if ( isset($attributes['className']) ) {
        $className = $className . ' ' . $attributes['className'];
    }
    echo sprintf(
        '<div class="%s">' . "\n",
        esc_attr( $className )
    );

    if ( isset($fields['title']) ) {
        echo sprintf(
            '<h2>%s</h2>' . "\n",
            esc_html($fields['title'])
        );
    }

    echo '<div class="post-list">' . "\n";

    foreach ( $fields['related_items'] as $r ) {
        if ( $r['type'] == 'post' ) {
            $p = get_post( $r['id'] );
            echo post_list_item( $p, array( 'heading_tag' => 'h3' ) );
        }
    }

    echo '</div>' . "\n";
    echo '</div>' . "\n";
}

add_action( 'carbon_fields_register_fields', 'define_related_items_block' );

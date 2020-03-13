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
                    array( 'type' => 'post', 'post_type' => 'guide' ),
                )
            ),
        )
    )->set_render_callback( 'render_related_items_block' );
}

function render_related_items_block( $fields, $attributes, $inner_blocks ) {
    $className = 'fmb-related-items';
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

    echo '<ul>';

    foreach ( $fields['related_items'] as $r ) {
        if ( $r['type'] == 'post' ) {
            $p = get_post( $r['id'] );
            echo sprintf(
                '<li><a href="%s">%s</a></li>' . "\n",
                get_permalink($p),
                get_the_title($p)
            );
        }
    }

    echo '</ul>' . "\n";
    echo '</div>' . "\n";
}

add_action( 'carbon_fields_register_fields', 'define_related_items_block' );

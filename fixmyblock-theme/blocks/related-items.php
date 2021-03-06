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
                __( 'Title (optional)' )
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
            Field::make(
                'select',
                'display_as',
                __( 'Display as' )
            )->set_options(
                array(
                    0 => __( 'List, with square images (default)' ),
                    1 => __( 'List, without images' ),
                    2 => __( 'Grid, with wide images' ),
                )
            ),
        )
    )->set_render_callback( 'render_related_items_block' );
}

function render_related_items_block( $fields, $attributes, $inner_blocks ) {
    $results = array();
    $post_list_args = array(
        'heading_tag' => 'h3',
        'extra_list_classes' => '',
    );

    if ( isset($attributes['className']) ) {
        $post_list_args['extra_list_classes'] .= ' ' . $attributes['className'];
    }

    if ( isset($fields['display_as']) && $fields['display_as'] == 2 ) {
        $post_list_args['extra_list_classes'] .= ' post-list--grid';
    } elseif ( isset($fields['display_as']) && $fields['display_as'] == 1 ) {
        $post_list_args['show_thumbnails'] = false;
    }

    foreach ( $fields['related_items'] as $r ) {
        $p = get_post( $r['id'] );
        if ( $p ) {
            $results[] = $p;
        }
    }

    if ( $results ) {
        // Optional title for backwards compatibility.
        // Really if they want a title, they should use a separate title block.
        if ( isset($fields['title']) ) {
            echo sprintf(
                '<h2>%s</h2>' . "\n",
                esc_html( $fields['title'] )
            );
        }

        echo post_list( $results, $post_list_args );
    }
}

add_action( 'carbon_fields_register_fields', 'define_related_items_block' );

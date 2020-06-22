<?php

use Carbon_Fields\Block;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

function define_tag_list_block() {
    $sort_options = array(
        0 => __( 'Tag name, A-Z' ),
        1 => __( 'Number of times tag has been used, most to least' ),
    );

    Block::make(
        __( 'Tag list' )
    )->set_icon(
        'tag'
    )->add_fields(
        array(
            Field::make(
                'select',
                'order',
                __( 'List tags ordered by' )
            )->set_options(
                $sort_options
            ),
            Field::make(
                'text',
                'limit',
                __( 'Limit (optional)' )
            )->set_attribute(
                'pattern',
                '[0-9]*'
            ),
            Field::make(
                'text',
                'emphasis',
                __( 'Emphasise tags used this many times or more (optional)' )
            )->set_attribute(
                'pattern',
                '[0-9]*'
            )
        )
    )->set_render_callback( 'render_tag_list_block' );
}

function render_tag_list_block( $fields, $attributes, $inner_blocks ) {
    $options = array(
        'order' => 0,
        'limit' => -1,
        'emphasis' => -1,
        'extra_list_classes' => '',
    );

    if ( isset($fields['order']) && $fields['order'] == 1 ) {
        $options['order'] = 1;
    }

    if ( isset($fields['limit']) && is_numeric($fields['limit']) ) {
        $options['limit'] = intval($fields['limit']);
    }

    if ( isset($fields['emphasis']) && is_numeric($fields['emphasis']) ) {
        $options['emphasis'] = intval($fields['emphasis']);
    }

    if ( isset($attributes['className']) ) {
        $options['extra_list_classes'] .= ' ' . $attributes['className'];
    }

    $tags = get_tags();
    if ( $tags ) {
        if ( $options['order'] == 1 ) {
            function sort_tags_by_count($a, $b) {
                return $b->count - $a->count;
            }
            usort($tags, "sort_tags_by_count");
        }

        if ( $options['limit'] > -1 ) {
            $tags = array_slice( $tags, 0, $options['limit'] );
        }

        echo sprintf(
            '<div class="%s">' . "\n",
            esc_attr( trim( 'tag-links ' . $options['extra_list_classes'] ) )
        );

        foreach ( $tags as $tag ) {
            if ( $options['emphasis'] > -1 && $tag->count >= $options['emphasis'] ) {
                $tag_class = 'tag-link tag-link--emphasised';
            } else {
                $tag_class = 'tag-link';
            }

            echo sprintf(
                '<a href="%s" class="%s">%s</a> ',
                get_tag_link( $tag->term_id ),
                esc_attr( $tag_class ),
                esc_html( $tag->name ),
            );
        }

        echo '</div>';
    }
}

add_action( 'carbon_fields_register_fields', 'define_tag_list_block' );

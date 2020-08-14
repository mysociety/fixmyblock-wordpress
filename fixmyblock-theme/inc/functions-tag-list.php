<?php

use Carbon_Fields\Field;

function get_tag_list_widget_fields( $context = 'widget' ) {
    $fields = array();

    // Widgets can have a title, but blocks don't.
    if ( $context == 'widget' ) {
        $fields[] = Field::make(
            'text',
            'title',
            __( 'Title' )
        );
    }

    $fields[] = Field::make(
        'select',
        'source',
        __( 'List' )
    )->set_options(
        array(
            0 => __( 'All tags on ' . get_option( 'blogname' ) ),
            1 => __( 'Only tags applied to the current post or page' ),
        )
    );

    $fields[] = Field::make(
        'select',
        'order',
        __( 'Order by' )
    )->set_options(
        array(
            0 => __( 'Tag name, A-Z' ),
            1 => __( 'Number of times tag has been used, most to least' ),
        )
    );

    $fields[] = Field::make(
        'text',
        'limit',
        __( 'Limit (optional)' )
    )->set_attribute(
        'pattern',
        '[0-9]*'
    );

    $fields[] = Field::make(
        'text',
        'emphasis',
        __( 'Emphasise tags used this many times or more (optional)' )
    )->set_attribute(
        'pattern',
        '[0-9]*'
    );

    return $fields;
}

function get_tag_list_output_defaults( $options = array() ) {
    return array(
        'source' => 0,
        'order' => 0,
        'limit' => -1,
        'emphasis' => -1,
        'title' => '',
        'extra_list_classes' => '',
        'before_title' => '',
        'after_title' => '',
    );
}

function get_tag_list_output( $options ) {
    $output = '';
    $tags = array();

    if ( $options['source'] == 1 && is_singular() ) {
        $tags = get_the_tags();
    } else if ( $options['source'] == 0 ) {
        $tags = get_tags();
    }

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

        if ( isset($options['title']) && $options['title'] != '' ) {
            $output .= sprintf(
                '%s %s %s' . "\n",
                $options['before_title'],
                esc_html( $options['title'] ),
                $options['after_title']
            );
        }

        $output .= sprintf(
            '<div class="%s">' . "\n",
            esc_attr( trim( 'tag-links ' . $options['extra_list_classes'] ) )
        );

        foreach ( $tags as $tag ) {
            if ( $options['emphasis'] > -1 && $tag->count >= $options['emphasis'] ) {
                $tag_class = 'tag-link tag-link--emphasised';
            } else {
                $tag_class = 'tag-link';
            }

            $output .= sprintf(
                '<a href="%s" class="%s" title="%s">%s</a> ',
                get_tag_link( $tag->term_id ),
                esc_attr( $tag_class ),
                sprintf( _n(
                    '%s item',
                    '%s items',
                    $tag->count
                ), $tag->count ),
                esc_html( $tag->name ),
            );
        }

        $output .= '</div>' . "\n";
    }

    return $output;
}

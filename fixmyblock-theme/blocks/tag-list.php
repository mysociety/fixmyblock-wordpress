<?php

use Carbon_Fields\Block;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

function define_tag_list_block() {
    Block::make(
        __( 'Tag list' )
    )->set_icon(
        'tag'
    )->add_fields(
        get_tag_list_widget_fields( 'block' )
    )->set_render_callback( 'render_tag_list_block' );
}

function render_tag_list_block( $fields, $attributes, $inner_blocks ) {
    $options = get_tag_list_output_defaults();

    if ( isset($fields['source']) ) {
        $options['source'] = $fields['source'];
    }

    if ( isset($fields['order']) ) {
        $options['order'] = $fields['order'];
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

    echo get_tag_list_output( $options );
}

add_action( 'carbon_fields_register_fields', 'define_tag_list_block' );

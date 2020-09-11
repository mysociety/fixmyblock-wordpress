<?php

use Carbon_Fields\Block;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

function define_table_of_contents_block() {
    Block::make(
        __( 'Table of contents' )
    )->set_icon(
        'editor-ol'
    )->add_fields(
        get_table_of_contents_widget_fields( 'block' )
    )->set_render_callback( 'render_table_of_contents_block' );
}

function render_table_of_contents_block( $fields, $attributes, $inner_blocks ) {
    $options = array();

    if ( isset($attributes['className']) ) {
        $options['extra_classes'] = $attributes['className'];
    }

    echo get_table_of_contents_output( $options );
}

add_action( 'carbon_fields_register_fields', 'define_table_of_contents_block' );

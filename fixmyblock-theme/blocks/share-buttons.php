<?php

use Carbon_Fields\Block;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

function define_share_buttons_block() {
    Block::make(
        __( 'Share buttons' )
    )->set_icon(
        'share'
    )->add_fields(
        get_share_buttons_widget_fields( 'block' )
    )->set_render_callback( 'render_share_buttons_block' );
}

function render_share_buttons_block( $fields, $attributes, $inner_blocks ) {
    $options = get_share_buttons_output_defaults();

    if ( isset($fields['size']) && $fields['size'] == 'large' ) {
        $options['size'] = 'large';
    } else if ( isset($fields['size']) && $fields['size'] == 'small' ) {
        $options['size'] = 'small';
    }

    if ( isset($fields['label']) && $fields['label'] == 'short' ) {
        $options['label'] = 'short';
    }

    if ( isset($attributes['className']) ) {
        $options['extra_classes'] = $attributes['className'];
    }

    echo get_share_buttons_output( $options );
}

add_action( 'carbon_fields_register_fields', 'define_share_buttons_block' );

<?php

use Carbon_Fields\Block;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

function define_big_number_block() {
    Block::make(
        __( 'Big number' )
    )->set_icon(
        'excerpt-view'
    )->set_inner_blocks(
        true
    )->set_render_callback( 'render_big_number_block' );
}

function render_big_number_block( $fields, $attributes, $inner_blocks ) {
    echo sprintf(
        '<div class="big-number">%s</div>',
        $inner_blocks
    );
}

add_action( 'carbon_fields_register_fields', 'define_big_number_block' );

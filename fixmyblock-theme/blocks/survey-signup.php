<?php

use Carbon_Fields\Block;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

function define_survey_signup_block() {
    Block::make(
        __( 'Survey signup' )
    )->set_icon(
        'email-alt'
    )->add_fields(
        get_survey_signup_widget_fields( 'block' )
    )->set_render_callback( 'render_survey_signup_block' );
}

function render_survey_signup_block( $fields, $attributes, $inner_blocks ) {
    $options = get_survey_signup_output_defaults();

    if ( isset($fields['title']) ) {
        $options['title'] = $fields['title'];
    }

    if ( isset($fields['content']) ) {
        $options['content'] = $fields['content'];
    }

    if ( isset($fields['button']) ) {
        $options['button'] = $fields['button'];
    }

    if ( isset($attributes['className']) ) {
        $options['extra_classes'] = $attributes['className'];
    }

    echo get_survey_signup_output( $options );
}

add_action( 'carbon_fields_register_fields', 'define_survey_signup_block' );

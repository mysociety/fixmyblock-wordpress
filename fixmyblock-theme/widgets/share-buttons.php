<?php

use Carbon_Fields\Widget;

class ShareButtonsWidget extends Widget {
    function __construct() {
        $this->setup(
            'share_buttons_widget',
            'Share Buttons',
            'Displays social sharing buttons for the current page',
            get_share_buttons_widget_fields( 'widget' )
        );
    }

    function front_end( $args, $fields ) {
        $options = get_share_buttons_output_defaults();

        if ( isset($fields['size']) && $fields['size'] == 'large' ) {
            $options['size'] = 'large';
        } else if ( isset($fields['size']) && $fields['size'] == 'small' ) {
            $options['size'] = 'small';
        }

        if ( isset($fields['label']) && $fields['label'] == 'short' ) {
            $options['label'] = 'short';
        }

        echo get_share_buttons_output( $options );
    }
}

function load_share_buttons_widget() {
    register_widget( 'ShareButtonsWidget' );
}

add_action( 'widgets_init', 'load_share_buttons_widget' );

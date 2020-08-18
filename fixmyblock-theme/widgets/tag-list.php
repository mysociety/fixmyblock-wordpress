<?php

use Carbon_Fields\Widget;

class TagListWidget extends Widget {
    function __construct() {
        $this->setup(
            'tag_list_widget',
            'Tag List',
            'Displays a list of tags applied to the current post, or across the entire site',
            get_tag_list_widget_fields( 'widget' )
        );
    }

    function front_end( $args, $fields ) {
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

        if ( isset($fields['title']) && $fields['title'] != '' ) {
            $options['title'] = $fields['title'];
        }

        if ( isset($args['before_title']) ) {
            $options['before_title'] = $args['before_title'];
        }

        if ( isset($args['after_title']) ) {
            $options['after_title'] = $args['after_title'];
        }

        echo get_tag_list_output( $options );
    }
}

function load_tag_list_widget() {
    register_widget( 'TagListWidget' );
}

add_action( 'widgets_init', 'load_tag_list_widget' );

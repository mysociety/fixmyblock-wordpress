<?php

use Carbon_Fields\Widget;

class SurveySignupWidget extends Widget {
    function __construct() {
        $this->setup(
            'survey_signup_widget',
            'Survey Signup',
            'Displays the signup form for our post-visit survey',
            get_survey_signup_widget_fields( 'widget' )
        );
    }

    function front_end( $args, $fields ) {
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

        echo get_survey_signup_output( $options );
    }
}

function load_survey_signup_widget() {
    register_widget( 'SurveySignupWidget' );
}

add_action( 'widgets_init', 'load_survey_signup_widget' );

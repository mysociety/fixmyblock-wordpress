<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

global $share_button_services;
$share_button_services = array(
    'facebook' => array(
        'label' => 'Share on Facebook',
        'short_label' => 'Share',
        'url' => 'https://www.facebook.com/sharer.php?u={url}',
    ),
    'twitter' => array(
        'label' => 'Share on Twitter',
        'short_label' => 'Share',
        'url' => 'https://twitter.com/intent/tweet?url={url}&text={title}',
    ),
    'linkedin' => array(
        'label' => 'Share on LinkedIn',
        'short_label' => 'Share',
        'url' => 'https://www.linkedin.com/sharing/share-offsite/?url={url}',
    ),
    'whatsapp' => array(
        'label' => 'Share via WhatsApp',
        'short_label' => 'Send',
        'url' => 'https://api.whatsapp.com/send?text={title}%20{url}',
    ),
    'gmail' => array(
        'label' => 'Share via Gmail',
        'short_label' => 'Gmail',
        'url' => 'https://mail.google.com/mail/?view=cm&su={title}&body={url}'
    ),
    'copylink' => array(
        'label' => 'Copy link',
        'short_label' => 'Copy',
        'url' => '{url_raw}'
    ),
);


function get_share_buttons_output( $options = array() ) {
    global $share_button_services;
    global $wp;

    $output = '';
    $share_buttons_set = carbon_get_theme_option('share_buttons_set');
    $wrapper_classes = 'share-buttons';
    $btn_classes = 'btn';
    $label_key = 'label';
    $title_attr = false;

    $options = wp_parse_args(
        $options,
        get_share_buttons_output_defaults()
    );

    if ( $options['size'] == 'large' ) {
        $btn_classes .= ' btn-lg';
    } else if ( $options['size'] == 'small' ) {
        $btn_classes .= ' btn-sm';
    }

    if ( $options['label'] == 'short' ) {
        $label_key = 'short_label';
        $title_attr = true;
    }

    if ( isset($options['extra_classes']) ) {
        $wrapper_classes .= ' ' . $options['extra_classes'];
    }

    $url = home_url( add_query_arg( array(), $wp->request ) );

    // TODO: This is HTML-escaped. We’re going to be url-encoding it,
    // so we don’t want it to be HTML escaped. Find a way to get the
    // document title without the esc_html().
    $title = wp_get_document_title();

    if ( ! empty($share_buttons_set) ) {

        $output .= sprintf(
            '<div class="%s">' . "\n",
            esc_attr($wrapper_classes)
        );

        foreach ( $share_buttons_set as $i => $slug ) {
            $service = $share_button_services[ $slug ];
            $output .= sprintf(
                '<a class="%s btn-%s" href="%s" %s target="_blank">%s</a>',
                esc_attr($btn_classes),
                esc_attr($slug),
                esc_attr(
                    str_replace(
                        array(
                            '{url_raw}',
                            '{url}',
                            '{title}',
                        ),
                        array(
                            $url,
                            urlencode($url),
                            urlencode($title),
                        ),
                        $service['url'],
                    ),
                ),
                $title_attr ? 'title="' . esc_attr($service['label']) . '"' : '',
                esc_html($service[ $label_key ])
            );
        }

        $output .= '</div>' . "\n";

    }

    return $output;
}


function get_share_buttons_output_defaults() {
    return array(
        'size' => 'regular',
        'label' => 'long',
        'extra_classes' => '',
    );
}


function get_share_buttons_widget_fields( $context = 'widget' ) {
    $fields = array();

    if ( $context == 'block' ) {
        $fields[] = Field::make(
            'html',
            'placeholder_text',
            __( 'Placeholder text' )
        )->set_html(
            '<p style="font-weight: bold; margin: 0;">Share buttons</p>'
        );
    }

    $fields[] = Field::make(
        'select',
        'size',
        __( 'Button size' )
    )->set_options(
        array(
            'small' => 'Small',
            'regular' => 'Regular',
            'large' => 'Large',
        )
    )->set_default_value(
        'regular'
    );

    $fields[] = Field::make(
        'select',
        'label',
        __( 'Label length' )
    )->set_options(
        array(
            'long' => 'Long',
            'short' => 'Short',
        )
    )->set_default_value(
        'long'
    );

    return $fields;
}


function get_share_buttons_set_options() {
    global $share_button_services;
    $options = array();

    foreach ( $share_button_services as $slug => $attrs ) {
        $options[$slug] = $attrs['label'];
    }

    return $options;
}


function enqueue_share_buttons_script() {
    wp_enqueue_script(
        'share-buttons',
        get_theme_file_uri('/assets/js/share-buttons.js'),
        array('jquery'),
        null
    );
}

add_action( 'wp_enqueue_scripts', 'enqueue_share_buttons_script' );


function set_up_share_buttons_option_page() {
    Container::make(
        'theme_options',
        __( 'Share Button Settings' )
    )->set_page_parent(
        'options-general.php'
    )->add_fields(
        array(
            Field::make(
                'set',
                'share_buttons_set',
                __( 'Share Button widget should display these services:' )
            )->add_options(
                get_share_buttons_set_options()
            ),
        )
    );
}

set_up_share_buttons_option_page();

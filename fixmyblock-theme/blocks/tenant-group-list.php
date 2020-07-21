<?php

use Carbon_Fields\Block;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

function define_group_list_block() {
    Block::make(
        __( 'Tenant group list' )
    )->set_icon(
        'groups'
    )->add_fields(
        array(
            Field::make(
                'text',
                'url',
                __( 'Public Google Sheets link' )
            )->set_help_text(
                'Publish your spreadsheet by clicking “File > Publish to web > Entire Document > Web page > Publish” in Google Sheets. If your sheet includes images, you will also need to modify your sheet’s sharing settings, so that “Anyone on the internet with this link can view”.'
            )->set_attribute(
                'type',
                'url'
            ),
        )
    )->set_render_callback( 'render_group_list_block' );
}

function render_group_list_block( $fields, $attributes ) {
    if ( $fields['url'] ) {
        echo '<div class="js-tenant-group-list">';
        echo sprintf(
            '<a class="btn btn-primary placeholder" href="%s" target="_blank">Open list in a new window</a>',
            $fields['url']
        );
        get_template_part( 'templates/tenant-group-list-filters' );
        echo '<script type="text/template">';
        get_template_part( 'templates/tenant-group-list-item' );
        echo '</script>';
        echo '</div>';
    }
}

add_action( 'carbon_fields_register_fields', 'define_group_list_block' );

function enqueue_tenant_group_list_script() {
    wp_enqueue_script(
        'tenant-group-list',
        get_theme_file_uri('/assets/js/tenant-group-list.js'),
        array('jquery'),
        null
    );
}

add_action( 'wp_enqueue_scripts', 'enqueue_tenant_group_list_script' );

<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 * Registers the `group` post type.
 */
function group_init() {
    register_post_type( 'group', array(
        'labels'                => array(
            'name'                  => __( 'Groups', 'fixmyblock-theme' ),
            'singular_name'         => __( 'Group', 'fixmyblock-theme' ),
            'all_items'             => __( 'All Groups', 'fixmyblock-theme' ),
            'archives'              => __( 'Group Archives', 'fixmyblock-theme' ),
            'attributes'            => __( 'Group Attributes', 'fixmyblock-theme' ),
            'insert_into_item'      => __( 'Insert into Group', 'fixmyblock-theme' ),
            'uploaded_to_this_item' => __( 'Uploaded to this Group', 'fixmyblock-theme' ),
            'featured_image'        => _x( 'Featured Image', 'group', 'fixmyblock-theme' ),
            'set_featured_image'    => _x( 'Set featured image', 'group', 'fixmyblock-theme' ),
            'remove_featured_image' => _x( 'Remove featured image', 'group', 'fixmyblock-theme' ),
            'use_featured_image'    => _x( 'Use as featured image', 'group', 'fixmyblock-theme' ),
            'filter_items_list'     => __( 'Filter Groups list', 'fixmyblock-theme' ),
            'items_list_navigation' => __( 'Groups list navigation', 'fixmyblock-theme' ),
            'items_list'            => __( 'Groups list', 'fixmyblock-theme' ),
            'new_item'              => __( 'New Group', 'fixmyblock-theme' ),
            'add_new'               => __( 'Add New', 'fixmyblock-theme' ),
            'add_new_item'          => __( 'Add New Group', 'fixmyblock-theme' ),
            'edit_item'             => __( 'Edit Group', 'fixmyblock-theme' ),
            'view_item'             => __( 'View Group', 'fixmyblock-theme' ),
            'view_items'            => __( 'View Groups', 'fixmyblock-theme' ),
            'search_items'          => __( 'Search Groups', 'fixmyblock-theme' ),
            'not_found'             => __( 'No Groups found', 'fixmyblock-theme' ),
            'not_found_in_trash'    => __( 'No Groups found in trash', 'fixmyblock-theme' ),
            'parent_item_colon'     => __( 'Parent Group:', 'fixmyblock-theme' ),
            'menu_name'             => __( 'Groups', 'fixmyblock-theme' ),
        ),
        'public'                => true,
        'show_in_rest'          => true, # yes block editor
        'show_ui'               => true, # yes admin page
        'show_in_menu'          => true, # yes admin menu
        'show_in_nav_menus'     => true, # yes public menu
        'publicly_queryable'    => true, # yes url queries
        'query_var'             => true, # yes url queries
        'has_archive'           => true, # yes archive page
        'rewrite'               => array('slug' => 'groups', 'with_front' => false),
        'menu_position'         => 21, # position just below "Pages" in admin menu
        'hierarchical'          => false,
        'supports'              => array( 'title', 'editor', 'revisions', 'page-attributes', 'thumbnail', 'custom-fields' ),
        'menu_icon'             => 'dashicons-groups',
        'rest_base'             => 'group',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
    ) );

}
add_action( 'init', 'group_init' );

/**
 * Sets the post updated messages for the `group` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `group` post type.
 */
function group_updated_messages( $messages ) {
    global $post;

    $permalink = get_permalink( $post );

    $messages['group'] = array(
        0  => '', // Unused. Messages start at index 1.
        /* translators: %s: post permalink */
        1  => sprintf( __( 'Group updated. <a target="_blank" href="%s">View Group</a>', 'fixmyblock-theme' ), esc_url( $permalink ) ),
        2  => __( 'Custom field updated.', 'fixmyblock-theme' ),
        3  => __( 'Custom field deleted.', 'fixmyblock-theme' ),
        4  => __( 'Group updated.', 'fixmyblock-theme' ),
        /* translators: %s: date and time of the revision */
        5  => isset( $_GET['revision'] ) ? sprintf( __( 'Group restored to revision from %s', 'fixmyblock-theme' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
        /* translators: %s: post permalink */
        6  => sprintf( __( 'Group published. <a href="%s">View Group</a>', 'fixmyblock-theme' ), esc_url( $permalink ) ),
        7  => __( 'Group saved.', 'fixmyblock-theme' ),
        /* translators: %s: post permalink */
        8  => sprintf( __( 'Group submitted. <a target="_blank" href="%s">Preview Group</a>', 'fixmyblock-theme' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
        /* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
        9  => sprintf( __( 'Group scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Group</a>', 'fixmyblock-theme' ),
        date_i18n( __( 'M j, Y @ G:i', 'fixmyblock-theme' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
        /* translators: %s: post permalink */
        10 => sprintf( __( 'Group draft updated. <a target="_blank" href="%s">Preview Group</a>', 'fixmyblock-theme' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
    );

    return $messages;
}
add_filter( 'post_updated_messages', 'group_updated_messages' );

Container::make(
    'post_meta',
    'More Group Attributes'
)->where(
    'post_type', '=', 'group'
)->set_context(
    'side'
)->add_fields(
    array(
        Field::make(
            'text',
            'group_url',
            'Group URL'
        )->set_attribute(
            'pattern',
            'https?://.+'
        ),
    )
);

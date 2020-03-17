<?php

/**
 * Registers the `guide` post type.
 */
function guide_init() {
	register_post_type( 'guide', array(
		'labels'                => array(
			'name'                  => __( 'Guides', 'fmb' ),
			'singular_name'         => __( 'Guide', 'fmb' ),
			'all_items'             => __( 'All Guides', 'fmb' ),
			'archives'              => __( 'Guide Archives', 'fmb' ),
			'attributes'            => __( 'Guide Attributes', 'fmb' ),
			'insert_into_item'      => __( 'Insert into Guide', 'fmb' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Guide', 'fmb' ),
			'featured_image'        => _x( 'Featured Image', 'guide', 'fmb' ),
			'set_featured_image'    => _x( 'Set featured image', 'guide', 'fmb' ),
			'remove_featured_image' => _x( 'Remove featured image', 'guide', 'fmb' ),
			'use_featured_image'    => _x( 'Use as featured image', 'guide', 'fmb' ),
			'filter_items_list'     => __( 'Filter Guides list', 'fmb' ),
			'items_list_navigation' => __( 'Guides list navigation', 'fmb' ),
			'items_list'            => __( 'Guides list', 'fmb' ),
			'new_item'              => __( 'New Guide', 'fmb' ),
			'add_new'               => __( 'Add New', 'fmb' ),
			'add_new_item'          => __( 'Add New Guide', 'fmb' ),
			'edit_item'             => __( 'Edit Guide', 'fmb' ),
			'view_item'             => __( 'View Guide', 'fmb' ),
			'view_items'            => __( 'View Guides', 'fmb' ),
			'search_items'          => __( 'Search Guides', 'fmb' ),
			'not_found'             => __( 'No Guides found', 'fmb' ),
			'not_found_in_trash'    => __( 'No Guides found in trash', 'fmb' ),
			'parent_item_colon'     => __( 'Parent Guide:', 'fmb' ),
			'menu_name'             => __( 'Guides', 'fmb' ),
		),
		'public'                => true,
		'hierarchical'          => false,
		'taxonomies'            => array( 'category', 'post_tag' ),
		'show_ui'               => true,
		'show_in_nav_menus'     => true,
		'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes', 'revisions' ),
		'has_archive'           => true,
		'rewrite'               => array( 'slug' => 'guide' ),
		'query_var'             => true,
		'menu_position'         => 19,
		'menu_icon'             => 'dashicons-info',
		'show_in_rest'          => true,
		'rest_base'             => 'guide',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	) );

}
add_action( 'after_setup_theme', 'guide_init' );

/**
 * Sets the post updated messages for the `guide` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `guide` post type.
 */
function guide_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['guide'] = array(
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Guide updated. <a target="_blank" href="%s">View Guide</a>', 'fmb' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'fmb' ),
		3  => __( 'Custom field deleted.', 'fmb' ),
		4  => __( 'Guide updated.', 'fmb' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Guide restored to revision from %s', 'fmb' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Guide published. <a href="%s">View Guide</a>', 'fmb' ), esc_url( $permalink ) ),
		7  => __( 'Guide saved.', 'fmb' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Guide submitted. <a target="_blank" href="%s">Preview Guide</a>', 'fmb' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Guide scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Guide</a>', 'fmb' ),
		date_i18n( __( 'M j, Y @ G:i', 'fmb' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Guide draft updated. <a target="_blank" href="%s">Preview Guide</a>', 'fmb' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'guide_updated_messages' );

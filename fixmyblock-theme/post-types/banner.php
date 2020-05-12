<?php

/**
 * Registers the `banner` post type.
 */
function banner_init() {
	register_post_type( 'banner', array(
		'labels'                => array(
			'name'                  => __( 'Banners', 'fixmyblock-theme' ),
			'singular_name'         => __( 'Banner', 'fixmyblock-theme' ),
			'all_items'             => __( 'All Banners', 'fixmyblock-theme' ),
			'archives'              => __( 'Banner Archives', 'fixmyblock-theme' ),
			'attributes'            => __( 'Banner Attributes', 'fixmyblock-theme' ),
			'insert_into_item'      => __( 'Insert into Banner', 'fixmyblock-theme' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Banner', 'fixmyblock-theme' ),
			'featured_image'        => _x( 'Featured Image', 'banner', 'fixmyblock-theme' ),
			'set_featured_image'    => _x( 'Set featured image', 'banner', 'fixmyblock-theme' ),
			'remove_featured_image' => _x( 'Remove featured image', 'banner', 'fixmyblock-theme' ),
			'use_featured_image'    => _x( 'Use as featured image', 'banner', 'fixmyblock-theme' ),
			'filter_items_list'     => __( 'Filter Banners list', 'fixmyblock-theme' ),
			'items_list_navigation' => __( 'Banners list navigation', 'fixmyblock-theme' ),
			'items_list'            => __( 'Banners list', 'fixmyblock-theme' ),
			'new_item'              => __( 'New Banner', 'fixmyblock-theme' ),
			'add_new'               => __( 'Add New', 'fixmyblock-theme' ),
			'add_new_item'          => __( 'Add New Banner', 'fixmyblock-theme' ),
			'edit_item'             => __( 'Edit Banner', 'fixmyblock-theme' ),
			'view_item'             => __( 'View Banner', 'fixmyblock-theme' ),
			'view_items'            => __( 'View Banners', 'fixmyblock-theme' ),
			'search_items'          => __( 'Search Banners', 'fixmyblock-theme' ),
			'not_found'             => __( 'No Banners found', 'fixmyblock-theme' ),
			'not_found_in_trash'    => __( 'No Banners found in trash', 'fixmyblock-theme' ),
			'parent_item_colon'     => __( 'Parent Banner:', 'fixmyblock-theme' ),
			'menu_name'             => __( 'Banners', 'fixmyblock-theme' ),
		),
		'public'                => true,
		'show_in_rest'          => true, # yes block editor
		'show_ui'               => true, # yes admin page
		'show_in_menu'          => true, # yes admin menu
		'exclude_from_search'   => true, # no search results
		'publicly_queryable'    => false, # no url queries
		'query_var'             => false, # no url queries
		'show_in_nav_menus'     => false, # no public menu
		'rewrite'               => false, # no pretty urls
		'has_archive'           => false, # no archive page
		'menu_position'         => null,
		'hierarchical'          => false,
		'supports'              => array( 'title', 'editor', 'revisions', 'page-attributes' ),
		'menu_icon'             => 'dashicons-megaphone',
		'rest_base'             => 'banner',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	) );

}
add_action( 'init', 'banner_init' );

/**
 * Sets the post updated messages for the `banner` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `banner` post type.
 */
function banner_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['banner'] = array(
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Banner updated. <a target="_blank" href="%s">View Banner</a>', 'fixmyblock-theme' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'fixmyblock-theme' ),
		3  => __( 'Custom field deleted.', 'fixmyblock-theme' ),
		4  => __( 'Banner updated.', 'fixmyblock-theme' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Banner restored to revision from %s', 'fixmyblock-theme' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Banner published. <a href="%s">View Banner</a>', 'fixmyblock-theme' ), esc_url( $permalink ) ),
		7  => __( 'Banner saved.', 'fixmyblock-theme' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Banner submitted. <a target="_blank" href="%s">Preview Banner</a>', 'fixmyblock-theme' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Banner scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Banner</a>', 'fixmyblock-theme' ),
		date_i18n( __( 'M j, Y @ G:i', 'fixmyblock-theme' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Banner draft updated. <a target="_blank" href="%s">Preview Banner</a>', 'fixmyblock-theme' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'banner_updated_messages' );

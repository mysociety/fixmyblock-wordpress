<?php

function group_area_init() {
    register_taxonomy( 'group_area', array( 'group' ), array(
        'hierarchical'      => true,
        'public'            => true,
        'show_in_nav_menus' => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => true,
        'capabilities'      => array(
            'manage_terms'  => 'edit_posts',
            'edit_terms'    => 'edit_posts',
            'delete_terms'  => 'edit_posts',
            'assign_terms'  => 'edit_posts',
        ),
        'labels'            => array(
            'name'                       => __( 'Group Areas', 'fixmyblock-theme' ),
            'singular_name'              => _x( 'Group Area', 'taxonomy general name', 'fixmyblock-theme' ),
            'search_items'               => __( 'Search Group Areas', 'fixmyblock-theme' ),
            'popular_items'              => __( 'Popular Group Areas', 'fixmyblock-theme' ),
            'all_items'                  => __( 'All Group Areas', 'fixmyblock-theme' ),
            'parent_item'                => __( 'Parent Group Area', 'fixmyblock-theme' ),
            'parent_item_colon'          => __( 'Parent Group Area:', 'fixmyblock-theme' ),
            'edit_item'                  => __( 'Edit Group Area', 'fixmyblock-theme' ),
            'update_item'                => __( 'Update Group Area', 'fixmyblock-theme' ),
            'view_item'                  => __( 'View Group Area', 'fixmyblock-theme' ),
            'add_new_item'               => __( 'Add New Group Area', 'fixmyblock-theme' ),
            'new_item_name'              => __( 'New Group Area', 'fixmyblock-theme' ),
            'separate_items_with_commas' => __( 'Separate Group Areas with commas', 'fixmyblock-theme' ),
            'add_or_remove_items'        => __( 'Add or remove Group Areas', 'fixmyblock-theme' ),
            'choose_from_most_used'      => __( 'Choose from the most used Group Areas', 'fixmyblock-theme' ),
            'not_found'                  => __( 'No Group Areas found.', 'fixmyblock-theme' ),
            'no_terms'                   => __( 'No Group Areas', 'fixmyblock-theme' ),
            'menu_name'                  => __( 'Group Areas', 'fixmyblock-theme' ),
            'items_list_navigation'      => __( 'Group Areas list navigation', 'fixmyblock-theme' ),
            'items_list'                 => __( 'Group Areas list', 'fixmyblock-theme' ),
            'most_used'                  => _x( 'Most Used', 'group_area', 'fixmyblock-theme' ),
            'back_to_items'              => __( '&larr; Back to Group Areas', 'fixmyblock-theme' ),
        ),
        'show_in_rest'      => true,
        'rest_base'         => 'group_area',
        'rest_controller_class' => 'WP_REST_Terms_Controller',
    ) );

}
add_action( 'init', 'group_area_init' );


function group_area_updated_messages( $messages ) {
    $messages['group_area'] = array(
        0 => '', // Unused. Messages start at index 1.
        1 => __( 'Group Area added.', 'fixmyblock-theme' ),
        2 => __( 'Group Area deleted.', 'fixmyblock-theme' ),
        3 => __( 'Group Area updated.', 'fixmyblock-theme' ),
        4 => __( 'Group Area not added.', 'fixmyblock-theme' ),
        5 => __( 'Group Area not updated.', 'fixmyblock-theme' ),
        6 => __( 'Group Areas deleted.', 'fixmyblock-theme' ),
    );

    return $messages;
}
add_filter( 'term_updated_messages', 'group_area_updated_messages' );


// https://developer.wordpress.org/reference/functions/get_query_var/#custom-query-vars
function register_group_area_query_var( $qvars ) {
    $qvars[] = 'group_area';
    return $qvars;
}
add_filter( 'query_vars', 'register_group_area_query_var' );


// https://developer.wordpress.org/reference/classes/wp_query/#taxonomy-parameters
function handle_group_area_queries($query) {
    if ( $query->is_post_type_archive('group') && $query->is_main_query() ) {
        if ( $query->get('group_area', false) ) {

            $new_tax_clause = array(
                'taxonomy' => 'group_area',
                'field' => 'slug',
                'terms' => $query->get('group_area', ''),
            );

            $full_tax_query = $query->get('tax_query');

            if ( empty($full_tax_query) ) {
                $full_tax_query = array(
                    $new_tax_clause,
                );
            } else {
                $full_tax_query[] = $new_tax_clause;
                $full_tax_query['relation'] = 'AND';
            }

            $query->set( 'tax_query', $full_tax_query );

        }
    }
}
add_action( 'pre_get_posts', 'handle_group_area_queries' );

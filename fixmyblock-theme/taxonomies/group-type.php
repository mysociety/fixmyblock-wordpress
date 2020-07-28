<?php

function group_type_init() {
    register_taxonomy( 'group_type', array( 'group' ), array(
        'hierarchical'      => false,
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
            'name'                       => __( 'Group Types', 'fixmyblock-theme' ),
            'singular_name'              => _x( 'Group Type', 'taxonomy general name', 'fixmyblock-theme' ),
            'search_items'               => __( 'Search Group Types', 'fixmyblock-theme' ),
            'popular_items'              => __( 'Popular Group Types', 'fixmyblock-theme' ),
            'all_items'                  => __( 'All Group Types', 'fixmyblock-theme' ),
            'parent_item'                => __( 'Parent Group Type', 'fixmyblock-theme' ),
            'parent_item_colon'          => __( 'Parent Group Type:', 'fixmyblock-theme' ),
            'edit_item'                  => __( 'Edit Group Type', 'fixmyblock-theme' ),
            'update_item'                => __( 'Update Group Type', 'fixmyblock-theme' ),
            'view_item'                  => __( 'View Group Type', 'fixmyblock-theme' ),
            'add_new_item'               => __( 'Add New Group Type', 'fixmyblock-theme' ),
            'new_item_name'              => __( 'New Group Type', 'fixmyblock-theme' ),
            'separate_items_with_commas' => __( 'Separate Group Types with commas', 'fixmyblock-theme' ),
            'add_or_remove_items'        => __( 'Add or remove Group Types', 'fixmyblock-theme' ),
            'choose_from_most_used'      => __( 'Choose from the most used Group Types', 'fixmyblock-theme' ),
            'not_found'                  => __( 'No Group Types found.', 'fixmyblock-theme' ),
            'no_terms'                   => __( 'No Group Types', 'fixmyblock-theme' ),
            'menu_name'                  => __( 'Group Types', 'fixmyblock-theme' ),
            'items_list_navigation'      => __( 'Group Types list navigation', 'fixmyblock-theme' ),
            'items_list'                 => __( 'Group Types list', 'fixmyblock-theme' ),
            'most_used'                  => _x( 'Most Used', 'group_type', 'fixmyblock-theme' ),
            'back_to_items'              => __( '&larr; Back to Group Types', 'fixmyblock-theme' ),
        ),
        'show_in_rest'      => true,
        'rest_base'         => 'group_type',
        'rest_controller_class' => 'WP_REST_Terms_Controller',
    ) );

}
add_action( 'init', 'group_type_init' );


function group_type_updated_messages( $messages ) {
    $messages['group_type'] = array(
        0 => '', // Unused. Messages start at index 1.
        1 => __( 'Group Type added.', 'fixmyblock-theme' ),
        2 => __( 'Group Type deleted.', 'fixmyblock-theme' ),
        3 => __( 'Group Type updated.', 'fixmyblock-theme' ),
        4 => __( 'Group Type not added.', 'fixmyblock-theme' ),
        5 => __( 'Group Type not updated.', 'fixmyblock-theme' ),
        6 => __( 'Group Types deleted.', 'fixmyblock-theme' ),
    );

    return $messages;
}
add_filter( 'term_updated_messages', 'group_type_updated_messages' );


// https://developer.wordpress.org/reference/functions/get_query_var/#custom-query-vars
function register_group_type_query_var( $qvars ) {
    $qvars[] = 'group_type';
    return $qvars;
}
add_filter( 'query_vars', 'register_group_type_query_var' );


// https://developer.wordpress.org/reference/classes/wp_query/#taxonomy-parameters
function handle_group_type_queries($query) {
    if ( $query->is_post_type_archive('group') && $query->is_main_query() ) {
        if ( $query->get('group_type', false) ) {

            $new_tax_clause = array(
                'taxonomy' => 'group_type',
                'field' => 'slug',
                'terms' => $query->get('group_type', ''),
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
add_action( 'pre_get_posts', 'handle_group_type_queries' );

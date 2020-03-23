<?php

use Carbon_Fields\Block;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

function define_post_list_block() {
    $filtering_options = array();

    $post_types = get_post_types( array( 'public' => true ), 'object' );
    foreach( $post_types as $post_type ) {
        $filtering_options[ 'post_type:' . $post_type->name ] = 'Post type: '. $post_type->label;
    }

    $categories = get_categories( array( 'hide_empty' => false ) );
    foreach ( $categories as $category ) {
        $filtering_options[ 'category:' . $category->term_id ] = 'Category: ' . $category->name;
    }

    $tags = get_tags();
    foreach ( $tags as $tag ) {
        $filtering_options[ 'post_tag:' . $tag->term_id ] = 'Tag: ' . $tag->name;
    }

    $sort_options = array(
        0 => __( 'Date, newest first' ),
        1 => __( 'Date, oldest first' ),
        2 => __( 'Title, A-Z' ),
    );

    Block::make(
        __( 'Post list' )
    )->set_icon(
        'list-view'
    )->add_fields(
        array(
            Field::make(
                'multiselect',
                'filtering',
                __( 'List posts by' )
            )->set_options(
                $filtering_options
            ),
            Field::make(
                'text',
                'limit',
                __( 'Limit' )
            )->set_attribute(
                'pattern',
                '[0-9]*'
            )->set_default_value(
                5
            )->set_width(50),
            Field::make(
                'select',
                'order',
                __( 'Order by' )
            )->set_options(
                $sort_options
            )->set_width(50)
        )
    )->set_render_callback( 'render_post_list_block' );
}

function render_post_list_block( $fields, $attributes, $inner_blocks ) {
    $className = 'post-list';
    if ( isset($attributes['className']) ) {
        $className = $className . ' ' . $attributes['className'];
    }

    # By default, find all posts of all types.
    $query_params = array(
        'post_type' => 'any',
    );

    $filters = array(
        'post_type' => array(),
        'post_tag' => array(),
        'category' => array(),
    );

    # Split the array of post_type/post_tag/category filters into three separate arrays.
    if ( $fields['filtering'] ) {
        foreach ( $fields['filtering'] as $v ) {
            $filter = explode( ':', $v );
            $filters[ $filter[0] ][] = $filter[1];
        }
    }

    if ( $filters['post_type'] ) {
        $query_params['post_type'] = $filters['post_type'];
    }

    if ( $filters['category'] ) {
        $query_params['category'] = $filters['category'];
    }

    if ( $filters['post_tag'] ) {
        $query_params['tax_query'] = array(
            array(
                'taxonomy' => 'post_tag',
                'field' => 'term_id',
                'terms' => $filters['post_tag']
            )
        );
    }

    if ( $fields['limit'] && is_numeric($fields['limit']) ) {
        $query_params['numberposts'] = intval($fields['limit']);
    }

    if ( $fields['order'] == 2 ) {
        $query_params['order'] = 'ASC';
        $query_params['orderby'] = 'title';
    } elseif ( $fields['order'] == 1 ) {
        $query_params['order'] = 'ASC';
        $query_params['orderby'] = 'date';
    } else {
        $query_params['order'] = 'DESC';
        $query_params['orderby'] = 'date';
    }

    $results = get_posts( $query_params );

    if ( $results ) {
        echo sprintf(
            '<div class="%s">' . "\n",
            esc_attr( $className )
        );

        echo post_list( $results, array( 'show_excerpt' => true ) );

        echo '</div>' . "\n";
    }
}

add_action( 'carbon_fields_register_fields', 'define_post_list_block' );

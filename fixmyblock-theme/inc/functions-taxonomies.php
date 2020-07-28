<?php

function get_taxonomy_terms_as_html_options( $taxonomy_slug ) {
    $output = array();

    $terms = get_terms( array(
        'taxonomy' => $taxonomy_slug,
        'hide_empty' => false,
    ) );

    if ( is_taxonomy_hierarchical( $taxonomy_slug ) ) {
        $sorted_terms = array();
        sort_terms_hierarchically( $terms, $sorted_terms );
        $terms = $sorted_terms;
    }

    foreach ( $terms as $term ) {
        $output[] = get_html_option_for_term( $term, get_query_var( $taxonomy_slug ) );
    }

    return join( '\n', $output );
}


function sort_terms_hierarchically( array &$terms, array &$into, $parent_id = 0 ) {
    foreach ( $terms as $i => $term ) {
        if ( $term->parent == $parent_id ) {
            $into[$term->term_id] = $term;
            unset( $terms[ $i ] );
        }
    }

    foreach ( $into as $top_term ) {
        $top_term->children = array();
        sort_terms_hierarchically(
            $terms,
            $top_term->children,
            $top_term->term_id
        );
    }
}


function get_html_option_for_term( $term, $selected_value ) {
    $html = '';

    $ancestors_count = count(
        get_ancestors(
            $term->term_id,
            $term->taxonomy,
            'taxonomy'
        )
    );

    $html .= sprintf(
        '<option value="%s"%s>%s %s</option>',
        esc_attr( $term->slug ),
        $selected_value == $term->slug ? ' selected="selected"' : '',
        $ancestors_count ? str_repeat( '&nbsp;', $ancestors_count * 2 ) : '',
        esc_html( $term->name )
    );

    if ( isset( $term->children ) ) {
        foreach ( $term->children as $t2 ) {
            $html .= get_html_option_for_term( $t2, $selected_value );
        }
    }

    return $html;
}

<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

function get_table_of_contents_output( $options = array() ) {
    global $post;
    $output = '';

    if ( $post ) {
        $blocks = parse_blocks( $post->post_content );
        $wrapper_classes = 'table-of-contents';
        $headings = array();

        if ( isset($options['extra_classes']) ) {
            $wrapper_classes .= ' ' . $options['extra_classes'];
        }

        foreach ( $blocks as $block ) {
            if ( block_is_heading( $block ) ) {
                $headings[] = extract_heading_info( $block );
            }
        }

        if ( $headings ) {
            echo sprintf(
                '<div class="%s">' . "\n",
                $wrapper_classes
            );
            echo '<h2>Contents</h2>' . "\n";
            echo '<ol>' . "\n";
            foreach ( $headings as $heading ) {
                echo sprintf(
                    '<li><a href="#%s">%s</a></li>' . "\n",
                    $heading['id'],
                    wp_strip_all_tags( $heading['inner_html'] )
                );
            }
            echo '</ol>' . "\n";
            echo '</div>' . "\n";
        }

    } else {
        // No post object. We are probably rendering a
        // Block preview in the Editor interface.
        $output .= '(Table of contents will appear here)';
    }

    return $output;
}


function get_table_of_contents_widget_fields( $context = 'widget' ) {
    $fields = array();

    if ( $context == 'block' ) {
        $fields[] = Field::make(
            'html',
            'placeholder_text',
            __( 'Placeholder text' )
        )->set_html(
            '<p style="font-weight: bold; margin: 0;">Table of contents</p>'
        );
    }

    return $fields;
}


function block_is_heading( $block ) {
    return 'core/heading' === $block['blockName'];
}


function extract_heading_info( $block, $generate_missing_ids = true ) {
    $el = \FMB\DOM\html_element_as_array( $block['innerHTML'] );

    $inner_html = \FMB\DOM\get_inner_html( $el );

    $id = \FMB\DOM\get_element_attribute( $el, 'id' );
    if ( is_null($id) && $generate_missing_ids ) {
        $id = sanitize_title( $inner_html );
    }

    return array(
        'el' => $el,
        'id' => $id,
        'inner_html' => $inner_html,
    );
}


function add_id_child_anchors_to_headings( $block_content, $block ) {
    if ( block_is_heading( $block ) ) {
        $b = extract_heading_info( $block );
        return sprintf(
            '%s<a id="%s" class="fragment"></a>%s%s',
            \FMB\DOM\remove_attribute(
                'id',
                \FMB\DOM\get_opening_tag_html( $b['el'] )
            ),
            $b['id'],
            $b['inner_html'],
            \FMB\DOM\get_closing_tag_html( $b['el'] )
        );
    }
    return $block_content;
}

add_filter( 'render_block', 'add_id_child_anchors_to_headings', 10, 2 );

<?php

function block_is_heading( $block ) {
    return 'core/heading' === $block['blockName'];
}

function block_has_id( $block ) {
    return false !== strpos( $block['innerHTML'], 'id=' );
}

// NOTE: Assumes the HTML element in innerHTML has an id attribute!
function extract_heading_info( $block ) {
    $el = \FMB\DOM\html_element_as_array( $block['innerHTML'] );
    return array(
        'el' => $el,
        'id' => \FMB\DOM\get_element_attribute( $el, 'id' ),
        'level' => intval( substr( $el['tagName'], 1, 1 ) ),
        'inner_html' => \FMB\DOM\get_inner_html( $el ),
    );
}

function the_table_of_contents( $post = 0 ) {
    $post = get_post( $post );

    if ( $post->post_content ) {
        $blocks = parse_blocks( $post->post_content );
        $headings = array();
        $previous = false;

        foreach ( $blocks as $block ) {
            if ( block_is_heading( $block ) && block_has_id( $block ) ) {
                $headings[] = extract_heading_info( $block );
            }
        }

        if ( $headings ) {
            echo '<div class="table-of-contents">' . "\n";
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
    }
}

function move_heading_id_to_child_anchor( $block_content, $block ) {
    if ( block_is_heading( $block ) && block_has_id( $block ) ) {
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

add_filter( 'render_block', 'move_heading_id_to_child_anchor', 10, 2 );

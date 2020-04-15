<?php

function block_is_heading( $block ) {
    return 'core/heading' === $block['blockName'];
}

function block_has_id( $block ) {
    return false !== strpos( $block['innerHTML'], 'id=' );
}

function extract_heading_info( $block ) {
    $success = preg_match(
        '/<h(?<level>\d)[^>]+id="(?<id>[^"]+)">/',
        $block['innerHTML'],
        $matches
    );

    if ( $success ) {
        return array(
            'id' => $matches['id'],
            'level' => intval( $matches['level'] ),
            'text' => wp_strip_all_tags( $block['innerHTML'] ),
        );
    } else {
        return array();
    }
}

function the_table_of_contents( $post = 0 ) {
    $post = get_post( $post );

    if ( $post->post_content ) {
        $blocks = parse_blocks( $post->post_content );
        $headings = array();
        $previous = false;

        foreach ( $blocks as $block ) {
            if ( block_is_heading( $block ) && block_has_id( $block ) ) {
                // TODO: Eventually might want to nest headings by "level".
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
                    $heading['text']
                );
            }
            echo '</ol>' . "\n";
            echo '</div>' . "\n";
        }
    }
}

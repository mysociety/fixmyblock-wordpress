<?php

echo '<div class="post-list">';

if ( have_posts() ) {
    while ( have_posts() ) {
        the_post();
        echo post_list_item( $post );
    }
}

echo '</div>';

?>

<?php

// 404.php
// This template is used when WordPress recieves a request it can’t handle.
// https://developer.wordpress.org/themes/basics/template-hierarchy/

get_header();

?>

<div class="container">
    <div class="py-3 py-sm-4 py-md-5">

        <h1>Ooops! We can’t find that page</h1>
        <p>Maybe try a search?</p>
        <?php get_search_form(); ?>

    </div>
</div>

<?php

get_footer();

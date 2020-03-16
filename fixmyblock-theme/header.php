<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

    <?php wp_body_open(); ?>

    <!-- URL requested: <?php echo $GLOBALS['current_request_url']; ?> -->
    <!-- Using template: <?php echo $GLOBALS['current_theme_template']; ?> -->

    <header class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">

            <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <?php bloginfo( 'name' ); ?>
            </a>

          <?php if ( has_nav_menu( 'header' ) ) { ?>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <?php wp_nav_menu(
                    array(
                        'theme_location' => 'header',
                        'menu_class' => 'navbar-nav ml-auto',
                        'container' => false,
                        'depth' => 2,
                        'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
                        'walker' => new WP_Bootstrap_Navwalker()
                    )
                ); ?>
            </div>
          <?php } ?>

        </div>
    </header>

    <div class="site-content">
        <div class="container">

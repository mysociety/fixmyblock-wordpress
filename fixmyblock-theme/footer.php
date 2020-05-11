    <footer class="site-footer">
        <div class="container">

            <ul class="nav flex-column flex-sm-row">
                <?php wp_nav_menu( array(
                    'theme_location' => 'footer',
                    'items_wrap' => '%3$s',
                    'container' => false,
                    'depth' => 1,
                    'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
                    'walker' => new WP_Bootstrap_Navwalker()
                ) ); ?>
              <?php if ( is_user_logged_in() ) { ?>
                <li class="nav-item ml-sm-auto">
                    <a href="<?php echo wp_logout_url(get_permalink()); ?>" class="nav-link">Log out</a>
                </li>
              <?php } else { ?>
                <li class="nav-item ml-sm-auto">
                    <a href="<?php echo wp_login_url(); ?>" class="nav-link">Staff login</a>
                </li>
              <?php } ?>
            </ul>

            <?php dynamic_sidebar( 'footer-sidebar' ); ?>

        </div>
    </footer>

    <?php wp_footer(); ?>

</body>
</html>

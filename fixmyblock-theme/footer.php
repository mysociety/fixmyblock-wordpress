    <ul>
      <?php if ( is_user_logged_in() ) { ?>
        <?php $current_user = wp_get_current_user(); ?>
        <li>Logged in as <a href="<?php echo get_edit_user_link(); ?>"><?php echo $current_user->display_name; ?></a></li>
        <li><a href="<?php echo get_dashboard_url(); ?>">Dashboard</a></li>
        <li><a href="<?php echo wp_logout_url(get_permalink()); ?>">Log out</a></li>
      <?php } else { ?>
        <li><a href="<?php echo wp_login_url(); ?>">Staff login</a></li>
      <?php } ?>
    </ul>

    <?php wp_footer(); ?>

</body>
</html>

<?php

// Load Composer packages
require get_parent_theme_file_path( '/vendor/autoload.php' );

require get_parent_theme_file_path( '/inc/wp-theme-support.php' );
require get_parent_theme_file_path( '/inc/wp-fixes.php' );
require get_parent_theme_file_path( '/inc/wp-compat.php' );
require get_parent_theme_file_path( '/inc/wp-tidy.php' );
require get_parent_theme_file_path( '/inc/wp-enqueue.php' );
require get_parent_theme_file_path( '/inc/wp-image-sizes.php' );

require get_parent_theme_file_path( '/inc/carbon-fields.php' );
require get_parent_theme_file_path( '/inc/media-attribution.php' );

require get_parent_theme_file_path( '/inc/functions-general.php' );
require get_parent_theme_file_path( '/inc/functions-dom.php' );
require get_parent_theme_file_path( '/inc/functions-navbar.php' );
require get_parent_theme_file_path( '/inc/functions-sidebars.php' );
require get_parent_theme_file_path( '/inc/functions-post-list.php' );
require get_parent_theme_file_path( '/inc/functions-taxonomies.php' );
require get_parent_theme_file_path( '/inc/functions-table-of-contents.php' );
require get_parent_theme_file_path( '/inc/functions-tag-list.php' );
require get_parent_theme_file_path( '/inc/functions-share-buttons.php' );


require get_parent_theme_file_path( '/inc/layouts.php' );
require get_parent_theme_file_path( '/inc/menus.php' );
require get_parent_theme_file_path( '/inc/widgets.php' );
require get_parent_theme_file_path( '/inc/banners.php' );
require get_parent_theme_file_path( '/inc/cover-page.php' );

require get_parent_theme_file_path( '/post-types/banner.php' );
require get_parent_theme_file_path( '/post-types/group.php' );
require get_parent_theme_file_path( '/taxonomies/category.php' );
require get_parent_theme_file_path( '/taxonomies/group-area.php' );
require get_parent_theme_file_path( '/taxonomies/group-type.php' );

require get_parent_theme_file_path( '/widgets/tag-list.php' );
require get_parent_theme_file_path( '/widgets/share-buttons.php' );

require get_parent_theme_file_path( '/blocks/related-items.php' );
require get_parent_theme_file_path( '/blocks/post-list.php' );
require get_parent_theme_file_path( '/blocks/big-number.php' );
require get_parent_theme_file_path( '/blocks/tag-list.php' );
require get_parent_theme_file_path( '/blocks/share-buttons.php' );
require get_parent_theme_file_path( '/blocks/table-of-contents.php' );

<?php

// Set up the Carbon Fields library.
//
// We define a custom DIR constant, to enable Carbon Fields to work even
// when this theme is installed through a symlink.
//
// Why?
// Carbon Fields’ directory_to_url() function attempts to detect whether
// the library has been included as a Wordpress plugin or not. It checks
// the `__DIR__` PHP constant for this, but `__DIR__` isn’t symlink aware.
// If you symlink your theme into `wp-content/themes` then `__DIR__` will
// report the true location of the current file, not the one that Wordpress
// expects. The result, for Carbon Fields, is that the URLs it attempts to
// generate for admin javascript assets are incorrect, making it unusuable.
// BUT!! WordPress "get_parent_theme_file_path" to the rescue. Here we’re
// able to tell Carbon Fields exactly where Wordpress *thinks* the code is
// (at the symlink destination, rather than source) and we pass that path
// straight to Carbon Fields.
// On a server without a symlinked theme, this file path should be exactly
// the same as the output of __DIR__, but on a symlinked install, it’ll
// fix the bug, and let Carbon Fields generate the right admin asset URLs.

define( 'Carbon_Fields\DIR', get_parent_theme_file_path( 'vendor/htmlburger/carbon-fields' ) );

\Carbon_Fields\Carbon_Fields::boot();

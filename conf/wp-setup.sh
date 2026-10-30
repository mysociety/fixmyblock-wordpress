#!/bin/sh

# Run by the `wpcli` service in docker-compose.yml, to get a fresh
# WordPress install into a usable state. Safe to run more than once.

set -e

WORDPRESS_SITEURL='http://localhost:8000'
WORDPRESS_SITENAME='FixMyBlock'
WORDPRESS_ADMIN_USERNAME='admin'
WORDPRESS_ADMIN_PASSWORD='password'
WORDPRESS_ADMIN_EMAIL='admin@example.org'

cd /var/www/html

# Wait for the wordpress container to copy WordPress into the shared volume.
until [ -f wp-config.php ] && [ -f wp-includes/version.php ]; do
    echo "Waiting for WordPress files..."
    sleep 1
done

if ! wp core is-installed 2>/dev/null; then
    echo "Installing WordPress"
    wp core install --url="$WORDPRESS_SITEURL" --title="$WORDPRESS_SITENAME" --admin_user="$WORDPRESS_ADMIN_USERNAME" --admin_password="$WORDPRESS_ADMIN_PASSWORD" --admin_email="$WORDPRESS_ADMIN_EMAIL" --skip-email
    wp language core install en_GB --activate
    # (The wordpress image already includes a suitable .htaccess file.)
    wp rewrite structure '/%year%/%monthnum%/%postname%/'

    # Development plugins
    wp plugin install wp-mail-logging --activate
    wp plugin install check-email --activate
fi

wp theme activate fixmyblock-theme

# Pick up rewrite rules for the theme's custom post types and taxonomies.
wp rewrite flush

echo "WordPress is ready at $WORDPRESS_SITEURL (log in as $WORDPRESS_ADMIN_USERNAME / $WORDPRESS_ADMIN_PASSWORD)"

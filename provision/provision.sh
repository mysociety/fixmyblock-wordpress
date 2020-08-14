#!/bin/sh

export DEBIAN_FRONTEND=noninteractive

MYSQL_ROOT_USERNAME='root'
MYSQL_ROOT_PASSWORD='password'
MYSQL_WORDPRESS_USERNAME='fixmyblock'
MYSQL_WORDPRESS_PASSWORD='password'
MYSQL_WORDPRESS_DATABASE='fixmyblock'
WORDPRESS_ADMIN_USERNAME='admin'
WORDPRESS_ADMIN_PASSWORD='password'
WORDPRESS_ADMIN_EMAIL='admin@example.org'
WORDPRESS_SITEURL='localhost:8000'
WORDPRESS_SITENAME='FixMyBlock'

set_wordpress_permissions () {
    # https://codex.wordpress.org/Changing_File_Permissions
    # https://www.smashingmagazine.com/2014/05/proper-wordpress-filesystem-permissions-ownerships/
    cd /home/vagrant/wordpress
    sudo find . -exec chown www-data:www-data {} +
    sudo find . -type f -exec chmod 664 {} +
    sudo find . -type d -exec chmod 775 {} +
    sudo chmod 660 wp-config.php
}

symlink () {
    if ! [ -L "$2" ]; then
        ln -s "$1" "$2"
    fi
}

sudo_symlink () {
    if ! [ -L "$2" ]; then
        sudo ln -s "$1" "$2"
    fi
}

# Set up apt-get
install="sudo apt-get install -y"

# Add custom apt repository for PHP7
sudo add-apt-repository -y ppa:ondrej/php

# Update apt cache
sudo apt-get update

# Install Apache
$install apache2

# Activate Apache mod_rewrite
sudo_symlink /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/rewrite.load

# Install Maria DB (MySQL)
$install mariadb-server-10.1

# Set up MySQL root user
# Change the MySQL root user’s authentication method from the default (`plugin=auth_socket`)
# to a password (`plugin=mysql_native_password`), and define the password. 
# This also allows unix users other than root (eg: the vagrant user) to log in
# to the MySQL root account, which is exactly what we need.
sudo mysql -ne "UPDATE mysql.user SET plugin='mysql_native_password', Password=PASSWORD('$MYSQL_ROOT_PASSWORD') WHERE User='$MYSQL_ROOT_USERNAME';"
sudo mysql -ne "FLUSH PRIVILEGES"

# Save login details to vagrant user’s .my.cnf file, for passwordless authentication in future.
cat <<EOF > /home/vagrant/.my.cnf
[client]
user=$MYSQL_ROOT_USERNAME
password="$MYSQL_ROOT_PASSWORD"
EOF
chmod 600 /home/vagrant/.my.cnf

# And copy those login details to the root user’s home directory too,
# just in case we ever log in from inside `sudo su` or whatever.
sudo cp /home/vagrant/.my.cnf /root/.my.cnf

# Do some recommended MySQL tidying. (The stuff that secure_mysql_installation would normally do.)
# Note: no need for sudo here, because vagrant user now authenticates automatically via the .my.cnf file.
mysql -ne "DELETE FROM mysql.user WHERE User='';"
mysql -ne "DELETE FROM mysql.user WHERE User='root' AND Host NOT IN ('localhost', '127.0.0.1', '::1');"
mysql -ne "DROP DATABASE IF EXISTS test;"
mysql -ne "DELETE FROM mysql.db WHERE Db='test' OR Db='test\\_%';"
mysql -ne "FLUSH PRIVILEGES"

# Install PHP and associated modules
# https://make.wordpress.org/hosting/handbook/handbook/server-environment/#php-extensions
$install php7.4 imagemagick ghostscript libapache2-mod-php7.4 php7.4-curl php7.4-mbstring php7.4-mysqli php7.4-gd php7.4-imagick php7.4-xml php7.4-zip

# Copy php.ini file into place
sudo cp /home/vagrant/shared/provision/php.ini /etc/php/7.4/apache2/conf.d/90-vagrant.ini

# Install Git (for Go)
$install git

# Install Go (for MailHog)
# https://golang.org/dl/
# https://github.com/Varying-Vagrant-Vagrants/VVV/blob/9f128cf761e3361fcdc7fcb53b5b7217eb84b8d2/provision/provision.sh
curl -so- https://dl.google.com/go/go1.14.linux-amd64.tar.gz | tar zxf -
sudo mv go /usr/local/
mkdir -p /home/vagrant/gocode
echo >> /home/vagrant/.profile
echo "export GOROOT=/usr/local/go" >> /home/vagrant/.profile
echo "export GOPATH=/home/vagrant/gocode" >> /home/vagrant/.profile
echo "export PATH=\$GOPATH/bin:\$GOROOT/bin:\$PATH" >> /home/vagrant/.profile
. ~/.profile

# Install MailHog
# https://github.com/mailhog/MailHog/blob/master/docs/DEPLOY.md
go get github.com/mailhog/MailHog
go get github.com/mailhog/mhsendmail
sudo_symlink /home/vagrant/gocode/bin/MailHog /usr/local/bin/mailhog
sudo_symlink /home/vagrant/gocode/bin/mhsendmail /usr/local/bin/mhsendmail

# Set MailHog to start on reboot
# https://github.com/mailhog/MailHog/issues/16
sudo cp /home/vagrant/shared/provision/mailhog.service /etc/systemd/system/mailhog.service
sudo systemctl start mailhog
sudo systemctl enable mailhog

# Add us (vagrant) and to the apache user group (www-data)
sudo usermod -a -G www-data vagrant

# Download phpMyAdmin
if ! [ -e "/home/vagrant/phpmyadmin" ]; then
    cd /home/vagrant
    wget -q 'https://files.phpmyadmin.net/phpMyAdmin/5.0.1/phpMyAdmin-5.0.1-all-languages.tar.gz'
    tar zxf /home/vagrant/phpMyAdmin-5.0.1-all-languages.tar.gz
    rm /home/vagrant/phpMyAdmin-5.0.1-all-languages.tar.gz
    mv /home/vagrant/phpMyAdmin-5.0.1-all-languages /home/vagrant/phpmyadmin
fi

# Install wp-cli
if ! [ -x "$(command -v wp)" ]; then
    cd /home/vagrant
    wget -q 'https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar'
    chmod +x /home/vagrant/wp-cli.phar
    sudo_symlink /home/vagrant/wp-cli.phar /usr/local/bin/wp
    symlink /home/vagrant/shared/provision/wp-cli.yml /home/vagrant/wp-cli.yml
fi

# Create MySQL database and user for Wordpress
mysql -ne "CREATE DATABASE IF NOT EXISTS \`$MYSQL_WORDPRESS_DATABASE\`;"
mysql -ne "GRANT ALL PRIVILEGES ON \`$MYSQL_WORDPRESS_DATABASE\`.* TO '$MYSQL_WORDPRESS_USERNAME'@'localhost' IDENTIFIED BY '$MYSQL_WORDPRESS_PASSWORD';"

# Download wordpress
mkdir -p /home/vagrant/wordpress
cd /home/vagrant/wordpress
wp core download --locale=en_GB

# Set up Wordpress config file
wp config create --dbname="$MYSQL_WORDPRESS_DATABASE" --dbuser="$MYSQL_WORDPRESS_USERNAME" --dbpass="$MYSQL_WORDPRESS_PASSWORD" --locale="en_GB"
wp config set --type="constant" --raw WP_DEBUG true

# Clear database
# Doesn't do much first time round, but lets us run `vagrant provision`
# later and get the instance back to a known state.
wp db reset --yes

# Automatically complete the Wordpress setup wizard
wp core install --url="$WORDPRESS_SITEURL" --title="$WORDPRESS_SITENAME" --admin_user="$WORDPRESS_ADMIN_USERNAME" --admin_password="$WORDPRESS_ADMIN_PASSWORD" --admin_email="$WORDPRESS_ADMIN_EMAIL" --skip-email

# Set file permissions for Wordpress directory
set_wordpress_permissions

# Symlink the theme into wordpress instance
symlink /home/vagrant/shared/fixmyblock-theme /home/vagrant/wordpress/wp-content/themes/fixmyblock-theme

# Symlink web directories
sudo_symlink /home/vagrant/wordpress /var/www/wordpress
sudo_symlink /home/vagrant/phpmyadmin /var/www/phpmyadmin

# Tell Apache to listen on the right ports
sudo rm -f /etc/apache2/ports.conf
sudo_symlink /home/vagrant/shared/provision/ports.conf /etc/apache2/ports.conf

# Prevent "Could not reliably determine the server's fully qualified domain name" warnings
echo "ServerName localhost" | sudo tee /etc/apache2/conf-available/servername.conf
sudo a2enconf servername
sudo service apache2 reload

# Symlink our Apache vhost conf files
sudo_symlink /home/vagrant/shared/provision/wordpress-vhost.conf /etc/apache2/sites-available/wordpress.conf
sudo_symlink /home/vagrant/shared/provision/phpmyadmin-vhost.conf /etc/apache2/sites-available/phpmyadmin.conf

# Deactivate the default vhost, and activate our wordpress and phpmyadmin vhosts
sudo a2dissite 000-default.conf
sudo a2ensite wordpress.conf
sudo a2ensite phpmyadmin.conf

# Tell PHP to send mail via Mailhog
sudo cp /home/vagrant/shared/provision/mailhog.ini /etc/php/7.4/mods-available/mailhog.ini
sudo phpenmod mailhog

# Activate the included Wordpress theme
cd /home/vagrant/wordpress
wp theme activate fixmyblock-theme

# Install and activate required Wordpress plugins
# cd /home/vagrant/wordpress
# wp plugin install classic-editor --activate

# Development plugins
cd /home/vagrant/wordpress
wp plugin install wp-mail-logging --activate
wp plugin install check-email --activate

# Various Wordpress settings
cd /home/vagrant/wordpress
wp rewrite structure '/%year%/%monthnum%/%postname%/' --hard

# (Re)set file permissions for Wordpress directory
set_wordpress_permissions

# Finally restart/reload apache
sudo service apache2 restart

#!/bin/sh
mkdir -p wp
cd wp

wget https://wordpress.org/latest.zip
unzip ./latest.zip
cp --recursive wordpress/* ./
rm -rf wordpress
rm -f latest.zip

mkdir -p ./wp-content/plugins/
ln -s /var/www/html/src/ ./wp-content/plugins/acf-business-directory

wp config create --dbname=db --dbuser=db --dbpass=db --dbhost=db

wp config set WP_DEBUG true --raw
wp config set SCRIPT_DEBUG true --raw
wp config set WP_HOME 'https://acf-business-directory.ddev.site'
wp config set WP_SITEURL 'https://acf-business-directory.ddev.site'

# (we need to use single quotes to get the primary site URL from `.ddev/config.yaml` as variable)
wp core install --url='acf-business-directory.ddev.site' --title='New-WordPress' --admin_user=admin --admin_email=admin@example.com --prompt=admin_password

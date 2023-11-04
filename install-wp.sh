#!/bin/sh
cd wp

wget https://wordpress.org/latest.zip
unzip ./latest.zip
cp --recursive wordpress/* ./
rm -rf wordpress
rm -f latest.zip

# (we need to use single quotes to get the primary site URL from `.ddev/config.yaml` as variable)
wp core install --url='$DDEV_PRIMARY_URL' --title='New-WordPress' --admin_user=admin --admin_email=admin@example.com --prompt=admin_password
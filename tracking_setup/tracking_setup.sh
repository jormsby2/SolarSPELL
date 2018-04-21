#!/bin/bash


# variables
home_dir=/home/pi
browscap_dir_name=browscap
backup_dir_name=tracking_setup_backup
curr_date=$(date "+%m%d%Y%H%M%S")

# make backup directory
mkdir $home_dir/$backup_dir_name$curr_date

# Usage page files
mkdir /var/www/html/usage
cp ./usage/* /var/www/html/usage


# Apache
cp /etc/apache2/sites-available/000-default.conf $home_dir/$backup_dir_name$curr_date/000-default.conf.bak
cp ./apacheconfig/000-default.conf /etc/apache2/sites-available/

#Browscap
mkdir $home_dir/$browscap_dir_name
cp ./browscap/lite_php_browscap.ini $home_dir/$browscap_dir_name
cp /etc/php5/cli/php.ini $home_dir/$backup_dir_name$curr_date/php.ini.bak
cp ./browscap/php.ini /etc/php5/cli/

#SQLite / DB
mkdir /var/www/db
mkdir /var/www/scripts
cp ./sqlite/setupdb.php /var/www/scripts
cp ./scripts/parselog.php /var/www/scripts
php /var/www/scripts/setupdb.php
chmod 775 /var/www/db /var/www/db/UserData.db
chown www-data:www-data /var/www/db /var/www/db/UserData.db

#Finalize
service apache2 restart

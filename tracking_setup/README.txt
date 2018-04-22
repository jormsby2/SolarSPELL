FOLLOW THE INSTRUCTIONS BELOW IN ORDER

1. Follow instructions in setup.txt first, if you have not already done so

2. Transfer directories & files to /home/pi 

3. Run the following command:
sudo bash

 
======================================================================================================================================
======================================================================================================================================

COMMANDS FOR AUTOMATIC SETUP:
  tr -d '\r' < tracking_setup.sh > newscript.sh
  bash newscript.sh

NOTE: You must perform this step manually:
  **Crontab / Automate Parsing**
  run the following command:
      crontab -e

  append the following line to the end of the crontab file (after all the comments - lines that begin with #) to run the parsing script   every 59 minutes, then save and exit:
      */59 * * * * php /var/www/scripts/parselog.php

======================================================================================================================================
======================================================================================================================================

COMMANDS FOR MANUAL SETUP - Follow if you do not use the shell script for automatic setup.

**Usage page files**
copy files from usage folder to /var/www/html/usage (make this directory if it doesn't exist using mkdir command)
copy files from images folder to /var/www/html/images (make this directory if it doesn't exist using mkdir command)


**Apache**
1. Make a backup copy of the original 000-default.conf in /etc/apache2/sites-available/

2. Copy 000-default.conf in apacheconfig directory to /etc/apache2/sites-available/


**Browscap**
1. Copy lite_php_browscap.ini from browscap directory to /home/pi/browscap/ (make this directory if it doesn't exist using mkdir command)
*alternate/updated versions of browscap.ini can be downloaded from http://browscap.org/

Note: browscap is used to parse user-agent string

2. Make a backup copy of the original php.ini in /etc/php5/cli/

3. Copy php.ini in browscap directory to /etc/php/cli/


**SQLite / DB**
1. Run the commands in order - you will have to change the /full/path/to/file to the path where you have transferred the provided files:
(if you followed the instructions, it should be /home/pi/ )

sudo bash
mkdir /var/www/db
mkdir /var/www/scripts
cp /full/path/to/setupdb.php /var/www/scripts
cp /full/path/to/parselog.php /var/www/scripts
php /var/www/scripts/setupdb.php
chmod 775 /var/www/db /var/www/db/UserData.db
chown www-data:www-data /var/www/db /var/www/db/UserData.db

**Crontab / Automate Parsing**
  run the following command:
      crontab -e

  append the following line to the end of the crontab file (after all the comments - lines that begin with #) to run the parsing script   every 59 minutes, then save and exit:
      */59 * * * * php /var/www/scripts/parselog.php

**Finalize**
1. Restart apache with the command:
service apache2 restart


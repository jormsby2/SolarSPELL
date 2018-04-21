follow the instructions below in order

follow instructions in setup.txt first, if you have not already done so


**Crontab / Automate Parsing**
run the following command:
sudo crontab -e

append the following line to the end of the crontab file (after all the comments - lines that begin with #) to run the parsing script every 59 minutes, then save and exit:
*/59 * * * * php /var/www/scripts/parselog.php


**Automatic or Manual Setup**

*if you see error messages when running tracking_setup.sh it should still work (it's most likely because the directories it is trying to make already exist or the files it is trying to create backup copies of do not exist)

the setup can be finished automatically by running the command: sudo bash tracking_setup.sh
or manually by following the instructions below in order


**Usage page files**
copy files from usage folder to /var/www/html/usage (make this directory if it doesn't exist using mkdir command)


**Apache**
1) make a backup copy of the original 000-default.conf in /etc/apache2/sites-available/

2) copy 000-default.conf in this directory to /etc/apache2/sites-available/


**Browscap**
1) copy lite_php_browscap.ini to /home/pi/browscap/ (make this directory if it doesn't exist using mkdir command)
*alternate/updated versions of browscap.ini can be downloaded from http://browscap.org/

Note: browscap is used to parse user-agent string

2) make a backup copy of the original php.ini in /etc/php5/cli/

3) copy php.ini in this directory to /etc/php/cli/


**SQLite / DB**
run the commands in order:
sudo mkdir /var/www/db
sudo mkdir /var/www/scripts
sudo cp /full/path/to/setupdb.php /var/www/scripts
sudo cp /full/path/to/parselog.php /var/www/scripts
sudo php /var/www/scripts/setupdb.php
sudo chmod 775 /var/www/db /var/www/db/UserData.db
sudo chown www-data:www-data /var/www/db /var/www/db/UserData.db


**Finalize**
restart apache with the command:
sudo service apache2 restart


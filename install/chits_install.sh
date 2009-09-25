#!/bin/bash
if [ -z "$SUDO_USER" ]; then
    echo "$0 must be called from sudo"
    exit 1
fi
apt-get install apache2 mysql-server php5 php5-mysql openssh-server git-core wget
chmod 777 /var/www
wget -O /etc/php5/apache2/php.ini http://github.com/mikeymckay/chits/raw/master/install/php.ini.sample
/etc/init.d/apache2 restart
#no sudo
su $SUDO_USER -c "git clone git://github.com/mikeymckay/chits.git /var/www/chits"
su $SUDO_USER -c "cp /var/www/chits/modules/_dbselect.php.sample /var/www/chits/modules/_dbselect.php"
echo "CREATE DATABASE example_database;" | mysql -u root -p
mysql -u root -p example_database < /var/www/chits/db/core_data.sql
echo "INSERT INTO user SET user='example_user',password=password('example_password'),host='localhost';FLUSH PRIVILEGES;GRANT ALL PRIVILEGES ON example_database.* to example_user@localhost IDENTIFIED BY 'example_password';" | mysql -u root mysql -p


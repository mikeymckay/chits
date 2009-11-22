#!/bin/sh

# http://github.com/mikeymckay/chits/raw/master/install/mysql_replication.sh

if [ -z "$SUDO_USER" ]; then
    echo "$0 must be called from sudo. Try: 'sudo ${0}'"
    exit 1
fi

set_mysql_root_password () {
  echo "Enter the root password to setup mysql with:"
  read MYSQL_ROOT_PASSWORD
  echo "mysql-server mysql-server/root_password select ${MYSQL_ROOT_PASSWORD}" | debconf-set-selections
  echo "mysql-server mysql-server/root_password_again select ${MYSQL_ROOT_PASSWORD}" | debconf-set-selections
}

if [ ! "$MYSQL_ROOT_PASSWORD" ]; then set_mysql_root_password; fi

if [ ! "$CHITS_LIVE_PASSWORD" ]; then 
  echo "Enter password for database user chits_live:"
  read CHITS_LIVE_PASSWORD
fi

apt-get --assume-yes install apache2 mysql-server php5 php5-mysql openssh-server git-core wget ruby libxml2-dev libxslt1-dev ruby1.8-dev rdoc1.8 irb1.8 libopenssl-ruby1.8 build-essential php5-gd php5-xmlrpc php-xajax rsnapshot

# Comment out the bind address so mysql accepts non-local connections
sed -i 's/^bind-address.*127.0.0.1/#&/' /etc/mysql/my.cnf
/etc/init.d/mysql restart

chmod 777 /var/www
wget -O /etc/php5/apache2/php.ini http://github.com/mikeymckay/chits/raw/master/install/php.ini.sample
/etc/init.d/apache2 restart
#no sudo
su $SUDO_USER -c "git clone git://github.com/mikeymckay/chits.git /var/www/chits"
su $SUDO_USER -c "cp /var/www/chits/modules/_dbselect.php.sample /var/www/chits/modules/_dbselect.php"


create_database() {
  local db_name=$1
  local user_name=$2
  local user_password=$3
  echo "Creating database '${db_name}' with username '${user_name}' and password '${user_password}'"

  echo "CREATE DATABASE ${db_name};" | mysql -u root -p$MYSQL_ROOT_PASSWORD
  mysql -u root -p$MYSQL_ROOT_PASSWORD ${db_name} < /var/www/chits/db/core_data.sql
  echo "INSERT INTO user SET user='${user_name}',password=password('${user_password}'),host='localhost';
  FLUSH PRIVILEGES;
  GRANT ALL PRIVILEGES ON ${db_name}.* to ${user_name}@'%' IDENTIFIED BY '${user_password}';" | mysql -u root mysql -p$MYSQL_ROOT_PASSWORD
}

create_database "chits_development" "chits_developer" "password"
create_database "chits_live" "chits_live" "${CHITS_LIVE_PASSWORD}"
# TODO use a core DB without users
create_database "chits_testing" "chits_tester" "useless_password"

sed -i 's/^snapshot_root.*/snapshot_root\t\/var\/www\/chits\/backups\//' /etc/rsnapshot.conf
# Comment out all interval and backup lines
sed -i 's/^\(interval.*\)/#\1/' /etc/rsnapshot.conf
sed -i 's/^\(backup.*\)/#/' /etc/rsnapshot.conf
echo "
interval\tdaily\t7
interval\tweekly\t4
interval\tmonthly\t6

backup_script\t/var/www/chits/scripts/dump_database.sh\t/var/www/chits/database_dumps
"
>> /etc/rsnapshot.conf

echo "#!/bin/bash
mysqldump -u chits_live -p${CHITS_LIVE_PASSWORD} chits_live > chits_live.sql
" >> /var/www/chits/scripts/dump_database.sh
chmod +x /var/www/chits/scripts/dump_database.sh

#Setup cucumber
wget --output-document=rubygems-1.3.5.tgz http://rubyforge.org/frs/download.php/60718/rubygems-1.3.5.tgz
tar xvf rubygems-1.3.5.tgz --directory /tmp
ruby /tmp/rubygems-1.3.5/setup.rb
ln -s /usr/bin/gem1.8 /usr/bin/gem
gem sources -a http://gems.github.com
echo "Installing testing tools"
gem install cucumber mechanize rspec webrat --no-ri


cucumber /var/www/chits/features

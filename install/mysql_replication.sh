#!/bin/bash
#
# Latest version can be found here:
# http://github.com/mikeymckay/chits/raw/master/install/mysql_replication.sh
#

DATABASE_TO_REPLICATE=chits_live
DATABASE_USERNAME=chits_live

if [ -z "$SUDO_USER" ]; then
    echo "$0 must be called from sudo. Try: 'sudo ${0}'"
    exit 1
fi

echo "Checking that this script is being run from the server"
IP_ADDRESSES=`ifconfig  | awk '/inet addr/ {split ($2,A,":"); print A[2]}'`
if [[ ! $IP_ADDRESSES =~ 192.168.0.1 ]]; then
  echo "Current IP addresses: [${IP_ADDRESSES}] do not include 192.168.0.1. This script should only be run from the server"
  exit
fi
echo "Success!"

set_mysql_root_password () {
  echo "Enter the mysql root password"
  read MYSQL_ROOT_PASSWORD
}
if [ ! "$MYSQL_ROOT_PASSWORD" ]; then set_mysql_root_password; fi

echo "Checking that ${DATABASE_TO_REPLICATE} database exists"
DATABASES=`echo "SHOW DATABASES;" | mysql -u root -p$MYSQL_ROOT_PASSWORD`
if [[ ! $DATABASES =~ ${DATABASE_TO_REPLICATE} ]]; then
  echo "Current database: [${IP_ADDRESSES}] do not include '${DATABASE_TO_REPLICATE}'. The '${DATABASE_TO_REPLICATE}' database should be setup and functional before running this script."
  exit
fi
echo "Success!"

read DATABASE_USERNAME

echo "Enter ${DATABASE_TO_REPLICATE} mysql password"
read DATABASE_PASSWORD

echo "Checking that ${DATABASE_TO_REPLICATE} database exists, that password works, and that the game_user table exists"
LOGIN_RESULT=`echo "SHOW TABLES;" | mysql -u ${DATABASE_USERNAME} -p${DATABASE_PASSWORD} ${DATABASE_TO_REPLICATE}`
if [[ ! $LOGIN_RESULT =~ game_user ]]; then
  echo "Fail!"
  exit
fi
echo "Success!"

echo "Enter names of computers or current IP addresses for slaves with a comma separating them (for example: pc1,pc4,192.168.1.12):"
read SLAVE_IPS
IFS=','
SLAVE_IPS=`echo ${SLAVE_IPS} | sed 's/ //g'`

echo "Attempting to connect (via ssh) to each slave"

for slave in $SLAVE_IPS
  do
  echo "pinging $slave"
  ping -q -c 2 ${slave} > /dev/null
  if [ "$?" -ne "0" ]; then
      echo "FAIL!"
      exit
  fi
  echo "Success!"
  echo "sshing to $slave"
  su -c "ssh $slave exit" $SUDO_USER
  if [ "$?" -ne "0" ]; then
      echo "FAIL!"
      exit
  fi
  echo "Success!"
done

echo "Editing mysql configuration for replication"

# Comment out the bind address so mysql accepts non-local connections
sed -i 's/^bind-address.*127.0.0.1/#&/' /etc/mysql/my.cnf

# Append the following to /etc/mysql/my.conf
  echo "
# ----------------------------------------
# Added by tarlac mysql_replication script:
# http://github.com/mikeymckay/chits/raw/master/install/mysql_replication.sh
# ----------------------------------------
log-bin = /var/log/mysql/mysql-bin.log
binlog-do-db=${DATABASE_TO_REPLICATE}
server-id=1
# ------------------------------

" >>  /etc/mysql/my.cnf 

/etc/init.d/mysql restart

echo "GRANT REPLICATION SLAVE ON *.* TO '${DATABASE_TO_REPLICATE}'@'%' IDENTIFIED BY '${DATABASE_PASSWORD}'; 
FLUSH PRIVILEGES; 
USE ${DATABASE_TO_REPLICATE};
FLUSH TABLES WITH READ LOCK; 
SHOW MASTER STATUS;" | mysql -u root -p$MYSQL_ROOT_PASSWORD

FILE_NAME=TODO
POSITION_NUMBER=TODO

#When you issue the above command you should see a listing printed out for your sample_database. Write this information down (you will see a Position number that you will need later).
#Now you need to get tables and data from the sample_database. The method I will show you requires that the database on the Master be locked momentarily. To that end the database will be unavailable until the database is unlocked. Keep this in mind when setting this up.
## TODO http://www.ghacks.net/2009/04/09/set-up-mysql-database-replication/
#
#



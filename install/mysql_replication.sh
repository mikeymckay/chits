#!/bin/bash
#
# Latest version can be found here:
# http://github.com/mikeymckay/chits/raw/master/install/mysql_replication.sh
# Based on http://www.ghacks.net/2009/04/09/set-up-mysql-database-replication/
#

DATABASE_TO_REPLICATE=chits_live
SLAVE_USERNAME=replication_slave
SERVER_IP_ADDRESS=192.168.0.1

if [ -z "$SUDO_USER" ]; then
    echo "$0 must be called from sudo. Try: 'sudo ${0}'"
    exit 1
fi

echo "Checking that this script is being run from the server"
IP_ADDRESSES=`ifconfig  | awk '/inet addr/ {split ($2,A,":"); print A[2]}'`
if [[ ! $IP_ADDRESSES =~ $SERVER_IP_ADDRESS ]]; then
  echo "Current IP addresses: [${IP_ADDRESSES}] do not include $SERVER_IP_ADDRESS, press ctrl-c to quit or enter to go on anyways"
  read
fi
echo "Success!"

set_mysql_root_password () {
  echo "Enter the mysql root password. For this script to work the root mysql password for the master and the slaves must all be the same."
  read MYSQL_ROOT_PASSWORD
}
if [ ! "$MYSQL_ROOT_PASSWORD" ]; then set_mysql_root_password; fi

echo "Enter mysql password for user ${SLAVE_USERNAME}"
read SLAVE_PASSWORD

echo "Checking that ${DATABASE_TO_REPLICATE} database exists"
DATABASES=`echo "SHOW DATABASES;" | mysql -u root -p$MYSQL_ROOT_PASSWORD`
if [[ ! $DATABASES =~ ${DATABASE_TO_REPLICATE} ]]; then
  echo "Current database: [${IP_ADDRESSES}] do not include '${DATABASE_TO_REPLICATE}'. The '${DATABASE_TO_REPLICATE}' database should be setup and functional before running this script."
  exit
fi
echo "Success!"


echo "Checking that ${DATABASE_TO_REPLICATE} database exists, that password works, and that the game_user table exists"
LOGIN_RESULT=`echo "SHOW TABLES;" | mysql -u root -p${MYSQL_ROOT_PASSWORD} ${DATABASE_TO_REPLICATE}`
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


# Use perl to insert the following into the correct position of /etc/mysql/my.conf (DO NOT JUST APPEND)
#
SERVER_ID=1
MYSQL_CONF_ADDITIONS="
# ----------------------------------------
# Added by tarlac mysql_replication script:
# http://github.com/mikeymckay/chits/raw/master/install/mysql_replication.sh
# ----------------------------------------
# Allow connections from all addresses
bind-address = 0.0.0.0
log-bin = /var/log/mysql/mysql-bin.log
binlog-do-db=${DATABASE_TO_REPLICATE}
server-id=${SERVER_ID}
# ------------------------------
"

echo "Making backup of mysql.cnf file"
cp /etc/mysql/my.cnf /etc/mysql/my.cnf.orig
echo "Editing mysql configuration for replication"
#ruby -i -p -e "\$_.gsub!(/bind-address.*127.0.0.1/, '${MYSQL_CONF_ADDITIONS}')" /etc/mysql/my.cnf
perl -i -p -e "print '${MYSQL_CONF_ADDITIONS}',$_='' if \$_ =~ /bind-address.*127.0.0.1/)" /etc/mysql/my.cnf

/etc/init.d/mysql restart

MASTER_STATUS=`echo "GRANT REPLICATION SLAVE ON *.* TO '${SLAVE_USERNAME}'@'%' IDENTIFIED BY '${SLAVE_PASSWORD}'; 
FLUSH PRIVILEGES; 
USE ${DATABASE_TO_REPLICATE};
FLUSH TABLES WITH READ LOCK; 
SHOW MASTER STATUS;" | mysql -u root -p$MYSQL_ROOT_PASSWORD`

echo "MASTER_STATUS: $MASTER_STATUS"
export MASTER_STATUS

MASTER_LOG_FILE=`echo $MASTER_STATUS | ruby -n -e 'puts $1 if $_.match(/(mysql-bin.\d+)\t/)'`
MASTER_LOG_POSITION=`echo $MASTER_STATUS | ruby -n -e 'puts $1 if $_.match(/\t(\d+)\t/)'`

echo "MASTER_LOG_FILE: $MASTER_LOG_FILE"
echo "MASTER_LOG_POSITION: $MASTER_LOG_POSITION"

echo "UNLOCK TABLES;" | mysql -u root -p$MYSQL_ROOT_PASSWORD


SLAVE_MYSQL_CONFIG="
[mysqld]
# ----------------------------------------
# Added by tarlac mysql_replication script:
# http://github.com/mikeymckay/chits/raw/master/install/mysql_replication.sh
# ----------------------------------------
server-id=$SERVER_ID
master-host=$SERVER_IP_ADDRESS
master-user=$SLAVE_USERNAME
master-password=$SLAVE_PASSWORD
master-connect-retry=60
replicate-do-db=$DATABASE_TO_REPLICATE
# ----------------------------------------
"

SLAVE_MYSQL_SETUP_COMMANDS="
CREATE DATABASE ${DATABASE_TO_REPLICATE};
LOAD DATA FROM MASTER;
SLAVE STOP;
CHANGE MASTER TO MASTER_HOST='$SERVER_IP_ADDRESS', MASTER_USER='$SLAVE_USERNAME', MASTER_PASSWORD='$SLAVE_PASSWORD', MASTER_LOG_FILE='$MASTER_LOG_FILE', MASTER_LOG_POS=$MASTER_LOG_POSITION; 
START SLAVE;
"

# Look for the [mysqld] section and insert the new configuration there
EDIT_SLAVE_MYSQL_CONFIGURATION="perl -i -p -e 'print \"${SLAVE_MYSQL_CONFIG}\",\$_=\"\" if \$_ =~ /\[mysqld\]/' /etc/mysql/my.cnf"

for slave in $SLAVE_IPS
  do
    echo "Editing the mysql configuration on $slave"
    ssh $slave "${EDIT_SLAVE_MYSQL_CONFIGURATION}"
    ssh $slave "echo \'${SLAVE_MYSQL_SETUP_COMMANDS}\' | mysql -u root -p$MYSQL_ROOT_PASSWORD"
done

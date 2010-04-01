#!/bin/bash
#
# Latest version can be found here:
# http://github.com/mikeymckay/chits/raw/master/install/mysql_replication.sh
# Based on http://www.ghacks.net/2009/04/09/set-up-mysql-database-replication/
#

DATABASE_TO_REPLICATE=chits_live
SLAVE_USERNAME=replication_user
#SERVER_IP_ADDRESS=192.168.2.2
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

echo "Enter mysql password for user ${SLAVE_USERNAME} (this user will be created)"
read SLAVE_PASSWORD

echo "Checking that ${DATABASE_TO_REPLICATE} database exists"
DATABASES=`echo "SHOW DATABASES;" | mysql -u root -p$MYSQL_ROOT_PASSWORD`
if [[ ! $DATABASES =~ ${DATABASE_TO_REPLICATE} ]]; then
  echo "Current databases: [${DATABASES}] do not include '${DATABASE_TO_REPLICATE}'. The '${DATABASE_TO_REPLICATE}' database should be setup and functional before running this script."
  exit
fi
echo "Success!"


echo "Checking that the game_user table exists"
LOGIN_RESULT=`echo "SHOW TABLES;" | mysql -u root -p${MYSQL_ROOT_PASSWORD} ${DATABASE_TO_REPLICATE}`
if [[ ! $LOGIN_RESULT =~ game_user ]]; then
  echo "Fail!"
  exit
fi
echo "Success!"

echo "Enter names of computers or current IP addresses for slaves with a comma separating them (for example: pc1,pc4,192.168.1.12):"
read SLAVE_IPS
IFS=','
# This was here to handle spaces, but seems to break things
#SLAVE_IPS=`echo ${SLAVE_IPS} | sed 's/ //g'`

echo "Checking that we can ssh in and that mysql is running"

for slave in $SLAVE_IPS
  do
  echo "pinging $slave"
  ping -q -c 2 ${slave} > /dev/null
  if [ "$?" -ne "0" ]; then
      echo "FAIL, is your network setup? Are all of the machines connected?"
      exit
  fi
  echo "Success!"
  echo "sshing to $slave"
  su -c "ssh $slave exit" $SUDO_USER
  if [ "$?" -ne "0" ]; then
      echo "FAIL, on $slave you must apt-get install openssh-server"
      exit
  fi
  echo "Success!"
  echo "Checking for mysqld on $slave"
  su -c "ssh $slave pgrep mysqld" $SUDO_USER
  if [ "$?" -ne "0" ]; then
      echo "FAIL, on $slave you must apt-get install mysql-server"
      exit
  fi
  echo "Success!"
done

echo "Creating a new my.cnf file on the server, original one is at /etc/mysql/my.cnf.orig"
if [ ! -e "my.cnf.master" ]; then
  echo "my.cnf.master file is missing from the current directory, please run from the same directory as my.cnf.master"
  exit
fi
mv /etc/mysql/my.cnf /etc/mysql/my.cnf.orig
cp my.cnf.master /etc/mysql/my.cnf

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

echo "
CREATE DATABASE ${DATABASE_TO_REPLICATE};
LOAD DATA FROM MASTER;
SLAVE STOP;
CHANGE MASTER TO MASTER_HOST='$SERVER_IP_ADDRESS', MASTER_USER='$SLAVE_USERNAME', MASTER_PASSWORD='$SLAVE_PASSWORD', MASTER_LOG_FILE='$MASTER_LOG_FILE', MASTER_LOG_POS=$MASTER_LOG_POSITION; 
START SLAVE;
" > /tmp/slave_setup.mysql

for slave in $SLAVE_IPS
  do
    echo "Overwriting the mysql configuration on $slave"
    echo "When prompted enter the password for $SUDO_USER on $slave (it will echo to the screen)"
    su -c "scp my.cnf.slave $slave:" $SUDO_USER
    su -c "ssh $slave \"sudo -S cp my.cnf.slave /etc/mysql/my.cnf; sudo /etc/init.d/mysql restart\"" $SUDO_USER
    su -c "scp /tmp/slave_setup.mysql $slave:" $SUDO_USER
    su -c "ssh $slave \"cat slave_setup.mysql | mysql -u root -p$SLAVE_PASSWORD\"" $SUDO_USER
done

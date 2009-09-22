# How to install chits

Assuming a fresh install of ubuntu, these are the steps required to get chits up and running. Extra steps should be taken to make this stuff secure. A script to automate this will be coming soon. All of the lines that look like code are meant to be executed as is on the command line. Just copy and paste the entire line to your terminal window.

#A. Setting up necessary softwares (Apache, MySQL ,PHP)

Install web server, programming language, secure shell server and a code management tool. You will be prompted for your root password. Later you will be asked to create a root password for mysql in a blue screen - remember what you choose you will need it below (it can be empty if you are not going to put real data into your database))

    sudo apt-get install apache2 mysql-server php5 php5-mysql openssh-server git-core

Download the latest and greatest and most stable chits

    cd /var/www
    chmod 777 .
    git clone git://github.com/alisonperez/chits.git 

#B. Configuring php.ini, httpd.conf, mysql

Download and overwrite your existing php.ini

    sudo wget -O /etc/php5/apache2/php.ini http://github.com/mikeymckay/chits/raw/master/install/php.ini.sample

Setup the database - you will need the mysql password you setup earlier. Create, populate and setup the users:

    echo "CREATE DATABASE example_database;" | mysql -u root -p
    mysql -u root -p example_database < /var/www/chits/db/core_data.sql
    echo "INSERT INTO user SET user='example_user',password=password('example_password'),host='localhost';FLUSH PRIVILEGES;GRANT ALL PRIVILEGES ON example_database.* to example_user@localhost IDENTIFIED BY 'example_password';" | mysql -u root mysql -p

#C. Configuring chits config file

    cp chits/modules/_dbselect.php.sample chits/modules/_dbselect.php

#D. Test it
(restart apache2 maybe - hopefully not)

Access chits in the browser thru the URL: http://localhost/chits/

Login using 'admin' and password 'admin'

Assuming a fresh install of ubuntu:

#A. Setting up necessary softwares (Apache, MySQL , PHP)

3. sudo apt-get install apache2 mysql-server php5 php5-mysql openssh-server git-core
	you will be prompted for root password in a blue screen - remember what you choose you will need it below (it can be empty if you are not going to put real data into your database)

cd /var/www
chmod 777 .
git clone git://github.com/alisonperez/chits.git 

#C. Configuring php.ini, httpd.conf, mysql

1. sudo gedit /etc/php5/apache2/php.ini
   Locate the following parameters and assign the following values:

- register_globals -> On
- memory_limit -> 128MB (for linux just use M not MB ie. 128M instead of 128MB)
- session.auto_start -> 1
- session.save_path -> /var/tmp
- upload_max_filesize -> 20M (for linux this is "upload_max_filesize")
- post_max_size -> 128 M

3. Setup the database - you will need the mysql password you setup earlier

    a. create a database called 'example_database':
        echo "CREATE DATABASE example_database;" | mysql -u root -p

    b. Populate chits_example_database
        mysql -u root -p example_database < /var/www/chits/db/core_data.sql
	
    e. login to Mysql again using root account 
        echo "INSERT INTO user SET user='example_user',password=password('example_password'),host='localhost';FLUSH PRIVILEGES;GRANT ALL PRIVILEGES ON example_database.* to example_user@localhost IDENTIFIED BY 'example_password';" | mysql -u root mysql -p

#D. Configuring CHITS config file

cp chits/modules/_dbselect.php.sample chits/modules/_dbselect.php

#E. Test it

    d. Access CHITS in the browser thru the URL: http://localhost/chits/
    e. Login using 'admin' and password 'admin'

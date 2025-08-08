#!/bin/bash

mysql_install_db --user=mysql --datadir=/var/lib/mysql > /dev/null

mysqld --user=mysql --datadir=/var/lib/mysql --skip-networking &

PID=$!

until mysqladmin ping -u root --password=laravel > /dev/null 2>&1;
  do sleep 1;
done;

mysql -u root --password=laravel -e "CREATE DATABASE IF NOT EXISTS laravel;"
mysql -u root --password=laravel -e "CREATE USER 'root'@'%' IDENTIFIED BY 'laravel';"
mysql -u root --password=laravel -e "GRANT ALL PRIVILEGES ON laravel.* TO 'root'@'%';"
mysql -u root --password=laravel -e "FLUSH PRIVILEGES;"

kill $PID;
wait $PID;

mysqld --user=mysql --datadir=/var/lib/mysql
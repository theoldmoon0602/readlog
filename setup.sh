#!/bin/bash

if [ $# -ge 1 ] && [ $1 = "clean" ]; then
	rm database.db
	exit
fi

echo "
create table users (
	username text,
	password_hash text
);
"|sqlite3 database.db 

echo -n "username:"
read username
echo -n "password:"
read password

php -r "\$pdo = new PDO('sqlite:database.db');\$stmt=\$pdo->prepare('insert into users(username, password_hash) values (?, ?)');\$stmt->execute(['$username', password_hash('$password', PASSWORD_DEFAULT)]);"



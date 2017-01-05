#!/bin/bash

if [ $# -ge 1 ] && [ $1 = "clean" ]; then
	rm database.db
	exit
fi

if [ $# -ge 1 ] && [ $1 = "addbook" ]; then
	echo -n "book title:"
	read booktitle
	echo -n "book author:"
	read bookauthor
	echo -n "book price:"
	read bookprice
	echo -n "book user:"
	read bookuser

	echo "insert into books(username, title, author, price, created_at) values ('$bookuser', '$booktitle', '$bookauthor', $bookprice, datetime('now', '+09:00:00'));	" | sqlite3 database.db

	exit
fi

cat schema.sql | sqlite3 database.db 

echo -n "username:"
read username
echo -n "password:"
read password

php -r "\$pdo = new PDO('sqlite:database.db');\$stmt=\$pdo->prepare('insert into users(username, password_hash) values (?, ?)');\$stmt->execute(['$username', password_hash('$password', PASSWORD_DEFAULT)]);"



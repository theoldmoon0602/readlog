create table users (
	username text unique,
	password_hash text
);

create table books (
	username text,
	title text,
	author text,
	price int,
	created_at text
);

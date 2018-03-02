CREATE DATABASE IF NOT EXISTS buildit;
CREATE USER IF NOT EXISTS 'admin'@'localhost' IDENTIFIED BY 'password';
GRANT USAGE ON *.* TO 'admin'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON buildit.* TO admin@localhost;
FLUSH PRIVILEGES;

USE buildit;

CREATE TABLE IF NOT EXISTS users (
	userID	int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	firstName	text NOT NULL,
	lastName	text NOT NULL,
	commonName	text,
	joinDate	datetime NOT NULL,
	location	text,
	email	text NOT NULL
);
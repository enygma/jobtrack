-- init.sql

-- CREATE DATABASE `jobtrack`;
-- GRANT ALL ON jobtrack.* to 'jobtrack'@'localhost' IDENTIFIED BY 'jt42';
-- FLUSH privileges;

CREATE TABLE `records` (
	full_name VARCHAR(200),
	email VARCHAR(200),
	location VARCHAR(200),
	relocate VARCHAR(1),
	created_at INT,
	updated_at INT,
	ID INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(ID)
);

CREATE TABLE `tags` (
	record_email VARCHAR(200),
	tag VARCHAR(200),
	ID INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(ID)	
);

CREATE TABLE `position` (
	title VARCHAR(200),
	location VARCHAR(200),
	summary TEXT,
	contact_name VARCHAR(200),
	contact_email VARCHAR(200),
	contact_phone VARCHAR(200),
	created_at INT,
	updated_at INT,
	ID INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(ID)
);

-- CREATE TABLE `applicant` (
-- 	first_name VARCHAR(200),
-- 	last_name VARCHAR(200),
-- 	email_address VARCHAR(200)
-- );
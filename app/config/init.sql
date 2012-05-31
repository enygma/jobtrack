-- init.sql

-- CREATE DATABASE `jobtrack`;
-- GRANT ALL ON jobtrack.* to 'jobtrack'@'localhost' IDENTIFIED BY 'jt42';
-- FLUSH privileges;

CREATE TABLE `records` (
	full_name VARCHAR(200),
	ID INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(ID)
);
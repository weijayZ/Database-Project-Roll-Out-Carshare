DROP DATABASE IF EXISTS gExpress;
CREATE DATABASE gExpress;
CREATE TABLE products(
  idNum INT,
  pName VARCHAR(255),
  pType VARCHAR(255),
  pCategory VARCHAR(255),
  pCalories INT,
  pPrice INT
);

CREATE TABLE customer(
  cID INT,
  fName VARCHAR(255),
  lName VARCHAR(255),
  age INT,
  species VARCHAR(255),
  fleetID VARCHAR(255),
  fleetPassword VARCHAR(255),
  location INT,
  username VARCHAR(255),
  password VARCHAR(255)

);

INSERT INTO products
VALUES(1,'Takoyaki', 'Japanese', 'Appetitizer', 200, 250),
(2,'Takoyaki', 'Japanese', 'Appetitizer', 200, 250),
(3,'Takoyaki', 'Japanese', 'Appetitizer', 200, 250),
(4,'Takoyaki', 'Japanese', 'Appetitizer', 200, 250),
(5,'Takoyaki', 'Japanese', 'Appetitizer', 200, 250),
(6,'Takoyaki', 'Japanese', 'Appetitizer', 200, 250),
(7,'Takoyaki', 'Japanese', 'Appetitizer', 200, 250),
(8,'Takoyaki', 'Japanese', 'Appetitizer', 200, 250),
(9,'Takoyaki', 'Japanese', 'Appetitizer', 200, 250),
(10,'Takoyaki', 'Japanese', 'Appetitizer', 200, 100),
(11,'Takoyaki', 'Japanese', 'Appetitizer', 200,250),
(12,'Takoyaki', 'Japanese', 'Appetitizer', 200,250),
(13,'Takoyaki', 'Japanese', 'Appetitizer', 200,250),
(14,'Takoyaki', 'Japanese', 'Appetitizer', 200,250),
(15,'Takoyaki', 'Japanese', 'Appetitizer', 200,250)

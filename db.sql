
CREATE DATABASE IF NOT EXISTS us_bank;
USE us_bank;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  fullname VARCHAR(100),
  email VARCHAR(100),
  phone VARCHAR(20),
  username VARCHAR(50),
  password TEXT,
  account_number VARCHAR(20),
  balance FLOAT DEFAULT 0,
  currency VARCHAR(10) DEFAULT 'USD'
);

CREATE TABLE transfers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  sender_account VARCHAR(20),
  receiver_account VARCHAR(20),
  amount FLOAT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (fullname, email, phone, username, password, account_number, balance, currency)
VALUES ('Admin', 'godswilluzoma517@gmail.com', '0000000000', 'admin', 
  '$2y$10$eImG6ZqLl5Df8JXMZBKmweW4YFzQrKjjN/5sV7oPOhK5GpAbqUOE2', '1000000001', 100000, 'USD');

INSERT INTO users (fullname, email, phone, username, password, account_number, balance, currency)
VALUES ('Anna Kenska', 'keniol9822@op.pl', '0000000001', 'annakenska', 
  '$2y$10$eImG6ZqLl5Df8JXMZBKmweW4YFzQrKjjN/5sV7oPOhK5GpAbqUOE2', '1000000002', 30000, 'PLN');

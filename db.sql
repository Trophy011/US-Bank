CREATE DATABASE IF NOT EXISTS us_bank;
USE us_bank;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  fullname VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  phone VARCHAR(20),
  username VARCHAR(50) UNIQUE,
  password VARCHAR(255),
  account_number VARCHAR(20) UNIQUE,
  balance DECIMAL(12,2) DEFAULT 1000.00
);

CREATE TABLE transfers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  sender_account VARCHAR(20),
  receiver_account VARCHAR(20),
  amount DECIMAL(12,2),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

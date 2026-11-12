CREATE DATABASE IF NOT EXISTS campuscare CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE campuscare;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('student','staff','admin') NOT NULL DEFAULT 'student',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(60) NOT NULL
);

CREATE TABLE locations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL
);

CREATE TABLE item_reports (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  type ENUM('lost','found') NOT NULL,
  title VARCHAR(120) NOT NULL,
  description TEXT NOT NULL,
  category_id INT NOT NULL,
  location_id INT NOT NULL,
  date_event DATE NOT NULL,
  photo_path VARCHAR(255) NULL,
  status ENUM('open','matched','claimed','closed') DEFAULT 'open',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (category_id) REFERENCES categories(id),
  FOREIGN KEY (location_id) REFERENCES locations(id)
);

CREATE TABLE status_history (
  id INT AUTO_INCREMENT PRIMARY KEY,
  report_id INT NOT NULL,
  old_status VARCHAR(20),
  new_status VARCHAR(20) NOT NULL,
  changed_by INT NOT NULL,
  changed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (report_id) REFERENCES item_reports(id),
  FOREIGN KEY (changed_by) REFERENCES users(id)
);

-- Fictional starter data only
INSERT INTO categories (name) VALUES
 ('Electronics'),('Books and Notes'),('Clothing'),('Keys and Cards'),('Bags'),('Other');
INSERT INTO locations (name) VALUES
 ('Main Library'),('Computer Lab 1'),('Cafeteria'),('Lecture Hall A'),('Entrance Gate'),('Other');

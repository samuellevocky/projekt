CREATE TABLE books (
id INT AUTO_INCREMENT PRIMARY KEY,
title VARCHAR(255),
author VARCHAR(255),
year INT,
available BOOLEAN DEFAULT 1 );

INSERT INTO books (title, author, year, available)
VALUES
('1984', 'George Orwell', 1949, 1),
('Harry Potter', 'J.K Rowling', 1997, 1);
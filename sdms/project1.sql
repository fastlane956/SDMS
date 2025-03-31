CREATE DATABASE sdms;

USE sdms;

-- Student table
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    roll_no VARCHAR(50) UNIQUE,
    department VARCHAR(100),
    grade VARCHAR(10),
    password VARCHAR(255)
);

-- Teacher table
CREATE TABLE teachers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    department VARCHAR(100),
    password VARCHAR(255)
);

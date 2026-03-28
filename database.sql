CREATE DATABASE attendance_db;
USE attendance_db;

CREATE TABLE branches (
    id INT PRIMARY KEY AUTO_INCREMENT,
    branch_name VARCHAR(100),
    branch_logo VARCHAR(255)
);

CREATE TABLE employees (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100),
    branch_id INT,
    salary_type ENUM('salary_only', 'salary_bonus'),
    FOREIGN KEY (branch_id) REFERENCES branches(id)
);
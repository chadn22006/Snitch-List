-- Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS records;
USE records;

-- Create the `people` table
CREATE TABLE IF NOT EXISTS people (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(20) NOT NULL,
    age INT NOT NULL,
    city VARCHAR(20) NOT NULL,
    state VARCHAR(2) NOT NULL,
    zip VARCHAR(10) NOT NULL,
    why TEXT NOT NULL,
    other TEXT NOT NULL,
    spicture VARCHAR(255)
);

-- Create the `files` table
CREATE TABLE IF NOT EXISTS files (
    id INT AUTO_INCREMENT PRIMARY KEY,
    person_id INT,
    file_path VARCHAR(255),
    original_name VARCHAR(255),
    FOREIGN KEY (person_id) REFERENCES people(id) ON DELETE CASCADE
);

-- Export SQL for Employee Management Database

-- Drop existing tables to avoid conflicts during import
DROP TABLE IF EXISTS Employees;
DROP TABLE IF EXISTS Departments;

-- Create table for Departments
CREATE TABLE Departments (
                             id_department INT AUTO_INCREMENT PRIMARY KEY,
                             name VARCHAR(100) NOT NULL UNIQUE,
                             created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                             updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create table for Employees
CREATE TABLE Employees (
                           id INT AUTO_INCREMENT PRIMARY KEY,
                           name VARCHAR(100) NOT NULL,
                           email VARCHAR(100) NOT NULL UNIQUE,
                           department INT NOT NULL,
                           created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                           updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                           FOREIGN KEY (department) REFERENCES Departments(id_department) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- Insert sample data into Departments
INSERT INTO Departments (name) VALUES
                                   ('Human Resources'),
                                   ('Finance'),
                                   ('IT'),


-- Insert sample data into Employees
INSERT INTO Employees (name, email, department) VALUES
                                                    ('Alice Smith', 'john@john.com', 1),
                                                    ('Bob Johnson', 'megan@megan.com', 2),

-- Query to display data
SELECT * FROM Departments;
SELECT * FROM Employees;

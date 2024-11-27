-- Export SQL - Employee Management Database

-- Créer la db
CREATE DATABASE EmployeeDB
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;
-- Utiliser la base de données créée
USE EmployeeDB;

-- CREATION TABLE DEPARTEMENTS
CREATE TABLE Departments (
                             id_department INT AUTO_INCREMENT PRIMARY KEY,
                             name VARCHAR(100) NOT NULL UNIQUE,
                             created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                             updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- CREATION TABLE EMPLOYES
CREATE TABLE Employees (
                           id INT AUTO_INCREMENT PRIMARY KEY,
                           name VARCHAR(100) NOT NULL,
                           email VARCHAR(100) NOT NULL UNIQUE,
                           department INT NOT NULL,
                           created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                           updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                           FOREIGN KEY (department) REFERENCES Departments(id_department) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- MOCK DE DEPARTEMENTS FICTIFS
INSERT INTO Departments (name) VALUES
                                   ('HR'),
                                   ('Finance'),



-- MOCK DEMPLOYEES FICTIFS
INSERT INTO Employees (name, email, department) VALUES
                                                    ('Alice Smith', 'john@john.com', 1),
                                                    ('Bob Johnson', 'megan@megan.com', 2),

-- CHECKER LES DONNEES
SELECT * FROM Departments;
SELECT * FROM Employees;

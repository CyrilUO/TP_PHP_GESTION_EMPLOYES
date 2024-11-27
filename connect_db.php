<?php
$host = 'localhost';
$db = 'EmployeeDB';
$user = 'root';
$pass = 'root';
$charset = 'utf8mb4';
$databaseDsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
try {
    $bdd = new PDO($databaseDsn, $user, $pass, $options);
} catch (Exception $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

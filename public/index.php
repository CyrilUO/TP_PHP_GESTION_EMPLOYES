<?php
include __DIR__ . '/../config/connect_db.php';

try {


    $totalEmployeesQuery = $bdd->query("SELECT COUNT(*) AS employee_amount FROM Employees");
    $totalEmployees = $totalEmployeesQuery->fetchColumn();

    // Nombre total de départements
    $totalDepartmentsQuery = $bdd->query("SELECT COUNT(*) AS departments_amount FROM Departments");
    $totalDepartments = $totalDepartmentsQuery->fetchColumn();

    // On recherche le département avec le plus grand nombre d'employés
    $topDepartmentQuery = $bdd->query(
        "SELECT Departments.name AS department_name, COUNT(Employees.id) AS employees_amount
         FROM Departments
         LEFT JOIN Employees ON Departments.id_department = Employees.department
         GROUP BY Departments.id_department
         ORDER BY employees_amount DESC
         LIMIT 1"
    );
    $topDepartment = $topDepartmentQuery->fetch();
} catch (Exception $e) {
    die("Erreur lors de la récupération des statistiques : " . $e->getMessage());
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Employés</title>
    <link rel="stylesheet" href="/public/styles.css"> <!-- Chemin absolu à partir de public -->
</head>
<body>
<header>
    <h1>Bienvenue dans le Système de Gestion des Employés</h1>
</header>
<nav>



    <h2>Accédez aux fonctionnalités :</h2>
    <ul>
        <a href="/employee/add_employee.php">Ajouter un Employé</a>
        <br><br>
        <a href="/employee/list_employees.php">Liste des Employés</a>
        <br><br>
        <a href="/department/add_department.php">Ajouter un département</a>
        <br><br>
        <a href="/department/department_list.php">Liste des departments</a>




    </ul>
</nav>

<main style="padding: 1rem">
    <section class="stats-container">
        <div class="stat-card">
            <h2>Nombre d'employés</h2>
            <p><?= htmlspecialchars($totalEmployees); ?></p>
        </div>
        <div class="stat-card">
            <h2>Nombre de Départements</h2>
            <p><?= htmlspecialchars($totalDepartments); ?></p>
        </div>
        <div class="stat-card">
            <h2>Departement avec le plus d'employés</h2>
            <p><?= htmlspecialchars($topDepartment['department_name']); ?> (<?= htmlspecialchars($topDepartment['employees_amount']); ?> employés)</p>
        </div>
    </section>
</main>
</body>
</html>

<?php
include __DIR__ . '/../config/connect_db.php';

// Explication de la jointure : on joint les tables Departments et Employees (raw data de Departements mais si aucun employé n'y fait partie)
// La jointure relie la clé primaire id_department (Departments) à la clef étrangère départment (Employees)
// On regroupe les results par ID de départements
try {
    $query = $bdd->query(
        "SELECT 
            Departments.id_department AS department_id,
            Departments.name AS department_name,
            COUNT(Employees.id) AS total_employees
         FROM 
            Departments
         LEFT JOIN 
            Employees
         ON 
            Departments.id_department = Employees.department
         GROUP BY 
            Departments.id_department
        ORDER BY 
            total_employees DESC"
    );
    $departments = $query->fetchAll();
} catch (Exception $e) {
    die("Erreur lors de la récupération des données : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Départements</title>
    <link rel="stylesheet" href="../public/styles.css">
</head>
<body>
<header>
    <h1>Liste des Départements</h1>
</header>
<main>
    <?php if (empty($departments)): ?>
        <p class="alert alert-danger">Aucun département trouvé.</p>
    <?php else: ?>
        <table class="table">
            <thead>
            <tr>
                <th>ID du Département</th>
                <th>Nom du Département</th>
                <th>Nombre Total d'Employés</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($departments as $department): ?>
                <tr>
                    <td><?= htmlspecialchars($department['department_id']); ?></td>
                    <td><?= htmlspecialchars($department['department_name']); ?></td>
                    <td><?= htmlspecialchars($department['total_employees']); ?></td>
                    <td>
                        <a href="edit_department.php?id=<?= $department['department_id']; ?>">Modifier</a>
                        <a href="delete_department.php?id=<?= $department['department_id']; ?>"
                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce département ?');">Supprimer</a>

                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    <p style="text-align: center">
        <a href="../public/index.php">Retour au Menu Principal</a>
    </p>
</main>
</body>
</html>

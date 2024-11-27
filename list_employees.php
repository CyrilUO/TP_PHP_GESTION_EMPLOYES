<?php
include __DIR__ . '/connect_db.php';

// Pagination : récupérer la page et calculer l'offset
$page = isset($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$limit = 5;
$offset = ($page - 1) * $limit;

try {
    // Récupération des employés avec une requête paginée
    $query = $bdd->prepare(
        "SELECT Employees.id, Employees.name, Employees.email, Departments.name AS department
         FROM Employees
         INNER JOIN Departments ON Employees.department = Departments.id_department
         LIMIT :limit OFFSET :offset"
    );
    $query->bindValue(':limit', $limit, PDO::PARAM_INT);
    $query->bindValue(':offset', $offset, PDO::PARAM_INT);
    $query->execute();
    $employees = $query->fetchAll();

    // Récupération du nombre total d'employés pour la pagination
    $totalEmployeesQuery = $bdd->query("SELECT COUNT(*) FROM Employees");
    $totalEmployees = $totalEmployeesQuery->fetchColumn();
    $totalPages = ceil($totalEmployees / $limit);

} catch (Exception $e) {
    die("Erreur lors de la récupération des données : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Employés</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <h1>Liste des Employés</h1>
</header>
<main>
    <?php if (empty($employees)): ?>
        <p class="alert alert-danger">Aucun employé trouvé.</p>
    <?php else: ?>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Département</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($employees as $employee): ?>
                <tr>
                    <td><?= htmlspecialchars($employee['id']); ?></td>
                    <td><?= htmlspecialchars($employee['name']); ?></td>
                    <td><?= htmlspecialchars($employee['email']); ?></td>
                    <td><?= htmlspecialchars($employee['department']); ?></td>
                    <td>
                        <a href="edit_employee.php?id=<?= $employee['id']; ?>">Modifier</a>
                        <a href="delete_employee.php?id=<?= $employee['id']; ?>"
                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet employé ?');">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    <nav>
        <?php if ($page > 1): ?>
            <a href="list_employees.php?page=<?= $page - 1; ?>">Précédent</a>
        <?php endif; ?>
        <?php if ($page < $totalPages): ?>
            <a href="list_employees.php?page=<?= $page + 1; ?>">Suivant</a>
        <?php endif; ?>
        <a href="index.php">Menu Principal</a>
    </nav>
</main>
</body>
</html>

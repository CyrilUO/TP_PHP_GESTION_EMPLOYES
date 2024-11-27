<?php
include __DIR__ . '/config/connect_db.php';

if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $employeeId = (int)$_GET['id'];
} else {
    echo "<p class='alert alert-danger'>ID d'employé invalide.</p>";
    exit;
}

// Récupérer les informations de l'employé
$query = $bdd->prepare(
    "SELECT Employees.id, Employees.name, Employees.email, Employees.department
     FROM Employees
     WHERE Employees.id = :id"
);
$query->execute([':id' => $employeeId]);
$employee = $query->fetch();
if (!$employee) {
    echo "<p class='alert alert-danger'>Employé introuvable.</p>";
    exit;
}

// Charger la liste des départements
$departmentsQuery = $bdd->query("SELECT id_department, name FROM Departments");
$departments = $departmentsQuery->fetchAll();

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $department = $_POST['department'];

    // Validation des données
    $errors = [];
    if (empty($name)) {
        $errors[] = "Le nom complet est obligatoire.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'email est invalide.";
    }
    if (empty($department) || !ctype_digit($department)) {
        $errors[] = "Le département sélectionné est invalide.";
    }

    // Mise à jour des données si aucune erreur
    if (empty($errors)) {
        try {
            $updateQuery = $bdd->prepare(
                "UPDATE Employees
                 SET name = :name, email = :email, department = :department
                 WHERE id = :id"
            );
            $updateQuery->execute([
                ':name' => $name,
                ':email' => $email,
                ':department' => $department,
                ':id' => $employeeId
            ]);
            $successMessage = "Les informations de l'employé ont été mises à jour avec succès.";
        } catch (Exception $e) {
            $errors[] = "Erreur lors de la mise à jour : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Employé</title>
    <link rel="stylesheet" href="../public/styles.css">
</head>
<body>
<header>
    <h1>Modifier l'Employé</h1>
</header>
<main>
    <?php if (!empty($successMessage)): ?>
        <p class="alert alert-success"><?= htmlspecialchars($successMessage); ?></p>
    <?php endif; ?>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form action="edit_employee.php?id=<?= $employeeId ?>" method="post">
        <label for="name">Nom complet :</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($employee['name']) ?>" required>
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($employee['email']) ?>" required>
        <label for="department">Département :</label>
        <select id="department" name="department" required>
            <?php foreach ($departments as $department): ?>
                <option value="<?= $department['id_department'] ?>"
                    <?= $department['id_department'] == $employee['department'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($department['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Enregistrer les modifications</button>
    </form>
    <p><a href="list_employees.php">Retour à la liste des employés</a></p>
</main>
</body>

</html>


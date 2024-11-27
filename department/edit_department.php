<?php
include __DIR__ . '/../config/connect_db.php';

// Vérification de l'ID du département
if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $departmentId = (int)$_GET['id'];
} else {
    echo "<p class='alert alert-danger'>ID de département invalide.</p>";
    exit;
}

// Récupérer les informations du département matchant avec l'id en bdd
$query = $bdd->prepare(
    "SELECT id_department, name 
     FROM Departments 
     WHERE id_department = :id"
);
$query->execute([':id' => $departmentId]);
$department = $query->fetch();

if (!$department) {
    echo "<p class='alert alert-danger'>Département introuvable.</p>";
    exit;
}

// Traitement du formulaire via la reqete POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);

    // Validation des données
    $errors = [];
    if (empty($name)) {
        $errors[] = "Le nom du département est obligatoire.";
    } elseif (strlen($name) > 50) {
        $errors[] = "Le nom du département ne doit pas dépasser 50 caractères.";
    }

    // Mise à jour des données si aucune erreur UPDATE TABLE <nom table> + SET nom entré + CONDITION via Where
    if (empty($errors)) {
        try {
            $updateQuery = $bdd->prepare(
                "UPDATE Departments
                 SET name = :name
                 WHERE id_department = :id"
            );
            $updateQuery->execute([
                ':name' => $name,
                ':id' => $departmentId
            ]);
            $successMessage = "Les informations du département ont été mises à jour avec succès.";
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
    <title>Modifier un Département</title>
    <link rel="stylesheet" href="../public/styles.css">
</head>
<body>
<header>
    <h1>Modifier un Département</h1>
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

    <form action="../department/edit_department.php?id=<?= $departmentId ?>" method="post">
        <label for="name">Nom du département :</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($department['name']) ?>" required>
        <div style="text-align: center"><button type="submit">Enregistrer les modifications</button></div>
    </form>

    <p style="text-align: center"><a href="../department/department_list.php">Retour à la liste des départements</a></p>
</main>
</body>
</html>

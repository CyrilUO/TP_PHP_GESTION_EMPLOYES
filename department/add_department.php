<?php
include __DIR__ . '/../config/connect_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $departmentName = trim($_POST['name']); // Récupérer le nom du département

    // Valider les données
    $errors = [];
    if (empty($departmentName)) {
        $errors[] = "Le nom du département est obligatoire.";
    } elseif (strlen($departmentName) > 20) { // Vérification de la longueur maximale
        $errors[] = "Le nom du département ne doit pas dépasser 50 caractères.";
    }

    // Si aucune erreur, insérer le département
    if (empty($errors)) {
        try {
            // Requête d'insertion
            $query = $bdd->prepare(
                "INSERT INTO Departments (name) VALUES (:name)"
            );
            $query->execute([
                ':name' => $departmentName
            ]);
            $successMessage = "Département ajouté avec succès !";
        } catch (Exception $e) {
            $errors[] = "Erreur lors de l'ajout du département : " . $e->getMessage();
        }
    }
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Département</title>
    <link rel="stylesheet" href="../public/styles.css">
</head>
<body>
<h1 style="text-align: center;">Ajouter un Nouveau Département</h1>

<!-- Affichage des messages de succès ou d'erreur -->
<?php if (!empty($successMessage)): ?>
    <p class="alert alert-success" style="text-align: center;"><?= htmlspecialchars($successMessage); ?></p>
<?php endif; ?>
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger" style="text-align: center;">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!-- Formulaire pour ajouter un département -->
<form action="add_department.php" method="post" style="text-align: center;">
    <label for="name">Nom du Département :</label>
    <input type="text" id="name" name="name" required>
    <br><br>
    <button type="submit">Ajouter le Département</button>

<!-- Lien vers la liste des départements -->
<p style="text-align: center;">
    <a href="department_list.php">Voir la liste des départements</a>
</p>
</form>
</body>
</html>

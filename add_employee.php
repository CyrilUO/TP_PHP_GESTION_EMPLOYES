<?php
include __DIR__ . '/connect_db.php';

$query = $bdd->query("SELECT id_department, name FROM Departments");
$departments = $query->fetchAll();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $department = $_POST['department'];
    // Valider les données
    $errors = []; // Tableau pour stocker les erreurs
    if (empty($name)) { // Valider le nom complet
        $errors[] = "Le nom complet est obligatoire.";
    } elseif (strlen($name) > 50) {
        $errors[] = "Le nom complet ne doit pas dépasser 50 caractères.";
    }
    if (empty($email)) { // Valider l'email
        $errors[] = "L'email est obligatoire.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'email n'est pas valide.";
    }
    if (empty($department)) { // Valider le département
        $errors[] = "Le département est obligatoire.";
    } elseif (!ctype_digit($department)) {
        $errors[] = "Le département sélectionné est invalide.";
    }
    // Afficher les erreurs ou insérer les données
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    } else {
        try {
            // Insérer l'employé
            $query = $bdd->prepare(
                "INSERT INTO Employees (name, email, department)
 VALUES (:name, :email, :department)"
            );
            $query->execute([
                ':name' => $name,
                ':email' => $email,
                ':department' => $department
            ]);
            $successMessage = "Employé ajouté avec succès !";
        } catch (Exception $e) {
            $errorMessages[] = "Erreur lors de l'ajout de l'employé : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Employé</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h1 style="text-align: center;">Ajouter un Nouvel Employé</h1>
<form action="add_employee.php" method="post">
    <!-- Nom complet -->
    <label for="name">Nom complet :</label>
    <input type="text" id="name" name="name" required>
    <br><br>
    <!-- Email -->
    <label for="email">Email :</label>
    <input type="email" id="email" name="email" required>
    <br><br>
    <!-- Département -->
    <label for="department">Département :</label>
    <select id="department" name="department" required>
        <option value="" disabled selected>Choisissez un département</option>
        <?php foreach ($departments as $department): ?>
            <option value="<?= $department['id_department']; ?>">
                <?= htmlspecialchars($department['name']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>
    <!-- Bouton soumettre -->
    <button type="submit">Ajouter l'Employé</button>
    <?php if (!empty($successMessage)): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($successMessage); ?>
        </div>
    <?php endif; ?>
    <nav>
        <a style="display: block" href="list_employees.php">Liste des employés</a>
    </nav>

    <?php if (!empty($errorMessages)): ?>
        <div class="alert alert-danger">
            <p>
                <?php foreach ($errorMessages as $error): ?>
                    <li><?= htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </p>
        </div>
    <?php endif; ?>

</form>
</body>
</html>

<?php
include __DIR__ . '/../config/connect_db.php';

// Vérification de l'ID passé via GET
if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $departmentId = (int)$_GET['id'];
} else {
    echo "<p class='alert alert-danger'>ID de département invalide.</p>";
    exit;
}

try {
    // Vérification si le département contient des employés
    $query = $bdd->prepare(
        "SELECT COUNT(*) FROM Employees WHERE department = :department_id"
    );
    $query->execute([':department_id' => $departmentId]);
    $employeeCount = $query->fetchColumn();

    if ($employeeCount > 0) {
        echo "
        <!DOCTYPE html>
        <html lang='fr'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <link rel='stylesheet' href='../public/styles.css'>
            <title>Erreur de Suppression</title>
        </head>
        <body>
            <div class='error-container'>
                <h1 class='error-title'>Impossible de Supprimer le Département</h1>
                <p class='error-message'>Le département contient encore <strong>{$employeeCount} employés</strong> et ne peut pas être supprimé.</p>
                <p class='error-action'>
                    <a href='department_list.php' class='btn-return'>Retour à la Liste des Départements</a>
                </p>
            </div>
        </body>
        </html>
        ";
        exit;
    }

    // Suppression du département
    $deleteQuery = $bdd->prepare(
        "DELETE FROM Departments WHERE id_department = :id"
    );
    $deleteQuery->execute([':id' => $departmentId]);

    echo " <!DOCTYPE html>
        <html lang='fr'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <link rel='stylesheet' href='../public/styles.css'>
            <title>Erreur de Suppression</title>
        </head>
        <body>
            <div class='succes-container'>
                <h1 style='text-align: center'>Département supprimé !</h1>
                
                <p class='alert alert-success'>Le département avec l'ID ${departmentId} a été supprimé avec succès.</p>
                <p style='text-align: center'><a href='department_list.php' class='btn-return'>Retour à la Liste des Départements</a></p>
            </div>
        </body>
        </html>";
    exit;

} catch (Exception $e) {
    echo "<p class='alert alert-danger'>Erreur lors de la suppression : " . $e->getMessage() . "</p>";
}

// Redirection vers la liste des départements
header('Location: department_list.php');
exit;
?>


<p class='alert alert-success'>Le département avec l'ID ${departmentId} a été supprimé avec succès.</p>
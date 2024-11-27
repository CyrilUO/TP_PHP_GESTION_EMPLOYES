<?php

include __DIR__ . '/../config/connect_db.php';

// Vérification de l'ID
if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $employeeId = (int)$_GET['id'];
} else {
    echo "<p class='alert alert-danger'>ID d'employé invalide.</p>";
    exit;
}
// Vérification de l'existence de l'employé
$query = $bdd->prepare("SELECT COUNT(*) FROM Employees WHERE id = :id");
$query->execute([':id' => $employeeId]);
$employeeExists = $query->fetchColumn();
if (!$employeeExists) {
    echo "<p class='alert alert-danger'>Employé introuvable.</p>";
    exit;
}
// Suppression de l'employé
try {
    $deleteQuery = $bdd->prepare("DELETE FROM Employees WHERE id = :id");
    $deleteQuery->execute([':id' => $employeeId]);
    echo "<p class='alert alert-success'>L'employé a l'id ${employeeId} été supprimé avec succès.</p>";
} catch (Exception $e) {
    echo "<p class='alert alert-danger'>Erreur lors de la suppression : " . $e->getMessage() . "</p>";
    exit;
}
// Redirection vers la liste des employés
header('Location: /../employee/list_employees.php');
exit;

?>
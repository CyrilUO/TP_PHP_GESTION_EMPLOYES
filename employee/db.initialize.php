<?php
include __DIR__ . '/employee/db.initialize.php';

try {
    // Démarrer une transaction
    $bdd->beginTransaction();

    // Insertion des départements
    $departments = [
        ['name' => 'IT'],
        ['name' => 'Finance'],
        ['name' => 'HR']
    ];
    $query = $bdd->prepare("INSERT INTO Departments (name) VALUES (:name)");
    foreach ($departments as $department) {
        $query->execute([':name' => $department['name']]);
    }

    // Insertion des employés
    $employees = [
        ['firstname' => 'Alice', 'lastname' => 'Dupont', 'department' => 2],
        ['firstname' => 'Bob', 'lastname' => 'Martin', 'department' => 1],
        ['firstname' => 'Claire', 'lastname' => 'Leroy', 'department' => 3],
        ['firstname' => 'David', 'lastname' => 'Moreau', 'department' => 1],
        ['firstname' => 'Eve', 'lastname' => 'Durant', 'department' => 2]
    ];
    $query = $bdd->prepare("INSERT INTO Employees (name, email, department) VALUES (:name, :email, :department)");
    foreach ($employees as $employee) {
        $name = $employee['firstname'] . ' ' . $employee['lastname'];
        $email = strtolower($employee['firstname'] . '.' . $employee['lastname'] . '@example.com');
        $query->execute([
            ':name' => $name,
            ':email' => $email,
            ':department' => $employee['department']
        ]);
    }

    // Valider la transaction
    $bdd->commit();
    echo "Données insérées avec succès !";
} catch (Exception $e) {
    // Annuler la transaction en cas d'erreur
    $bdd->rollback();
    echo "Erreur : " . $e->getMessage();
}
?>

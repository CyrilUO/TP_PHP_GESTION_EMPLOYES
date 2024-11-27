# 🌟 Simple gestion des employées en PHP

> Simple application construite en PHP pour la gestion des employés et des départements. Opération CRUD + statistiques.

> S'inscrit dans un contexte d'aide au projet de fin d'étude 2ème année BTS (GSB)
---

## 📋 Ce qu'on trouve dans ce projet

- **Gestion des employés**
    - Ajout, suppression, modification des employés d'une liste.
    - Recherche des employés par nom de département.

- **Gestion des départements**
    - Voir, créer, éditer, supprimer les départements.
    - Les départements ayant des employés ne peuvent être supprimés.

- **Panneau Statistiques**
    - Vue du nombre d'employé, des départements où se trouvent le plus d'employés.

- **Recherche des utilisateurs et départements**
  - La partie de recherche est à faire, elle n'a pas été implémentée

---

## 🛠️ Tech Stack

- **Backend**: PHP (PDO)
- **Database**: MySQL
- **Frontend**: HTML5, CSS3 
- **Tools**: phpMyAdmin, Intellij, Git

---

## 🚀 Démarrage

### 1. Cloner le repos

```bash
git clone https://github.com/CyrilUO/TP_PHP_GESTION_EMPLOYES.git
cd TP_glb
```
### 2. Configurer le fichier connect_db.php
```bash
$host = 'localhost';
$db = 'EmployeeDB'; // Nom de votre BDD 
$user = 'root';
$pass = 'root';
```
### 3. Lancer l'app
```bash
Ouvrez le projet en allant utilisant XAMPP, MAMP ou WAMP 

Naviguez vers http://localhost/TP_glb/public/index.php 
```






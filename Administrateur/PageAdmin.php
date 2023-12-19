<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_role = $_SESSION['user_role'];

if ($user_role != 1) {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../style/style.css">
    <title>Page Admin</title>
</head>

<body>
    <h2>Bienvenue sur la page Admin</h2>

    <ul>
        <li><a href="../index.php">Accueil</a></li>
        <li><a href="AjouterProduit.php">Ajouter un Produit</a></li>
        <li><a href="manage_users.php">Liste des Utilisateurs</a></li>
        <li><a href="../Authentification/logout.php">Déconnexion</a></li>
    </ul>
</body>

</html>

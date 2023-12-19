<?php
require_once('../Db/database.php');

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Authentification/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../style/style.css">
    <title>Changer le mot de passe</title>
</head>

<body>
    <h2>Changer le mot de passe</h2>
    <form action="../functions/FonctionsChangerMdp.php" method="post">
        <label for="current_password">Mot de passe actuel :</label>
        <input type="password" name="current_password">
        <br>
        <label for="new_password">Nouveau mot de passe :</label>
        <input type="password" name="new_password">
        <br>
        <label for="confirm_new_password">Confirmer le nouveau mot de passe :</label>
        <input type="password" name="confirm_new_password">
        <br>
        <input type="submit" value="Changer le mot de passe">
        <a href="../index.php">Accueil</a>
        <?php
        if (isset($_GET['error'])) {
            $error = $_GET['error'];
            echo "<p class='error'>$error</p>";
        }
        ?>
    </form>
</body>

</html>

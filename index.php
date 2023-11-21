<?php
session_start();
if (isset($_SESSION['username'])) {
    header('Location: profil.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
</head>
<body>
    <h1>Bienvenue sur notre site</h1>
    <p><a href="signup.php">S'inscrire</a></p>
    <p><a href="login.php">Se connecter</a></p>
</body>
</html>

<?php
session_start();
if (isset($_SESSION['username'])) {
    header('Location: profil.php');
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    header('Location: profil.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <h1>Connexion</h1>
    <form action="login.php" method="post">
        <label for="username">Nom d'utilisateur:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <input type="submit" value="Se connecter">
    </form>
</body>
</html>

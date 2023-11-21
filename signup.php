<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hachage du mot de passe

//valider user name minimum 2 max 50 + not in DB
//valider pwd et autres champs du signup


    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    <h1>Inscription</h1>
    <form action="signup.php" method="post">
        <label for="username">Nom d'utilisateur:</label>
        <input type="text" id="username" name="username" required>
        <!-- message d'erreur  -->
        <br>
        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <input type="submit" value="S'inscrire">
    </form>
</body>
</html>

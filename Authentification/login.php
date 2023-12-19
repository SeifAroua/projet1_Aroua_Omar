<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../style/style.css">
    <title>Login</title>
</head>

<body>
    <h2>Login</h2>
    <form action="../functions/FonctionsLogin.php" method="post">
        <label for="user_name">Nom d'utilisateur :</label>
        <input type="text" name="user_name">
        <br>
        <label for="pwd">Mot de passe :</label>
        <input type="password" name="pwd">
        <br>
        <input type="submit" value="Se connecter">
    </form>
    <a href="../index.php">Accueil</a>

    <?php
    if (isset($_GET['error'])) {
        $error = $_GET['error'];
        echo "<p class='error'>$error</p>";
    }
    ?>
</body>

</html>

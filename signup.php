<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./style/style.css">
    <title>Inscription Utilisateur</title>
</head>

<body>
    <h2>Inscription Utilisateur</h2>
    <form action="./functions/FonctionsSignUp.php" method="post">
        <label for="user_name">Nom d'utilisateur :</label>
        <input type="text" name="user_name">
        <br>
        <label for="email">Email :</label>
        <input type="email" name="email">
        <br>
        <label for="pwd">Mot de passe :</label>
        <input type="password" name="pwd">
        <br>
        <label for="street_name">Nom de la Rue :</label>
        <input type="text" name="street_name">
        <br>
        <label for="street_nb">Numéro de Rue :</label>
        <input type="text" name="street_nb">
        <br>
        <label for="city">Ville :</label>
        <input type="text" name="city">
        <br>
        <label for="province">Province :</label>
        <input type="text" name="province">
        <br>
        <label for="zip_code">Code Postal :</label>
        <input type="text" name="zip_code">
        <br>
        <label for="country">Pays :</label>
        <input type="text" name="country">
        <br>
        <input type="submit" value="S'inscrire">
        <a href="index.php">Accueil</a>

        <?php
        if (isset($_GET['error'])) {
            $error = $_GET['error'];
            echo "<p style='color:red'>$error</p>";
        }
        ?>
    </form>
</body>

</html>

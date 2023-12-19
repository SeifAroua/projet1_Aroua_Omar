<?php
require_once('../Db/database.php');

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Authentification/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM `user` WHERE `id` = $user_id";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../style/style.css">
    <title>Profil Utilisateur</title>
</head>

<body>
    <h2>Profil Utilisateur</h2>
    <form action="../functions/FonctionsUpdateProfil.php" method="post" enctype="multipart/form-data">
        <label for="user_name">Nom d'utilisateur :</label>
        <input type="text" name="user_name" value="<?php echo $user['user_name']; ?>" readonly>
        <br>
        <label for="email">Email :</label>
        <input type="email" name="email" value="<?php echo $user['email']; ?>">
        <br>
        <label for="fname">Prénom :</label>
        <input type="text" name="fname" value="<?php echo $user['fname']; ?>">
        <br>
        <label for="lname">Nom de famille :</label>
        <input type="text" name="lname" value="<?php echo $user['lname']; ?>">
        <br>
        <input type="submit" value="Enregistrer">
        <?php
        if (isset($_GET['error'])) {
            $error = $_GET['error'];
            echo "<p class='error'>$error</p>";
        }
        ?>
    </form>
    <a href="../index.php">Accueil</a>
    <br>    
    <a href="../functions/FonctionsChangerMdp.php">Changer le mot de passe</a>
    <br>
    <a href="../Authentification/logout.php">Se déconnecter</a>
    
</body>

</html>

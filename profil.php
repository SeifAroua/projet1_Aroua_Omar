<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
</head>
<body>
    <h1>Bienvenue, <?php echo $_SESSION['username']; ?>!</h1>
    <p><a href="logout.php">Se déconnecter</a></p>
</body>
</html>

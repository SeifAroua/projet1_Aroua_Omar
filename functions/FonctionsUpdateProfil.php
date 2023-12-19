<?php
require_once('../Db/database.php');

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../Authentification/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];

    $user_name = $_POST['user_name'];
    $email = $_POST['email'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];

    if (empty($user_name) || empty($email) || empty($fname) || empty($lname)) {
        $error_message = "Tous les champs doivent être remplis.";
        header("Location: ../pages/Profile.php?error=$error_message");
        exit();
    }

    $sql = "UPDATE `user` 
            SET `user_name` = '$user_name', `email` = '$email', `fname` = '$fname', `lname` = '$lname' 
            WHERE `id` = $user_id";

    if (mysqli_query($conn, $sql)) {
        header("Location: ../pages/Profile.php");
    } else {
        $error_message = "Erreur lors de la mise à jour du profil : " . mysqli_error($conn);
        header("Location: ../pages/Profile.php?error=$error_message");
        exit();
    }
} else {
    echo "Accès non autorisé";
}

mysqli_close($conn);
?>

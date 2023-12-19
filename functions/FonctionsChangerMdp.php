<?php
require_once('../Db/database.php');
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../Authentification/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];

    if (empty($current_password) || empty($new_password) || empty($confirm_new_password)) {
        $error_message = "Tous les champs sont obligatoires, veuillez remplir le ou les champs vides.";
        header("Location: ../Authentification/ChangerMdp.php?error=$error_message");
        exit();
    }

    $sql = "SELECT `pwd` FROM `user` WHERE `id` = $user_id";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if (password_verify($current_password, $user['pwd'])) {
        if ($new_password === $confirm_new_password) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_sql = "UPDATE `user` SET `pwd` = '$hashed_password' WHERE `id` = $user_id";
            mysqli_query($conn, $update_sql);

            header("Location: ../pages/Profile.php");
            exit();
        } else {
            $error_message = "Les nouveaux mots de passe ne correspondent pas.";
            header("Location: ../Authentification/ChangerMdp.php?error=$error_message");
            exit();
        }
    } else {
        $error_message = "Le mot de passe actuel est incorrect.";
        header("Location: ../Authentification/ChangerMdp.php?error=$error_message");
        exit();
    }
}
?>

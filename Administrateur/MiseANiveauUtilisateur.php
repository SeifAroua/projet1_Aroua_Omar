<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Authentification/login.php");
    exit();
}

$user_role = $_SESSION['user_role'];

if ($user_role != 1) {
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    require_once('../Db/database.php');

    $update_query = "UPDATE `user` SET `role_id` = 2 WHERE `id` = $user_id";
    $result = mysqli_query($conn, $update_query);

    if ($result) {
        header("Location: PageAdmin.php");
    } else {
        echo "Erreur lors de la mise à jour du rôle de l'utilisateur. Veuillez réessayer plus tard.";
    }

    mysqli_close($conn);
} else {
    echo "ID d'utilisateur non fourni. Veuillez spécifier un utilisateur à mettre à jour.";
}
?>

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

    $delete_query = "DELETE FROM `user` WHERE `id` = $user_id";

    $result = mysqli_query($conn, $delete_query);

    if ($result) {
        header("Location: PageAdmin.php");
    } else {
        echo "Une erreur s'est produite lors de la suppression de l'utilisateur. Veuillez réessayer plus tard.";
    }

    mysqli_close($conn);
} else {
    echo "L'ID de l'utilisateur n'a pas été fourni.";
}
?>

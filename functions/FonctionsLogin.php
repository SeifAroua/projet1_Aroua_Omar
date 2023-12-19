<?php
require_once('../Db/database.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_name = $_POST['user_name'];
    $password = $_POST['pwd'];

    $sql = "SELECT * FROM `user` WHERE `user_name` = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $user_name);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        $user = mysqli_fetch_assoc($result);

        if ($user && password_verify($password, $user['pwd'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role_id'];

            if ($user['role_id'] == 1) {
                header("Location: ../Administrateur/PageAdmin.php");
            } else {
                header("Location: ../pages/Profile.php");
            }
            exit();
        } else {
            header("Location: ../Authentification/login.php?error=Nom d'utilisateur ou mot de passe incorrect");
            exit();
        }
    } else {
        header("Location: ../Authentification/login.php?error=Erreur de la base de données");
        exit();
    }
} else {
    header("Location: ../Authentification/login.php?error=Accès non autorisé");
    exit();
}

mysqli_close($conn);
?>

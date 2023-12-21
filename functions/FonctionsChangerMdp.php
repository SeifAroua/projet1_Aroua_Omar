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

    // Utilisation d'une requête préparée pour éviter l'injection SQL
    $sql_select_password = "SELECT `pwd` FROM `user` WHERE `id` = ?";
    $stmt_select_password = mysqli_prepare($conn, $sql_select_password);

    // Liaison des paramètres
    mysqli_stmt_bind_param($stmt_select_password, 'i', $user_id);

    // Exécution de la requête préparée
    mysqli_stmt_execute($stmt_select_password);

    // Récupération du résultat
    $result_select_password = mysqli_stmt_get_result($stmt_select_password);
    $user = mysqli_fetch_assoc($result_select_password);

    // Vérification du mot de passe actuel
    if (password_verify($current_password, $user['pwd'])) {
        if ($new_password === $confirm_new_password) {
            // Hachage du nouveau mot de passe
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Utilisation d'une requête préparée pour l'UPDATE
            $sql_update_password = "UPDATE `user` SET `pwd` = ? WHERE `id` = ?";
            $stmt_update_password = mysqli_prepare($conn, $sql_update_password);

            // Liaison des paramètres
            mysqli_stmt_bind_param($stmt_update_password, 'si', $hashed_password, $user_id);

            // Exécution de la requête préparée pour l'UPDATE
            mysqli_stmt_execute($stmt_update_password);

            // Redirection vers la page de profil
            header("Location: ../pages/Profile.php");
            exit();
        } else {
            // Les nouveaux mots de passe ne correspondent pas
            $error_message = "Les nouveaux mots de passe ne correspondent pas.";
            header("Location: ../Authentification/ChangerMdp.php?error=$error_message");
            exit();
        }
    } else {
        // Le mot de passe actuel est incorrect
        $error_message = "Le mot de passe actuel est incorrect.";
        header("Location: ../Authentification/ChangerMdp.php?error=$error_message");
        exit();
    }

    // Fermeture des déclarations préparées
    mysqli_stmt_close($stmt_select_password);
    mysqli_stmt_close($stmt_update_password);
}
?>

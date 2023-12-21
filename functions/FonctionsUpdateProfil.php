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

    // Utiliser une déclaration préparée pour mettre à jour les informations de l'utilisateur
    $sql = "UPDATE `user` 
            SET `user_name` = ?, `email` = ?, `fname` = ?, `lname` = ? 
            WHERE `id` = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ssssi', $user_name, $email, $fname, $lname, $user_id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../pages/Profile.php");
    } else {
        $error_message = "Erreur lors de la mise à jour du profil : " . mysqli_error($conn);
        header("Location: ../pages/Profile.php?error=$error_message");
        exit();
    }

    // Fermer la déclaration préparée
    mysqli_stmt_close($stmt);
} else {
    echo "Accès non autorisé";
}

mysqli_close($conn);
?>

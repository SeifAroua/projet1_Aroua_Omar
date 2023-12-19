<?php
require_once('../Db/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $required_fields = ['user_name', 'email', 'pwd', 'street_name', 'street_nb', 'city', 'province', 'zip_code', 'country'];
    $errors = [];

    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[] = "Le champ '$field' est requis.";
        }
    }

    if (!empty($errors)) {
        $error_message = implode("<br>", $errors);
        header("Location: ../SignUp.php?error=$error_message");
        exit();
    }

    $user_name = $_POST['user_name'];
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];
    $street_name = $_POST['street_name'];
    $street_nb = $_POST['street_nb'];
    $city = $_POST['city'];
    $province = $_POST['province'];
    $zip_code = $_POST['zip_code'];
    $country = $_POST['country'];

    $hashed_password = password_hash($pwd, PASSWORD_DEFAULT);

    // Rôle par défaut pour les nouveaux utilisateurs (client avec l'ID 3)
    $default_role_id = 3;

    // Utilisation de requêtes préparées pour éviter les attaques par injection SQL
    $sql_user = "INSERT INTO `user` (`user_name`, `email`, `pwd`, `role_id`) VALUES (?, ?, ?, ?)";
    $stmt_user = mysqli_prepare($conn, $sql_user);
    mysqli_stmt_bind_param($stmt_user, "sssi", $user_name, $email, $hashed_password, $default_role_id);

    if (mysqli_stmt_execute($stmt_user)) {
        $user_id = mysqli_insert_id($conn);

        $sql_address = "INSERT INTO `address` (`street_name`, `street_nb`, `city`, `province`, `zip_code`, `country`) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_address = mysqli_prepare($conn, $sql_address);
        mysqli_stmt_bind_param($stmt_address, "ssssss", $street_name, $street_nb, $city, $province, $zip_code, $country);

        if (mysqli_stmt_execute($stmt_address)) {
            $address_id = mysqli_insert_id($conn);

            $sql_update_user = "UPDATE `user` SET `billing_address_id` = ?, `shipping_address_id` = ? WHERE `id` = ?";
            $stmt_update_user = mysqli_prepare($conn, $sql_update_user);
            mysqli_stmt_bind_param($stmt_update_user, "iii", $address_id, $address_id, $user_id);

            if (mysqli_stmt_execute($stmt_update_user)) {
                header("Location: ../pages/Profile.php");
            } else {
                echo "Erreur lors de la mise à jour de l'utilisateur avec l'ID d'adresse : " . mysqli_error($conn);
            }
        } else {
            echo "Erreur lors de l'insertion de l'adresse : " . mysqli_error($conn);
        }
    } else {
        echo "Erreur lors de l'enregistrement de l'utilisateur : " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt_user);
    mysqli_stmt_close($stmt_address);
    mysqli_stmt_close($stmt_update_user);

} else {
    echo "Accès non autorisé";
}

mysqli_close($conn);
?>

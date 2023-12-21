<?php
require_once('../Db/database.php');

function getAddressById($addressId) {
    $conn = $GLOBALS['conn'];

    // Utiliser une requête préparée
    $sql = "SELECT * FROM `address` WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    // Lier le paramètre
    mysqli_stmt_bind_param($stmt, "i", $addressId);

    // Exécuter la requête
    mysqli_stmt_execute($stmt);

    // Obtenir le résultat
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Fermer la déclaration préparée
        mysqli_stmt_close($stmt);

        return $row;
    } else {
        // Fermer la déclaration préparée
        mysqli_stmt_close($stmt);

        header("Location: ../Commande/ResultatEchec.php");
        exit();
    }
}
?>

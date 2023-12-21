<?php
require_once('../Db/database.php');

function getUserById($user_id) {
    $conn = $GLOBALS['conn'];

    // Utilisation d'une requête préparée pour éviter les attaques par injection SQL
    $sql = "SELECT * FROM `user` WHERE id = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        return $row;
    }
}
?>

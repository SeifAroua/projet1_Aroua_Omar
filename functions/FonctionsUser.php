<?php
require_once('../Db/database.php');

function getUserById($user_id) {
    $conn = $GLOBALS['conn'];

    $sql = "SELECT * FROM `user` WHERE id = $user_id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        return $row;

    }
}
?>

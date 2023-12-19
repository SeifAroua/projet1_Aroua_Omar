<?php
require_once('../Db/database.php');

function getAddressById($addressId) {
    $conn = $GLOBALS['conn'];

    $sql = "SELECT * FROM `address` WHERE id = $addressId";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        return $row;

    } else {
        header("Location: ../Commande/ResultatEchec.php");
        exit();
    }
}
?>

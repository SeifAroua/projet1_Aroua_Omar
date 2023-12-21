<?php
include('../Db/database.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Authentification/login.php");
    exit();
}

$conn = $GLOBALS['conn'];

$user_id = $_SESSION['user_id'];

$sql = "SELECT u.*, a.* FROM `user` u
        JOIN `address` a ON u.shipping_address_id = a.id
        WHERE u.id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    $street_name = $row['street_name'];
    $street_nb = $row['street_nb'];
    $city = $row['city'];
    $province = $row['province'];
    $zip_code = $row['zip_code'];
    $country = $row['country'];
} else {
    header("Location: ../Commande/ResultatEchec.php");
    exit();
}

$cart_products = $_SESSION['cart'];

$total_price = 0;
foreach ($cart_products as $product) {
    $total_price += $product['quantity'] * $product['price'];
}

$sql_insert_order = "INSERT INTO `user_order` (`ref`, `date`, `total`, `user_id`) VALUES ('$order_reference', NOW(), $total_price, $user_id)";
$result_insert_order = mysqli_query($conn, $sql_insert_order);

if (!$result_insert_order) {
    header("Location: ../Commande/ResultatEchec.php");
    exit();
}

$order_id = mysqli_insert_id($conn);

unset($_SESSION['cart']);

header("Location: ../Commande/ResultatSucces.php");
exit();
?>

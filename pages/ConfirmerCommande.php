<?php
include('../Db/database.php');
require_once "../functions/FonctionsAddress.php";
require_once "../functions/FonctionsUser.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Authentification/login.php");
    exit();
}

$conn = $GLOBALS['conn'];

$user_id = $_SESSION['user_id'];


//Todo: possibiliter de modifier les address
//Todo: ajouter un bouton pour retourner 

$user = getUserById($user_id);

$billing_address_id = $user["billing_address_id"];
$shipping_address_id = $user["shipping_address_id"];

$billingAddress = getAddressById($billing_address_id);
$shippingAddress = getAddressById($shipping_address_id);

$produits_panier = $_SESSION['cart'];

$total_prix = 0;
foreach ($produits_panier as $produit) {
    $total_prix += $produit['quantity'] * $produit['price'];
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>Confirmer la Commande</title>
</head>

<body>
    <h1>Confirmer Votre Commande</h1>

    <p>Adresse de Livraison :</p>
    <p>Nom de la Rue : <?php echo $shippingAddress['street_name']; ?></p>
    <p>Numéro de Rue : <?php echo $shippingAddress['street_nb']; ?></p>
    <p>Ville : <?php echo $shippingAddress['city']; ?></p>
    <p>Province : <?php echo $shippingAddress['province']; ?></p>
    <p>Code Postal : <?php echo $shippingAddress['zip_code']; ?></p>
    <p>Pays : <?php echo $shippingAddress['country']; ?></p>

    <p>Adresse de Facturation :</p>
    <p>Nom de la Rue : <?php echo $billingAddress['street_name']; ?></p>
    <p>Numéro de Rue : <?php echo $billingAddress['street_nb']; ?></p>
    <p>Ville : <?php echo $billingAddress['city']; ?></p>
    <p>Province : <?php echo $billingAddress['province']; ?></p>
    <p>Code Postal : <?php echo $billingAddress['zip_code']; ?></p>
    <p>Pays : <?php echo $billingAddress['country']; ?></p>


    <p>Produits dans le Panier :</p>
    <ul>
        <?php foreach ($produits_panier as $produit) : ?>
            <li>
                <?php echo $produit['name']; ?> -
                Quantité : <?php echo $produit['quantity']; ?>,
                Prix : <?php echo $produit['price']; ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <form action="../functions/FonctionsConfirmerCommande.php" method="post">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <input type="hidden" name="total_prix" value="<?php echo $total_prix; ?>">
        <?php foreach ($produits_panier as $produit) : ?>
            <input type="hidden" name="product_id[]" value="<?php echo $produit['id']; ?>">
            <input type="hidden" name="quantity[]" value="<?php echo $produit['quantity']; ?>">
            <input type="hidden" name="price[]" value="<?php echo $produit['price']; ?>">
        <?php endforeach; ?>
        <button type="submit">Passer la Commande</button>
    </form>
</body>

</html>

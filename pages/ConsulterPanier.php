<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Authentification/login.php");
    exit();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_to_cart'])) {
        $idProduit = $_POST['id_produit'];
        $nomProduit = $_POST['nom_produit'];
        $prixProduit = $_POST['prix_produit'];

        $produitDansPanier = false;
        foreach ($_SESSION['cart'] as &$elementPanier) {
            if ($elementPanier['id'] === $idProduit) {
                $elementPanier['quantite'] += 1;
                $produitDansPanier = true;
                break;
            }
        }
        unset($elementPanier);

        if (!$produitDansPanier) {
            $_SESSION['cart'][] = [
                'id' => $idProduit,
                'nom' => $nomProduit,
                'prix' => $prixProduit,
                'quantite' => 1,
            ];
        }
    } elseif (isset($_POST['vider_panier'])) {
        $_SESSION['cart'] = [];
    } elseif (isset($_POST['confirmer_commande'])) {
        header("Location: ConfirmerCommande.php");
        exit();
    }
}

$totalPrix = 0;
foreach ($_SESSION['cart'] as $element) {
    $totalPrix += $element['prix'] * $element['quantite'];
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>Voir le Panier</title>
</head>

<body>

    <main>
        <h1>Votre Panier d'Achats</h1>

        <div class="container-panier">
            <?php
            foreach ($_SESSION['cart'] as $element) {
                echo '<div class="element-panier">';
                echo '<p>' . $element['nom'] . '</p>';
                echo '<p>Prix : ' . $element['prix'] . ' €</p>';
                echo '<p>Quantité : ' . $element['quantite'] . '</p>';
                echo '</div>';
            }
            ?>

            <p>Prix Total : <?php echo number_format($totalPrix, 2); ?> €</p>

            <form action="ConfirmerCommande.php" method="post">
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                <?php foreach ($_SESSION['cart'] as $element) : ?>
                    <input type="hidden" name="id_produit[]" value="<?php echo $element['id']; ?>">
                    <input type="hidden" name="nom_produit[]" value="<?php echo $element['nom']; ?>">
                    <input type="hidden" name="prix_produit[]" value="<?php echo $element['prix']; ?>">
                <?php endforeach; ?>
                <button type="submit" name="confirmer_commande">Confirmer la Commande</button>
            </form>
            <br>

            <form action="" method="post">
                <button type="submit" name="vider_panier">Vider le Panier</button>
            </form>
            <a href="../index.php">Accueil</a>
        </div>
    </main>

</body>

</html>

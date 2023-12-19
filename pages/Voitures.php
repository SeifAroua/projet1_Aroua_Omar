<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // L'utilisateur n'est pas connecté, redirection vers la page de connexion
    header("Location: ../Authentification/login.php");
    exit();
}

// Initialiser le panier s'il n'existe pas
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Inclure le fichier de configuration de la base de données
include("../Db/database.php"); 

// Récupérer les données de la table "product"
$voitures = [];
$sql = "SELECT * FROM product";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $voitures[] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'price' => $row['price'],
            'img_url' => $row['img_url'],
            'description' => $row['description'],
        ];
    }
}

// Gestion de l'ajout au panier
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_to_cart'])) {
        // Récupérer les détails du produit et ajouter au panier
        $productId = $_POST['product_id'];
        $productName = $_POST['product_name'];
        $productPrice = $_POST['product_price'];

        // Vérifier si le produit est déjà dans le panier
        $productInCart = false;
        foreach ($_SESSION['cart'] as &$cartItem) {
            if ($cartItem['id'] === $productId) {
                $cartItem['quantity'] += 1; // Incrémenter la quantité
                $productInCart = true;
                break;
            }
        }
        unset($cartItem); // Libérer la référence explicite

        // Si le produit n'est pas dans le panier, l'ajouter
        if (!$productInCart) {
            $_SESSION['cart'][] = [
                'id' => $productId,
                'name' => $productName,
                'price' => $productPrice,
                'quantity' => 1,
            ];
        }
    }
}

// Fermer la connexion à la base de données
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>Voitures</title>
</head>

<body>

    <main>
        <h1>Voitures</h1>

        <div class="voitures-container">
            <?php foreach ($voitures as $voiture) { ?>
                <div class="voiture-item">
                    <p><?php echo $voiture['name']; ?></p>
                    <p>Prix : <?php echo $voiture['price']; ?> $</p>

                    <!-- Formulaire pour ajouter la voiture au panier -->
                    <form action="" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $voiture['id']; ?>">
                        <input type="hidden" name="product_name" value="<?php echo $voiture['name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $voiture['price']; ?>">
                        <button type="submit" name="add_to_cart">Ajouter au Panier</button>
                    </form>
                </div>
            <?php } ?>
        </div>

        <br>

        <a href="../Commande/panier.php">Voir le Panier</a>
        <a href="../index.php">Page d'accueil</a>
    </main>

</body>

</html>

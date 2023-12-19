<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>Ajouter un Produit</title>
</head>

<body>

    <header>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="views/auth/register.php">S'inscrire</a></li>
                <li><a href="views/auth/login.php">Connexion</a></li>
                <li><a href="views/auth/profile.php">Profil</a></li>
                <li><a href="views/order/view_cart.php">Panier</a></li>
            </ul>
        </nav>
        <div>
            <a href="../index.php"></a>
        </div>
    </header>

    <h2>Ajouter un Produit</h2>
    <form action="../functions/FonctionsAjoutProduit.php" method="post" enctype="multipart/form-data">
        <label for="name">Nom du Produit :</label>
        <input type="text" name="name" required><br>

        <label for="quantity">Quantité :</label>
        <input type="number" name="quantity" required><br>

        <label for="price">Prix :</label>
        <input type="text" name="price" required><br>

        <label for="description">Description :</label>
        <textarea name="description" required></textarea><br>

        <input type="submit" value="Ajouter le Produit">

        <a href="PageAdmin.php">Page Admin</a>
    </form>

    <footer>
    </footer>

</body>

</html>

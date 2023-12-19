<?php
require_once('../Db/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['name'];
    $quantite = $_POST['quantity'];
    $prix = $_POST['price'];
    $description = $_POST['description'];

    $repertoireCible = "img";

    // Utilisation des déclarations préparées pour sécuriser la requête
    $requeteInsertion = "INSERT INTO `product` (`name`, `quantity`, `price`, `img_url`, `description`) 
                        VALUES (?, ?, ?, 'voiture1.jpg', ?)";

    // Préparation de la requête
    $statement = mysqli_prepare($conn, $requeteInsertion);

    // Vérification de la préparation de la requête
    if ($statement) {
        // Liaison des paramètres
        mysqli_stmt_bind_param($statement, 'sdds', $nom, $quantite, $prix, $description);

        // Exécution de la requête
        $resultatRequete = mysqli_stmt_execute($statement);

        // Vérification du résultat de la requête
        if ($resultatRequete) {
            echo "Enregistrement réussi.";
        } else {
            echo "Erreur lors de l'enregistrement : " . mysqli_error($conn);
        }

        // Fermeture de la déclaration préparée
        mysqli_stmt_close($statement);
    } else {
        echo "Erreur lors de la préparation de la requête : " . mysqli_error($conn);
    }
} else {
    echo "Accès non autorisé.";
}

// Fermeture de la connexion
mysqli_close($conn);
?>

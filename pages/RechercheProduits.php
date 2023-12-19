<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>Rechercher des Commandes</title>
</head>

<body>
    <h1>Rechercher des Commandes</h1>
    <span style="color: red; font-weight: bold;">Cliquez sur 'Rechercher' pour voir toutes les commandes</span>

    <form action="voir_commandes_recherche.php" method="post">
        <label for="search_ref">Rechercher par Référence :</label>
        <input type="text" name="search_ref" required>
        <button type="submit">Rechercher</button>
    </form>

    <a class="lien-tableau-bord" href="../Administrateur/PageAdmin.php">Page Administrateur</a>
</body>

</html>

<?php
session_start();

if (!isset($_SESSION['user_id'])) :
    header("Location: connexion.php");
    exit();
endif;

$user_role = $_SESSION['user_role'];

if ($user_role != 1) :
    header("Location: ../index.php");
    exit();
endif;

require_once('database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') :
    $search_ref = mysqli_real_escape_string($conn, $_POST['search_ref']);

    $search_query = "SELECT * FROM `user_order` WHERE `ref` LIKE '%$search_ref%'";
    $search_result = mysqli_query($conn, $search_query);

    if ($search_result) :
?>
        <h2>Résultats de la Recherche</h2>
        <?php
        while ($order = mysqli_fetch_assoc($search_result)) :
        ?>
            ID de la Commande : <?= $order['id'] ?><br>
            Référence : <?= $order['ref'] ?><br>
            Date : <?= $order['date'] ?><br>
            Total : <?= $order['total'] ?> €<br>
            ID Utilisateur : <?= $order['user_id'] ?><br>
            <hr>
    <?php endwhile;
    else :
        echo "Erreur dans la recherche : " . mysqli_error($conn);
    endif;
endif;

mysqli_close($conn);
?>

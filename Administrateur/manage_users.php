<?php
session_start();

if (!isset($_SESSION['user_id'])):
    header("Location: ../Authentification/login.php");
    exit();
endif;

$user_role = $_SESSION['user_role'];

if ($user_role != 1):
    header("Location: ../index.php");
    exit();
endif;
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../style/style.css">
    <title>Gérer les Utilisateurs</title>
</head>

<body>
    <h2>Liste des Utilisateurs</h2>
    <a href="PageAdmin.php">Page Administrateur</a>

    <?php
    require_once('../Db/database.php');

    $sql = "SELECT `id`, `user_name`, `email` FROM `user`";
    $result = mysqli_query($conn, $sql);

    if ($result): ?>
        <table >
            <tr>
                <th>ID Utilisateur</th>
                <th>Nom d'Utilisateur</th>
                <th>Email</th>
                <th>Action</th>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['user_name'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td>
                        <a href='MiseANiveauUtilisateur.php?user_id=<?= $row['id'] ?>'>Administrateur</a>
                        <a href='SupprimerUtilisateur.php?user_id=<?= $row['id'] ?>'>Supprimer</a>
                    </td>
                </tr>
            <?php endwhile; ?>

        </table>

        <?php mysqli_free_result($result);
    else:
        echo "Erreur : " . mysqli_error($conn);
    endif;

    mysqli_close($conn);
    ?>
</body>

</html>

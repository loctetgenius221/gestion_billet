<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once 'config.php';

$client_list = array();

$sql_client = "SELECT * FROM client";
$resultat_client = mysqli_query($bdd, $sql_client);

if ($resultat_client) {
    while ($row = mysqli_fetch_assoc($resultat_client)) {
        $client_list[$row['nom'] . ' ' . $row['prenom']] = $row['id'];
        $client_id = $row['id'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date_de_depart = isset($_POST['datededepart']) ? $_POST['datededepart'] : "";
    $date_de_retour = isset($_POST['datederetour']) ? $_POST['datederetour'] : "";
    $au_depart_de = isset($_POST['audepartde']) ? $_POST['audepartde'] : "";
    $destination = isset($_POST['destination']) ? $_POST['destination'] : "";
    $prix = isset($_POST['prix']) ? $_POST['prix'] : "";
    $client_id_selected = isset($_POST['client']) ? $_POST['client'] : "";

    // Utilisation de requêtes préparées pour éviter les injections SQL
    $requete = "INSERT INTO billet (prix, date_de_depart, date_de_retour, au_depart_de, destination, id_client) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($bdd, $requete);
    mysqli_stmt_bind_param($stmt, "sssssi", $prix, $date_de_depart, $date_de_retour, $au_depart_de, $destination, $client_id_selected);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($stmt) {
        header('location: read.php');
    } else {
        echo "<h1>Désolé! Votre billet n'a pas été inséré</h1>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'ajout de billet</title>
    <link rel="stylesheet" href="main.css">
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <div class="formulaire">
            <form action="" method="POST">
                <div class="date">
                    <label>Date de départ<br>
                        <input type="date" name="datededepart" placeholder="Entrez la date de départ..">
                    </label>
                    <label>Date de retour<br>
                        <input type="date" name="datederetour" placeholder="Entrez la date de retour..">
                    </label>
                </div>
                <div class="dest">
                    <label>Au départ de <br>
                        <input type="text" name="audepartde" placeholder="Entrez le lieu de départ.." class="destination">
                    </label>
                    <label>Destination <br>
                        <input type="text" name="destination" placeholder="Entrez la destination.." class="destination">
                    </label>
                </div>
                <br>
                <label>Prix <br>
                    <input type="number" name="prix" placeholder="Entrez le prix.." class="prix">
                </label><br><br>
                <label>Client <br>
                    <select name="client">
                        <?php
                        foreach ($client_list as $client_name => $client_id) {
                            echo "<option value='$client_id'>$client_name</option>";
                        }
                        ?>
                    </select>
                </label><br><br>
                <input type="submit" value="Réserver" name="reserver">
            </form>
        </div>
        <div class="bg-img"></div>
    </div>
</body>

</html>

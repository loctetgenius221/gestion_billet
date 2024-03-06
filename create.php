<?php
    include_once 'config.php';

    $client_list = array();

    $sql_client = "SELECT * FROM client";
    $resultat_client = mysqli_query($bdd, $sql_client);

    if ($resultat_client) {
        while ($row = mysqli_fetch_assoc($resultat_client)) {
            $client_list[$row['nom'] . ' ' . $row['prenom']] = $row['id'];
            $client_id = $row['id'];
        }

        // Correction : Déplacer cette ligne à l'intérieur de la boucle while pour récupérer le dernier id
        
    }

    if(isset($_POST['reserver'])) {
        // Récupérer les valeurs du formulaire
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $date_de_depart = $_POST["date_de_depart"];
        $date_de_retour = $_POST["date_de_retour"];
        $au_depart_de = $_POST["au_depart_de"];
        $destination = $_POST["destination"];
        $prix = $_POST["prix"];

        // Correction : Utiliser le tableau $client_list pour obtenir l'id du client
        $client_id = isset($_POST['client']) ? $_POST['client'] : 0;

        // Correction : Utiliser des marqueurs de position dans la requête préparée
        $sql = "INSERT INTO billet (prix, date_de_depart, date_de_retour, au_depart_de, destination, id_client) VALUES (?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($bdd, $sql)) {
            // Correction : Lier les variables à la requête préparée
            mysqli_stmt_bind_param($stmt, "sssssi", $param_nom, $param_prenom, $param_date_de_depart, $param_date_de_retour, $param_au_depart_de, $param_client_id);

            // Correction : Définir les paramètres
            $param_nom = $nom;
            $param_prenom = $prenom;
            $param_date_de_depart = $date_de_depart;
            $param_date_de_retour = $date_de_retour;
            $param_au_depart_de = $au_depart_de;
            $param_client_id = $client_id;

            // Exécuter la requête
            if (mysqli_stmt_execute($stmt)) {
                header("location: index.php");
                exit();
            } else {
                echo "Oops! Une erreur est survenue.";
            }

            // Fermer la déclaration
            mysqli_stmt_close($stmt);
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
                <div class="nom">
                    <label>Nom <br>
                        <input type="text" name="nom" id="nom" placeholder="Entrez le nom..">
                    </label><br>
                    <label>Prénom <br>
                        <input type="text" name="prenom" placeholder="Entrez le prénom..">
                    </label><br>
                </div>
                <div class="date">
                    <label>Date de départ<br>
                        <input type="date" name="date_de_depart" placeholder="Entrez la date de départ..">
                    </label>
                    <label>Date de retour<br>
                        <input type="date" name="date_de_retour" placeholder="Entrez la date de retour..">
                    </label>
                </div>
                <div class="dest">
                    <label>Au départ de <br>
                        <input type="text" name="au_depart_de" placeholder="Entrez le lieu de départ.." class="destination">
                    </label>
                    <label>Destination <br>
                        <input type="text" name="destination" placeholder="Entrez la destination.." class="destination">
                    </label>
                </div>
                <br>
                <label>Prix <br>
                    <input type="number" name="prix" placeholder="Entrez le prix.." class="prix">
                </label><br><br>
                <!-- Correction : Ajouter une liste déroulante pour sélectionner le client -->
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

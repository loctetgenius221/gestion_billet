<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include_once "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : "";
    $prix = isset($_POST['prix']) ? $_POST['prix'] : "";
    $date_de_depart = isset($_POST['date_de_depart']) ? $_POST['date_de_depart'] : "";
    $date_de_retour = isset($_POST['date_de_retour']) ? $_POST['date_de_retour'] : "";
    $au_depart_de = isset($_POST['au_depart_de']) ? $_POST['au_depart_de'] : "";
    $destination = isset($_POST['destination']) ? $_POST['destination'] : "";
    // $statut = isset($_POST['statut']) ? $_POST['statut'] : "";

    // Utilisation de requêtes préparées pour éviter les injections SQL
    $sql = "UPDATE billet SET prix=?, date_de_depart=?, date_de_retour=?, au_depart_de=?, destination=?, statut=? WHERE id=?";
    $stmt = mysqli_prepare($bdd, $sql);
    mysqli_stmt_bind_param($stmt, "dssssii", $prix, $date_de_depart, $date_de_retour, $au_depart_de, $destination, $statut, $id);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($result) {
        header("Location: read.php"); // Redirection vers la page des billets après la mise à jour
        exit();
    } else {
        echo "Erreur lors de la mise à jour du billet.";
    }
} elseif (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Récupérer les données du billet à partir de l'ID
    $sql = "SELECT * FROM billet WHERE id = ?";
    $stmt = mysqli_prepare($bdd, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $billet = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
} else {
    echo "ID du billet non spécifié.";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le billet</title>
    <link rel="stylesheet" href="main.css">
    <style>

        .client-form form {
            width: 70%;
        }

        .client-form h1 {
            color: white;
            text-align: center;
            margin-bottom: 25px;
        }

        .client-form form .nom {
            width: 100%;   
            display: flex;
            gap: 45px;
        } 

        form .nom input {
            width: 300px;
            padding: 10px;
            background: none;
            border: none;
            outline: none;
            border-bottom: 2px solid #fff;
            color: #fff;
            font-size: 18px;
            margin-bottom: 25px;
            /* box-shadow: 0px 0px 10px #f1f1f1; */
        }

        .client-form form .prix {
            width: 300px;
            padding: 10px;
            background: none;
            border: none;
            outline: none;
            border-bottom: 2px solid #fff;
            color: #fff;
            font-size: 18px;
            margin-bottom: 25px;
        }

        form label {
            color: #fff;
            font-size: 22px;
        }

        form select {
            width: 100%;
            padding: 10px;
            background: none;
            border: none;
            outline: none;
            border-bottom: 2px solid #fff;
            color: #fff;
            font-size: 18px;
            margin-bottom: 45px;
        }

        form input[type="submit"]{
            background: #FE7A15;
            border: none;
            width: 300px;
            padding: 8px;
            color: #fff;
            font-weight: bold;
            font-size: 22px;
            cursor: pointer;
            border-radius: 5px;
            float: right;
        }
    </style>
</head>
<body>
    
    <?php
        include 'header.php';
    
    ?>
    <main id="container-update">
        <div class="client-form">
            <h1>Modifier le billet</h1>
            <form action="" method="POST">
                <input type="hidden" name="id" value="<?=$billet['id']?>">
                <label>Prix<br>
                    <input type="number" name="prix" value="<?=$billet['prix']?>" class="prix">
                </label>
                <div class="nom">
                    <label>Date de départ<br>
                        <input type="date" name="date_de_depart" value="<?=$billet['date_de_depart']?>">
                    </label>
                    <label>Date de retour<br>
                        <input type="date" name="date_de_retour" value="<?=$billet['date_de_retour']?>">
                    </label>
                </div>
                <div class="nom">
                    <label>Au départ de<br>
                        <input type="text" name="au_depart_de" value="<?=$billet['au_depart_de']?>" class="destination">
                    </label>
                    <label>Destination<br>
                        <input type="text" name="destination" value="<?=$billet['destination']?>" class="destination">
                    </label>
                </div>
                <label>Statut<br>
                    <select name="statut">
                        <option value="En attente" <?php echo ($billet['statut'] == 'en attente') ? 'selected' : ''; ?>>En attente</option>
                        <option value="Confirmé" <?php echo ($billet['statut'] == 'confirmé') ? 'selected' : ''; ?>>Confirmé</option>
                        <option value="Annulé" <?php echo ($billet['statut'] == 'annulé') ? 'selected' : ''; ?>>Annulé</option>
                    </select>
                </label>
                
                <input type="submit" value="Enregistrer les modifications" name="modifier">
            </form>
        </div>
    </main>
</body>
</html>

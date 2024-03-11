<?php
include_once "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : "";
    $nom = isset($_POST['nom']) ? $_POST['nom'] : "";
    $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : "";
    $adresse = isset($_POST['adresse']) ? $_POST['adresse'] : "";
    $telephone = isset($_POST['telephone']) ? $_POST['telephone'] : "";
    $email = isset($_POST['email']) ? $_POST['email'] : "";

    // Utilisation de requêtes préparées pour éviter les injections SQL
    $sql = "UPDATE client SET nom=?, prenom=?, adresse=?, telephone=?, email=? WHERE id=?";
    $stmt = mysqli_prepare($bdd, $sql);
    mysqli_stmt_bind_param($stmt, "sssssi", $nom, $prenom, $adresse, $telephone, $email, $id);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($result) {
        header("Location: client.php"); // Redirection vers la page des clients après la mise à jour
        exit();
    } else {
        echo "Erreur lors de la mise à jour du client.";
    }
} elseif (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Récupérer les données du client à partir de l'ID
    $sql = "SELECT * FROM client WHERE id = ?";
    $stmt = mysqli_prepare($bdd, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $client = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
} else {
    echo "ID du client non spécifié.";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le client</title>
    <link rel="stylesheet" href="main.css">
    <style>

        .client-form h1 {
            color: white;
            text-align: center;
            margin-bottom: 50px;
        }
        .client-form form label {
            color: #fff;
            font-size: 22px;
        }
        .client-form form .nom input {
            width: 245px;
            padding: 10px;
            background: none;
            border: none;
            outline: none;
            border-bottom: 2px solid white;
            color: #fff;
            font-size: 18px;
        }
        .client-form form .nom {
            width: 100%;
            display: flex;
            justify-content: space-around;
            margin-bottom: 50px;
        }
        .client-form form .email {
            width: 88%;
            padding: 10px;
            background: none;
            border: none;
            outline: none;
            border-bottom: 2px solid white;
            color: #fff;
            font-size: 18px;
            margin-left: 38px;
            margin-bottom: 50px;
        }
        .client-form form .label-email {
            margin-left: 40px;
        }
        .client-form form input[type="submit"]{
            background: #FE7A15;
            border: none;
            width: 290px;
            padding: 8px;
            color: #fff;
            font-weight: bold;
            font-size: 20px;
            cursor: pointer;
            border-radius: 5px;
            float: right;
            margin-right: 185px;
        }
    </style>
</head>
<body>
    
    <?php
        include 'header.php';
    
    ?>
    <main id="container-update">
        <div class="client-form">
            <h1>Modifier le client</h1>
            <form action="" method="POST">
                <input type="hidden" name="id" value="<?=$client['id']?>">
                <div class="nom">
                    <label>Nom<br>
                        <input type="text" name="nom" value="<?=$client['nom']?>">
                    </label>
                    <label>Prénom<br>
                        <input type="text" name="prenom" value="<?=$client['prenom']?>">
                    </label>
                </div>
                <div class="nom">
                    <label>Adresse<br>
                        <input type="text" name="adresse" value="<?=$client['adresse']?>">
                    </label>
                    <label>Téléphone<br>
                        <input type="tel" name="telephone" value="<?=$client['telephone']?>">
                    </label>
                </div>
                <label class="label-email">Email<br>
                    <input type="email" name="email" value="<?=$client['email']?>" class="email">
                </label>
                <input type="submit" value="Enregistrer les modifications" name="modifier">
            </form>
        </div>
    </main>
</body>
</html>

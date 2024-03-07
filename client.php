<?php
include_once 'config.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$inserted = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = isset($_POST['nom']) ? $_POST['nom'] : "";
    $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : "";
    $adresse = isset($_POST['adresse']) ? $_POST['adresse'] : "";
    $telephone = isset($_POST['telephone']) ? $_POST['telephone'] : "";
    $email = isset($_POST['email']) ? $_POST['email'] : "";

    // Utilisation de requêtes préparées pour éviter les injections SQL
    $requete = "INSERT INTO client (nom, prenom, adresse, telephone, email) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($bdd, $requete);
    mysqli_stmt_bind_param($stmt, "sssss", $nom, $prenom, $adresse, $telephone, $email);
    $inserted = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Vider les variables après l'insertion réussie
    if ($inserted) {
        $nom = "";
        $prenom = "";
        $adresse = "";
        $telephone = "";
        $email = "";
    }

    if ($stmt) {
        header('location: read.php');
    }

}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La liste des client de l'agence</title>
    <link rel="stylesheet" href="main.css">
    <style>
        .ajout-client {
            width: 100%;
            min-height: 100vh;
            display: flex;
        }

        .ajout-client .client-bg {
            flex-basis: 50%;
            background: #FE7A15;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .ajout-client .client-bg h1 {
            color: #000;
            font-size: 29px;
            border-left: 5px solid #000;
            padding: 10px;
        }

        .ajout-client .client-form {
            flex-basis: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .client-form form {
            width: 70%;
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
            border-bottom: 2px solid #607080;
            color: #607080;
            font-size: 18px;
            margin-bottom: 25px;
            /* box-shadow: 0px 0px 10px #f1f1f1; */
        }

        form label {
            color: #000;
            font-size: 22px;
        }

        form input.email {
            width: 100%;
            padding: 10px;
            background: none;
            border: none;
            outline: none;
            border-bottom: 2px solid #607080;
            color: #607080;
            font-size: 18px;
            margin-bottom: 35px;
        }

        form input[type="submit"]{
            background: #FE7A15;
            border: none;
            width: 200px;
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
    <main id="container">

        <!-- Afficher le message d'insertion uniquement si l'insertion a eu lieu -->
        

        <table>
            <thead>
                <?php 
                include_once "config.php";
                //Liste des utilisateurs
                $sql = "SELECT * FROM client";
                $result = mysqli_query($bdd, $sql);
                
                if (mysqli_num_rows($result) > 0) {
                //Afficher les utilisateurs
                ?>
                <tr>
                    <th>Client_Id</th>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Adresse</th>
                    <th>Téléphone</th>
                    <th>Email</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                </tr>
            </thead>

            <tbody>
                <?php 
                    while($rows = mysqli_fetch_assoc($result)) {
                        $id = $rows['id'];
                ?>
                <tr>
                    <td><?=$rows['id']?></td>
                    <td><?=$rows['nom']?></td>
                    <td><?=$rows['prenom']?></td>
                    <td><?=$rows['adresse']?></td>
                    <td><?=$rows['telephone']?></td>
                    <td><?=$rows['email']?></td>
                    <td class="image">
                        <a href='update.php?id=<?=$id?>'><img src="images/pen.png" alt=""></a>
                    </td>
                    <td class="image">
                        <a href='delete_client.php?id=<?=$id?>'><img src="images/trash.png" alt=""></a>
                    </td>

                </tr>

                <?php
                    }
                }
                else {
                    echo " <p class='message'>0 client présent !</p>";
                }
                ?>
            </tbody>
        </table>

    </main>

    <section class="ajout-client">
        <div class="client-bg">
            <h1>Bravo!! <br>Vous allez inscrire un nouveau client.</h1>
        </div>
        <div class="client-form">
            <form action="" method="POST">
                
                <div class="nom">
                    <label>Nom<br>
                       <input type="text" name="nom" placeholder="Entrez le nom..">
                    </label>
                    <label>Prénom<br>
                        <input type="text" name="prenom" placeholder="Entrez le prénom..">
                    </label>
                </div>
                <div class="nom">
                    <label>Adresse<br>
                       <input type="text" name="adresse" placeholder="Entrez l'adresse..">
                    </label>
                    <label>Téléphone<br>
                        <input type="tel" name="telephone" placeholder="Entrez le numéro téléphone..">
                    </label>
                </div>
                <label>Email<br>
                    <input type="email" name="email" placeholder="Entrez l'email.." class="email">
                </label>
                <input type="submit" value="Inscrire" name="inscrire">
            </form>
        </div>
    </section>
</body>
</html>
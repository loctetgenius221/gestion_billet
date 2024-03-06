<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La liste des client de l'agence</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    
    <?php
        include 'header.php';
    
    ?>
    <main id="container">

        <!-- <div class="link_container">
            <a class="link" href="addUser.php">Ajouter un billet</a>
        </div> -->

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
                </tr>
            </thead>

            <tbody>
                <?php 
                    while($rows = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?=$rows['id']?></td>
                    <td><?=$rows['nom']?></td>
                    <td><?=$rows['prenom']?></td>
                    <td><?=$rows['adresse']?></td>
                    <td><?=$rows['telephone']?></td>
                    <td><?=$rows['email']?></td>
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
</body>
</html>
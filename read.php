<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    
    <?php
        include 'header.php';
    
    ?>
    <main>

        <!-- <div class="link_container">
            <a class="link" href="addUser.php">Ajouter un billet</a>
        </div> -->

        <table>
            <thead>
                <?php 
                include_once "config.php";
                //Liste des utilisateurs
                $sql = "SELECT * FROM billet";
                $result = mysqli_query($bdd, $sql);
                
                if (mysqli_num_rows($result) > 0) {
                //Afficher les utilisateurs
                ?>
                <tr>
                    <th>Billet_Id</th>
                    <th>Date de réservation</th>
                    <th>Prix</th>
                    <th>Statut</th>
                    <th>Date de départ</th>
                    <th>Date de retour</th>
                    <th>Au départ de</th>
                    <th>Destination</th>
                    <th>Id_client</th>
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
                    <td><?=$rows['date_de_reservation']?></td>
                    <td><?=$rows['prix']?></td>
                    <td><?=$rows['statut']?></td>
                    <td><?=$rows['date_de_depart']?></td>
                    <td><?=$rows['date_de_retour']?></td>
                    <td><?=$rows['au_depart_de']?></td>
                    <td><?=$rows['destination']?></td>
                    <td><?=$rows['id_client']?></td>
                    <td class="image"><a href='update.php?id=<?=$id?>'><img src="images/pen.png" alt=""></a></td>
                    <td class="image"><a href='delete.php?id=<?=$id?>'><img src="images/trash.png" alt=""></a></td>
                </tr>

                <?php
                    }
                }
                else {
                    echo " <p class='message'>0 utilisateur présent !</p>";
                }
                ?>
            </tbody>
        </table>

    </main>
</body>
</html>
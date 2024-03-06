<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'ajout de billet</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <?php
    include 'header.php';
    
    ?>
    <div class="container">
        <div class="formulaire">
            <form action="" method="POST">
                <div class="nom">
                    <label>Nom <br>
                        <input type="text" name="nom" id="nom" placeholder="Entrez le nom..">
                    </label><br>
                    <label>Prenom <br>
                        <input type="text" name="prenom" placeholder="Entrez le prénom..">
                    </label><br>
                </div>
                <div class="date">
                    <label for="">Date de départ<br>
                        <input type="date" name="date_de_depart" placeholder="Entrez la date de départ..">
                    </label>
                    <label for="">Date de retour<br>
                        <input type="date" name="date_de_retour" placeholder="Entrez la date de retour..">
                    </label>
                </div>
                <div class="dest">
                    <label for="">Au départ de <br>
                        <input type="text" name="au_depart_de" placeholder="Entrez le lieu de départ.." class="destination">
                    </label>
                    <label for="">Destination <br>
                        <input type="text" name="destination" placeholder="Entrez la destination.." class="destination">
                    </label>
                </div>
                <br><br>
                <input type="submit" value="Réservé" name="reserver">
            </form>
        </div>
        <div class="bg-img">
            
        </div>
    </div>
    
</body>
</html>
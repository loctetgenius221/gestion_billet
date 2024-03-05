<?php
define("SERVERNAME", "localhost");
define("USERNAME", "root");
define("PASSWORD", "");
define("DBNAME", "gestion_billet");

$bdd = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DBNAME);

if(!$bdd) {
    die("La connexion à échouée! : " . mysqli_connect_error());
} else {
    // echo "Connexion réussie avec succès";
}











?>
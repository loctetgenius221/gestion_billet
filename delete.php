<?php
include_once "config.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Supprimer le billet en fonction de l'ID
    $sql = "DELETE FROM billet WHERE id = ?";
    $stmt = mysqli_prepare($bdd, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($result) {
        header("Location: read.php"); // Redirection vers la page des billets après la suppression
        exit();
    } else {
        echo "Erreur lors de la suppression du billet.";
    }
} else {
    echo "ID du billet non spécifié.";
}
?>

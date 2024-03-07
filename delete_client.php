<?php
include_once "config.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Supprimer le client en fonction de l'ID
    $sql = "DELETE FROM client WHERE id = ?";
    $stmt = mysqli_prepare($bdd, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($result) {
        header("Location: client.php"); // Redirection vers la page des clients après la suppression
        exit();
    } else {
        echo "Erreur lors de la suppression du client.";
    }
} else {
    echo "ID du client non spécifié.";
}
?>

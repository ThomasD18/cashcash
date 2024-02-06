<?php

function connectToDatabase() {
    $serveur = "localhost";
    $utilisateur = "root";
    $motDePasse = "root";
    $nomBaseDeDonnees = "cashcash";

    $conn = mysqli_connect($serveur, $utilisateur, $motDePasse, $nomBaseDeDonnees);

    if (!$conn) {
        die("Échec de la connexion à la base de données : " . mysqli_connect_error());
    }

    return $conn;
}
?>

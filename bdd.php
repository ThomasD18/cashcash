<?php
// Informations de connexion à la base de données
$serveur = "localhost"; // Adresse du serveur MySQL (peut également être une adresse IP)
$utilisateur = "root"; // Nom d'utilisateur MySQL
$motDePasse = "root"; // Mot de passe MySQL
$nomBaseDeDonnees = "cashcash"; // Nom de la base de données MySQL

// Connexion à la base de données
$mysqli = new mysqli($serveur, $utilisateur, $motDePasse, $nomBaseDeDonnees);

// Vérifier la connexion
if ($mysqli->connect_error) {
    die("Échec de la connexion à la base de données : " . $mysqli->connect_error);
}

echo "Connexion réussie à la base de données.";

// Vous pouvez maintenant exécuter des requêtes SQL ou effectuer d'autres opérations avec la base de données.

// N'oubliez pas de fermer la connexion lorsque vous avez terminé avec la base de données
$mysqli->close();
?>

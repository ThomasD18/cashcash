<?php
include_once(__DIR__ . "/bdd.php");
// Connexion à la base de données
$conn = connectToDatabase();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $clientId = mysqli_real_escape_string($conn, $_POST['client_id']);
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $raison_sociale = mysqli_real_escape_string($conn, $_POST['raison_sociale']);
    $siren = mysqli_real_escape_string($conn, $_POST['siren']);
    $ape = mysqli_real_escape_string($conn, $_POST['ape']);
    $adresse = mysqli_real_escape_string($conn, $_POST['adresse']);
    $telephone = mysqli_real_escape_string($conn, $_POST['telephone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Écrire la requête SQL pour mettre à jour les informations du client
    $query = "UPDATE client SET Nom='$nom', raison_sociale='$raison_sociale', SIREN='$siren', APE='$ape', Adresse='$adresse', Telephone='$telephone', email='$email' WHERE id='$clientId'";
    
    // Exécuter la requête
    $result = mysqli_query($conn, $query);

    // Vérifier si la mise à jour a réussi
    if ($result) {
        // Stocker le message dans une session
        session_start();
        $_SESSION['success_message'] = "La modification a été effectuée avec succès.";

        // Rediriger vers la page Rechercherdesclients.php
        header("Location: Rechercherdesclients.php");
        exit(); // Assurez-vous d'ajouter exit() après la redirection pour arrêter l'exécution du script
    } else {
        echo "La mise à jour a échoué : " . mysqli_error($conn);
    }
} else {
    echo "Méthode de requête non autorisée.";
}

// N'oubliez pas de fermer la connexion lorsque vous avez terminé avec la base de données
mysqli_close($conn);
?>

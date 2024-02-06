<?php
include_once("../bdd.php");
$conn = connectToDatabase();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $clientId = mysqli_real_escape_string($conn, $_POST['client_id']);
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $raison_sociale = mysqli_real_escape_string($conn, $_POST['raison_sociale']);
    $siren = mysqli_real_escape_string($conn, $_POST['siren']);
    $ape = mysqli_real_escape_string($conn, $_POST['ape']);
    $adresse = mysqli_real_escape_string($conn, $_POST['adresse']);
    $telephone = mysqli_real_escape_string($conn, $_POST['telephone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $query = "UPDATE client SET Nom='$nom', raison_sociale='$raison_sociale', SIREN='$siren', APE='$ape', Adresse='$adresse', Telephone='$telephone', email='$email' WHERE id='$clientId'";
    
    $result = mysqli_query($conn, $query);

    if ($result) {
        session_start();
        $_SESSION['success_message'] = "La modification a été effectuée avec succès.";

        header("Location: Rechercherdesclients.php");
        exit(); 
    } else {
        echo "La mise à jour a échoué : " . mysqli_error($conn);
    }
} else {
    echo "Méthode de requête non autorisée.";
}

mysqli_close($conn);
?>

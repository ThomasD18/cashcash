<?php
include_once(__DIR__ . "\bdd.php");

// Démarrer la session
session_start();

// Fonction pour afficher les messages temporaires
function displayFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        echo "<p style='color: green;'>" . $_SESSION['flash_message'] . "</p>";
        
        // Supprimer le message de la session après l'avoir affiché
        unset($_SESSION['flash_message']);
    }
}

// Connexion à la base de données
$conn = connectToDatabase();

// Vérifier si l'identifiant du client est passé dans l'URL
if (isset($_GET['id'])) {
    $clientId = $_GET['id'];

    // Écrire la requête SQL pour récupérer les informations du client
    $query = "SELECT * FROM client WHERE id = '$clientId'";
    
    // Exécuter la requête
    $result = mysqli_query($conn, $query);

    // Vérifier s'il y a des résultats
    if ($result !== false) {
        $row = mysqli_fetch_assoc($result);

        if ($row !== null) {
            // Afficher le formulaire de modification avec les informations actuelles du client
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="/style.css"> <!-- Lien vers le fichier style.css -->
                <title>Modifier Client</title>
            </head>
            <body>

                <h1>Modifier Client</h1>

                <!-- Afficher les messages temporaires -->
                <?php displayFlashMessage(); ?>

                <form method="POST" action="traitement_modification.php">
                    <label for="nom">Nom:</label>
                    <input type="text" id="nom" name="nom" value="<?php echo $row['Nom']; ?>">

                    <label for="raison_sociale">Raison Sociale:</label>
                    <input type="text" id="raison_sociale" name="raison_sociale" value="<?php echo $row['raison_sociale']; ?>">

                    <label for="siren">SIREN:</label>
                    <input type="text" id="siren" name="siren" value="<?php echo $row['SIREN']; ?>">

                    <label for="ape">APE:</label>
                    <input type="text" id="ape" name="ape" value="<?php echo $row['APE']; ?>">

                    <label for="adresse">Adresse:</label>
                    <input type="text" id="adresse" name="adresse" value="<?php echo $row['Adresse']; ?>">

                    <label for="telephone">Téléphone:</label>
                    <input type="text" id="telephone" name="telephone" value="<?php echo $row['Telephone']; ?>">

                    <label for="email">Email:</label>
                    <input type="text" id="email" name="email" value="<?php echo $row['email']; ?>">

                    <input type="hidden" name="client_id" value="<?php echo $clientId; ?>">
                    <button type="submit">Enregistrer les modifications</button>
                </form>

            </body>
            </html>
            <?php
        } else {
            echo "Aucun client trouvé avec cet identifiant.";
        }
    } else {
        // Query failed, display an error message
        die("La requête a échoué : " . mysqli_error($conn));
    }
} else {
    echo "Identifiant du client non spécifié.";
}

// N'oubliez pas de fermer la connexion lorsque vous avez terminé avec la base de données
mysqli_close($conn);
?>

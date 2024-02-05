<?php
// Rechercherdesclients.php
include_once(__DIR__ . "/bdd.php");
include_once(__DIR__ . "/index.php"); // Assurez-vous que le chemin vers index.php est correct

// Démarrer la session
session_start();

// Connexion à la base de données
$conn = connectToDatabase();

// Vérifier si un message temporaire est présent
if (isset($_SESSION['success_message'])) {
    echo '<div style="color: green; font-weight: bold;">' . $_SESSION['success_message'] . '</div>';
    // Supprimer le message après l'affichage
    unset($_SESSION['success_message']);
}

// Vérifier si le formulaire de recherche a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer la valeur de recherche pour le nom
    $searchByName = isset($_POST['searchByName']) ? mysqli_real_escape_string($conn, $_POST['searchByName']) : '';

    // Récupérer la valeur de recherche pour l'ID
    $searchById = isset($_POST['searchById']) ? mysqli_real_escape_string($conn, $_POST['searchById']) : '';

    // Construire la requête SQL en fonction des champs remplis
    $whereClause = '';
    if (!empty($searchByName)) {
        $whereClause .= "Nom LIKE '%$searchByName%'";
    }
    if (!empty($searchById)) {
        $whereClause .= ($whereClause != '' ? ' AND ' : '') . "id = '$searchById'";
    }

    // Écrire la requête SQL pour rechercher dans la table client
    $query = "SELECT * FROM client";
    if ($whereClause != '') {
        $query .= " WHERE $whereClause";
    }

    // Exécuter la requête
    $result = mysqli_query($conn, $query);

    // Vérifier s'il y a des résultats
    if ($result !== false) {
        $numRows = mysqli_num_rows($result);

        if ($numRows > 0) {
            echo "<h2>Résultats de la recherche :</h2>";
            echo "<table border='1'>";
            echo "<tr><th>Nom</th><th>Raison Sociale</th><th>SIREN</th><th>APE</th><th>Adresse</th><th>Téléphone</th><th>Email</th><th>Action</th></tr>";

            // Afficher les résultats dans un tableau avec un bouton de modification
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['Nom'] . "</td>";
                echo "<td>" . $row['raison_sociale'] . "</td>";
                echo "<td>" . $row['SIREN'] . "</td>";
                echo "<td>" . $row['APE'] . "</td>";
                echo "<td>" . $row['Adresse'] . "</td>";
                echo "<td>" . $row['Telephone'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td><a href='modifierclient.php?id=" . $row['id'] . "'>Modifier</a></td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "Aucun résultat trouvé.";
        }
    } else {
        // Query failed, display an error message
        die("La requête a échoué : " . mysqli_error($conn));
    }
}

// N'oubliez pas de fermer la connexion lorsque vous avez terminé avec la base de données
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style.css"> <!-- Lien vers le fichier style.css -->
    <title>Recherche Clients</title>
</head>
<body>

    <h1>Recherche Clients</h1>

    <!-- Formulaire de recherche -->
    <form method="POST" action="">
        <label for="searchByName">Rechercher par nom :</label>
        <input type="text" name="searchByName" placeholder="Nom">

        <label for="searchById">Rechercher par ID :</label>
        <input type="text" name="searchById" placeholder="ID">

        <button type="submit">Rechercher</button>
    </form>

</body>
</html>

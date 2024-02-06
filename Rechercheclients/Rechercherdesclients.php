<?php
include_once("../bdd.php");
session_start();
include_once("../index.php"); 


$conn = connectToDatabase();

if (isset($_SESSION['success_message'])) {
    echo '<div style="color: green; font-weight: bold;">' . $_SESSION['success_message'] . '</div>';
    unset($_SESSION['success_message']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchByName = isset($_POST['searchByName']) ? mysqli_real_escape_string($conn, $_POST['searchByName']) : '';

    $searchById = isset($_POST['searchById']) ? mysqli_real_escape_string($conn, $_POST['searchById']) : '';

    $whereClause = '';
    if (!empty($searchByName)) {
        $whereClause .= "Nom LIKE '%$searchByName%'";
    }
    if (!empty($searchById)) {
        $whereClause .= ($whereClause != '' ? ' AND ' : '') . "id = '$searchById'";
    }

    $query = "SELECT * FROM client";
    if ($whereClause != '') {
        $query .= " WHERE $whereClause";
    }

    $result = mysqli_query($conn, $query);

    if ($result !== false) {
        $numRows = mysqli_num_rows($result);

        if ($numRows > 0) {
            echo "<h2>Résultats de la recherche :</h2>";
            echo "<table border='1'>";
            echo "<tr><th>Nom</th><th>Raison Sociale</th><th>SIREN</th><th>APE</th><th>Adresse</th><th>Téléphone</th><th>Email</th><th>Action</th></tr>";

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
        die("La requête a échoué : " . mysqli_error($conn));
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style.css"> 
    <title>Recherche Clients</title>
</head>
<body>

    <h1>Recherche Clients</h1>

    <form method="POST" action="">
        <label for="searchByName">Rechercher par nom :</label>
        <input type="text" name="searchByName" placeholder="Nom">

        <label for="searchById">Rechercher par ID :</label>
        <input type="text" name="searchById" placeholder="ID">

        <button type="submit">Rechercher</button>
    </form>

</body>
</html>

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
    $searchByDate = isset($_POST['searchByDate']) ? mysqli_real_escape_string($conn, $_POST['searchByDate']) : '';
    $searchByNumIntervention = isset($_POST['searchByNumIntervention']) ? mysqli_real_escape_string($conn, $_POST['searchByNumIntervention']) : '';

    $whereClause = '';
    if (!empty($searchByDate)) {
        $whereClause .= "Date_intervention LIKE '%$searchByDate%'";
    }
    if (!empty($searchByNumIntervention)) {
        $whereClause .= ($whereClause != '' ? ' AND ' : '') . "Num_intervention = '$searchByNumIntervention'";
    }

    $query = "SELECT * FROM intervention";
    if ($whereClause != '') {
        $query .= " WHERE $whereClause";
    }

    $result = mysqli_query($conn, $query);

    if ($result !== false) {
        $numRows = mysqli_num_rows($result);

        if ($numRows > 0) {
            echo "<h2>Résultats de la recherche :</h2>";
            echo "<table border='1'>";
            echo "<tr><th>Numéro d'intervention</th><th>Date d'intervention</th><th>Temps d'intervention</th><th>Commentaire</th><th>ID Technicien</th></tr>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['Num_intervention'] . "</td>";
                echo "<td>" . $row['Date_intervention'] . "</td>";
                echo "<td>" . $row['Temps_intervention'] . "</td>";
                echo "<td>" . $row['Commentaire'] . "</td>";
                echo "<td>" . $row['Id_Technicien'] . "</td>";
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
    <link rel="stylesheet" href="../style.css"> 
    <title>Recherche Interventions</title>
</head>
<body>

    <h1>Recherche Interventions</h1>

    <form method="POST" action="">
        <label for="searchByDate">Rechercher par date :</label>
        <input type="text" name="searchByDate" placeholder="Date (Format : YYYY-MM-DD)">

        <label for="searchByNumIntervention">Rechercher par numéro d'intervention :</label>
        <input type="text" name="searchByNumIntervention" placeholder="Numéro d'intervention">

        <button type="submit">Rechercher</button>
    </form>

</body>
</html>

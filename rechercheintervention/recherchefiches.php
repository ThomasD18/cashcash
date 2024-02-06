<?php
include_once("../bdd.php");

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style.css"> 
    <title>Recherche des Fiches d'Interventions</title>
</head>
<body>

    <h1>Recherche des Fiches d'Interventions</h1>

    <form method="POST" action="">
        <label for="searchDate">Sélectionnez une date :</label>
        <input type="date" name="searchDate">

        <label for="searchNumIntervention">Numéro d'Intervention :</label>
        <input type="text" name="searchNumIntervention" placeholder="Numéro d'Intervention">

        <button type="submit">Rechercher</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $searchDate = isset($_POST['searchDate']) ? $_POST['searchDate'] : '';
        $searchNumIntervention = isset($_POST['searchNumIntervention']) ? $_POST['searchNumIntervention'] : '';

        $conn = connectToDatabase();

        try {
            $query = "SELECT * FROM intervention WHERE (Date_intervention LIKE :searchDate OR :searchDate = '') AND (Num_intervention LIKE :searchNumIntervention OR :searchNumIntervention = '')";
            $stmt = $conn->prepare($query);

            if ($stmt) {
                $stmt->bindParam(':searchDate', $searchDate, PDO::PARAM_STR);
                $stmt->bindParam(':searchNumIntervention', $searchNumIntervention, PDO::PARAM_STR);
                $stmt->execute();

                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($result) {
                    echo "<h2>Résultats de la recherche :</h2>";
                    echo "<table border='1'>";
                    echo "<tr><th>Num Intervention</th><th>Date Intervention</th><th>Temps Intervention</th><th>Commentaire</th><th>Technicien</th><th>Distance</th></tr>";

                    foreach ($result as $row) {
                        echo "<tr>";
                        echo "<td>" . $row['Num_intervention'] . "</td>";
                        echo "<td>" . $row['Date_intervention'] . "</td>";
                        echo "<td>" . $row['Temps_intervention'] . "</td>";
                        echo "<td>" . $row['Commentaire'] . "</td>";
                        echo "<td>" . $row['Id_Technicien'] . "</td>";
                        echo "<td>" . $row['id_distance'] . "</td>";
                        echo "</tr>";
                    }

                    echo "</table>";
                } else {
                    echo "Aucun résultat trouvé.";
                }
            } else {
                echo "Erreur lors de la préparation de la requête.";
            }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }

        $conn = null;
    }
    ?>

</body>
</html>

<?php
include_once("../bdd.php");

function rechercherFichesIntervention($searchDate, $searchNumIntervention) {
    $conn = connectToDatabase();

    try {
        $query = "SELECT * FROM intervention WHERE (Date_intervention LIKE :searchDate OR :searchDate = '') AND (Num_intervention LIKE :searchNumIntervention OR :searchNumIntervention = '')";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            $stmt->bindParam(':searchDate', $searchDate, PDO::PARAM_STR);
            $stmt->bindParam(':searchNumIntervention', $searchNumIntervention, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    } catch (PDOException $e) {
        return false;
    } finally {
        $conn = null;
    }
}

?>

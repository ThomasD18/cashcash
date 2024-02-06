<?php
require_once(__DIR__ . "/vendor/autoload.php"); 
include_once(__DIR__ . "/bdd.php");

session_start();

use Dompdf\Dompdf;
$conn = connectToDatabase();

$sql = "SELECT * FROM intervention";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Erreur lors de l'exécution de la requete " . mysqli_error($conn));
}

$dompdf = new Dompdf();

$pdfbase = '<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des interventions</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; }
    </style>
</head>
<body>
    <h1>Liste des interventions</h1>
    <table>
        <thead>
            <tr>
                <th>ID Intervention</th>
                <th>Commentaire</th>
                <th>Technicien</th>
                <th>Date Intervention</th>
            </tr>
        </thead>
        <tbody>';

while ($row = mysqli_fetch_assoc($result)) {
    $pdfbase .= '<tr>
                <td>' . $row['Num_intervention'] . '</td>
                <td>' . $row['Commentaire'] . '</td>
                <td>' . $row['Id_Technicien'] . '</td>
                <td>' . $row['Date_intervention'] . '</td>
            </tr>';
}

$pdfbase .= '</tbody>
    </table>
</body>
</html>';

$dompdf->loadHtml($pdfbase);

$dompdf->render();

$dompdf->stream("listeinterventions.pdf");

mysqli_close($conn);


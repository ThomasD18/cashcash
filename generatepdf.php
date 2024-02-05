<?php
require_once('chemin/vers/tcpdf/tcpdf.php');
include_once(__DIR__ . "\bdd.php");

session_start();

$conn = connectToDatabase();

$sql = "SELECT * FROM intervention";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Erreur lors de l'exécution de la requête : " . mysqli_error($conn));
}

$pdf = new TCPDF();

$pdf->AddPage();

$pdf->SetFont('helvetica', 'B', 12);

while ($row = mysqli_fetch_assoc($result)) {
    $zoneDeTexte = "ID: " . $row['Num_intervention'] . "\Commentaire: " . $row['Commentaire'] . "\n" . "\Technicien: " . $row['Id_Technicien'] . "\n" . "\Date: " . $row['Date_intervention'] . "\n";
    $pdf->Cell(0, 10, $zoneDeTexte, 0, 1);
}

$nomFichier = 'exemple.pdf';

$pdf->Output($nomFichier, 'D');

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Télécharger le PDF</title>
</head>

<body>

    <a href="<?php echo $nomFichier; ?>" download="exemple.pdf">
        <button>Télécharger le PDF</button>
    </a>

</body>

</html>
<?php
require_once 'controllers/Controller.php';
require_once 'models/Model.php';
require_once 'views/View.php';

$controller = new Controller();
$data = $controller->action();

$model = new Model();
$modelData = $model->getData();

$view = new View();
$view->render($modelData);

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche dans la base de données</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Recherche dans la base de données</h1>
        <form action="recherche.php" method="POST">
            <label for="id">Recherche par ID :</label>
            <input type="text" name="id" id="id" placeholder="ID">
            <label for="nom">Recherche par Nom :</label>
            <input type="text" name="nom" id="nom" placeholder="Nom">
            <button type="submit">Rechercher</button>
        </form>
    </div>
</body>
</html>


?>


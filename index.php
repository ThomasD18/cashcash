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
?>

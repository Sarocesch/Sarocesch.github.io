<?php

require_once __DIR__ . '/../src/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';

    if ($name) {
        $commodityController = new App\Controllers\CommodityController($pdo);
        $commodityController->create($name);
    }
}

header('Location: index.php');
exit;

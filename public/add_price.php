<?php

require_once __DIR__ . '/../src/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $commodity_id = $_POST['commodity_id'] ?? null;
    $price = $_POST['price'] ?? null;
    $season = $_POST['season'] ?? null;

    if ($commodity_id && $price && $season) {
        $priceController = new App\Controllers\PriceController($pdo);
        $priceController->create($commodity_id, $price, $season);
    }
}

header('Location: commodity.php?id=' . $commodity_id);
exit;

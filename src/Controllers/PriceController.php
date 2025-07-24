<?php

namespace App\Controllers;

use App\Models\Price;
use PDO;

class PriceController
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create($commodity_id, $price, $season, $month)
    {
        $stmt = $this->pdo->prepare("INSERT INTO prices (commodity_id, price, season, month) VALUES (:commodity_id, :price, :season, :month)");
        $stmt->execute([
            'commodity_id' => $commodity_id,
            'price' => $price,
            'season' => $season,
            'month' => $month,
        ]);
        return $this->pdo->lastInsertId();
    }

    public function getByCommodity($commodity_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM prices WHERE commodity_id = :commodity_id");
        $stmt->execute(['commodity_id' => $commodity_id]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, Price::class);
    }
}

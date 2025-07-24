<?php

namespace App\Controllers;

use App\Models\Commodity;
use PDO;

class CommodityController
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM commodities");
        return $stmt->fetchAll(PDO::FETCH_CLASS, Commodity::class);
    }

    public function create($name)
    {
        $stmt = $this->pdo->prepare("INSERT INTO commodities (name) VALUES (:name)");
        $stmt->execute(['name' => $name]);
        return $this->pdo->lastInsertId();
    }
}

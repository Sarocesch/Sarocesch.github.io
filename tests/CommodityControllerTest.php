<?php

namespace Tests;

use App\Controllers\CommodityController;
use App\Models\Commodity;

class CommodityControllerTest extends DatabaseTestCase
{
    public function testGetAll()
    {
        $controller = new CommodityController(self::$pdo);
        $commodities = $controller->getAll();
        $this->assertCount(1, $commodities);
        $this->assertEquals('Oats', $commodities[0]->name);
    }

    public function testCreate()
    {
        $controller = new CommodityController(self::$pdo);
        $newId = $controller->create('Wheat');
        $this->assertEquals(2, $newId);

        $commodities = $controller->getAll();
        $this->assertCount(2, $commodities);
        $this->assertEquals('Wheat', $commodities[1]->name);
    }
}

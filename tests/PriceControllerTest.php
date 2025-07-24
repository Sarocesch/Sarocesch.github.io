<?php

namespace Tests;

use App\Controllers\PriceController;
use App\Models\Price;

class PriceControllerTest extends DatabaseTestCase
{
    public function testGetByCommodity()
    {
        $controller = new PriceController(self::$pdo);
        $prices = $controller->getByCommodity(1);
        $this->assertCount(1, $prices);
        $this->assertEquals(1200.00, $prices[0]->price);
    }

    public function testCreate()
    {
        $controller = new PriceController(self::$pdo);
        $newId = $controller->create(1, 1500.00, 2);
        $this->assertEquals(2, $newId);

        $prices = $controller->getByCommodity(1);
        $this->assertCount(2, $prices);
        $this->assertEquals(1500.00, $prices[1]->price);
    }
}

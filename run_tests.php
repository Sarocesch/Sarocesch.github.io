<?php

require_once 'vendor/autoload.php';
require_once 'tests/DatabaseTestCase.php';
require_once 'tests/CommodityControllerTest.php';
require_once 'tests/PriceControllerTest.php';

$test_classes = [
    'Tests\CommodityControllerTest',
    'Tests\PriceControllerTest',
];

foreach ($test_classes as $test_class) {
    $suite = new PHPUnit\Framework\TestSuite($test_class);
    $result = new PHPUnit\TextUI\TestRunner;
    $result->run($suite);
}

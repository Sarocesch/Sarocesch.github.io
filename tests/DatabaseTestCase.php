<?php

namespace Tests;

use PDO;
use PHPUnit\Framework\TestCase;

class DatabaseTestCase extends TestCase
{
    protected static $pdo;

    public static function setUpBeforeClass(): void
    {
        self::$pdo = new PDO('sqlite::memory:');
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::createTables();
    }

    public static function tearDownAfterClass(): void
    {
        self::$pdo = null;
    }

    private static function createTables()
    {
        $schema = file_get_contents(__DIR__ . '/../database.sql');
        self::$pdo->exec($schema);
    }
}

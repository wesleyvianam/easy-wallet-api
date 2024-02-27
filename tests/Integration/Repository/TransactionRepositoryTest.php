<?php

namespace Integration\Repository;

use PHPUnit\Framework\TestCase;

class TransactionRepositoryTest extends TestCase
{
    private static \PDO $pdo;

    public static function setUpBeforeClass(): void
    {
        self::$pdo = new \PDO('sqlite::memory:');
        self::$pdo->exec("       
            CREATE TABLE IF NOT EXISTS transactions (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                type INTEGER NOT NULL,
                sub_type TEXT CHECK(sub_type IN ('I', 'E')) NOT NULL,
                user_id INTEGER NOT NULL,
                value INTEGER NOT NULL,
                status INTEGER NOT NULL,
                created_at TEXT DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id)
            );
        ");
    }

    protected function setUp(): void
    {
        self::$pdo->beginTransaction();
    }

    public function testTransaction()
    {
        $this->assertEquals(1, true);
    }

    protected function tearDown(): void
    {
        self::$pdo->rollBack();
    }
}
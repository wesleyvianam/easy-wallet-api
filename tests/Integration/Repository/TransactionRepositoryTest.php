<?php

namespace Integration\Repository;

use Easy\Wallet\Domain\DTO\CreateTransferDTO;
use Easy\Wallet\Domain\Entity\Transaction;
use Easy\Wallet\Domain\Enum\TransactionSubtypeEnum;
use Easy\Wallet\Domain\Enum\TransactionTypeEnum;
use Easy\Wallet\Repositories\TransactionRepository;
use PHPUnit\Framework\Attributes\DataProvider;
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
            )
        ");
    }

    protected function setUp(): void
    {
        self::$pdo->beginTransaction();
    }

    #[DataProvider('transferFrom')]
    public function testCreationOfTransferAndItsCounterpart(CreateTransferDTO $transactions)
    {
        $transaction = new TransactionRepository(self::$pdo);

        $transferFrom = new Transaction(
            TransactionTypeEnum::TRANSFER,
            TransactionSubtypeEnum::EXPENSE,
            $transactions->userFrom,
            $transactions->value,
            1
        );

        $transferTo  = new Transaction(
            TransactionTypeEnum::TRANSFER,
            TransactionSubtypeEnum::INCOME,
            $transactions->userTo,
            $transactions->value,
            1
        );

        $resultTransferFrom = $transaction->register((array) $transferFrom);
        $resultTransferTo = $transaction->register((array) $transferTo);

        $this->assertTrue($resultTransferFrom);
        $this->assertTrue($resultTransferTo);
    }

    public static function transferFrom(): array
    {
        return [
            new CreateTransferDTO(1, 2, 10000)
        ];
    }

    protected function tearDown(): void
    {
        self::$pdo->rollBack();
    }
}
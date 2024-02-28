<?php

declare(strict_types=1);

namespace Easy\Wallet\Services;

use Easy\Wallet\Domain\Entity\Transaction;
use Easy\Wallet\Domain\Enum\TransactionTypeEnum;
use Easy\Wallet\Domain\Enum\TransactionSubtypeEnum;
use Easy\Wallet\Repositories\TransactionRepository;

class TransactionService extends AbstractService
{
    public function __construct(
        protected readonly TransactionRepository $repository
    ) {
    }

    public function register(array $data, string $type, string $subType, int $success): bool
    {
        $types = [
            'DEPOSIT' => 1,
            'WITHDRAW' => 2,
            'TRANSFER' => 3,
            'REVERSE' => 4
        ];

        $subTypes = [
            'INCOME' => 'I',
            'EXPENSE' => 'E',
        ];

        $transaction = new Transaction(
            $types[$type],
            $subTypes[$subType],
            $data['user'],
            $data['value'],
            $success,
        );

        return $this->repository->register((array) $transaction);
    }
}
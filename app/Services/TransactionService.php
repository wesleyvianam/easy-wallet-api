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

    public function register(
        array $data,
        TransactionTypeEnum $type,
        TransactionSubtypeEnum $subType,
        bool $success
    ): bool
    {
        $transaction = new Transaction(
            $type,
            $subType,
            $data['user'],
            $data['value'],
            $success,
        );

        return $this->repository->register((array) $transaction);
    }
}
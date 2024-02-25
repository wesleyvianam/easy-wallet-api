<?php

namespace Easy\Wallet\Services;

use Easy\Wallet\Domain\Transaction\DTO\TransactionRegisterDTO;
use Easy\Wallet\Repositories\TransactionRepository;
use Easy\Wallet\Repositories\WalletRepository;

class TransactionService extends AbstractService
{
    public function __construct(
        protected readonly TransactionRepository $repository
    ) {
    }

    public function register(array $data, string $type, string $subType, bool $success): void
    {
        $types = [
            'DEPOSIT' => 1,
            'WITHDRAW' => 2,
            'TRANSFER' => 3,
            'REVERSE' => 4
        ];

        $subTypes = [
            'INCOMES' => 'I',
            'EXPENSE' => 'E',
        ];

        $transaction = new TransactionRegisterDTO(
            $types[$type],
            $subTypes[$subType],
            $data['user'],
            $data['wallet'],
            $data['value'],
            $success,
        );

        $this->repository->register((array) $transaction);
    }
}
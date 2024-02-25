<?php

namespace Easy\Wallet\Services;

use Easy\Wallet\Domain\Wallet\DTO\CreateDepositDTO;
use Easy\Wallet\Repositories\TransactionRepository;
use Easy\Wallet\Repositories\WalletRepository;

class DepositService extends AbstractService
{
    public function __construct(
        protected readonly WalletRepository $repository,
        protected readonly TransactionService $transactionService
    ) {
    }

    public function deposit(CreateDepositDTO $deposit)
    {
        $wallet = $this->repository->find($deposit->user);
        if (empty($wallet)) {
            return [
                'code' => 404,
                'message' => 'Usuário não encontrado'
            ];
        }

        $deposit->balance += (int) str_replace(['.', ','], '', $wallet['balance']);

        $deposit->wallet = $wallet['id'];

        if ($this->repository->deposit($deposit)) {
            $this->transactionService->register(
                (array) $deposit,
                'DEPOSIT',
                'INCOMES',
                true
            );

            return [
                'code' => 200,
                'message' => "Deposito realizado com sucesso!"
            ];
        }

        $this->transactionService->register(
            (array) $deposit,
            'DEPOSIT',
            'INCOMES',
            false
        );

        return [
            'code' => 400,
            'message' => 'Não foi possível realizar o depósito.'
        ];
    }
}
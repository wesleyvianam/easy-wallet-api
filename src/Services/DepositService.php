<?php

namespace Easy\Wallet\Services;

use Easy\Wallet\Domain\DTO\CreateDepositDTO;
use Easy\Wallet\Repositories\BalanceRepository;
use Easy\Wallet\Repositories\UserRepository;

class DepositService extends AbstractService
{
    public function __construct(
        protected readonly BalanceRepository $balanceRepository,
        protected readonly UserRepository $userRepository,
        protected readonly TransactionService $transactionService
    ) {
    }

    public function deposit(CreateDepositDTO $deposit): array
    {
        $user = $this->userRepository->findById($deposit->user);

        if (empty($user)) {
            return self::response(404, ['message' => 'Usuário não encontrado']);
        }

        if ($this->transactionService->register((array) $deposit, 'DEPOSIT', 'INCOME', true)) {
            return self::response(200, ['message' => 'Deposito realizado com sucesso!']);
        }

        $this->transactionService->register((array) $deposit, 'DEPOSIT', 'INCOME', false);

        return self::response(400, ['message' => 'Não foi possível realizar o depósito.']);
    }
}
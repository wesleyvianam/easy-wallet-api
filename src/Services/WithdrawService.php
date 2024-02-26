<?php

namespace Easy\Wallet\Services;

use Easy\Wallet\Domain\DTO\CreateWithdrawDTO;
use Easy\Wallet\Repositories\BalanceRepository;
use Easy\Wallet\Repositories\UserRepository;

class WithdrawService extends AbstractService
{
    public function __construct(
        protected readonly UserRepository $userRepository,
        protected readonly BalanceService $balanceService,
        protected readonly TransactionService $transactionService
    ) {
    }

    public function withdraw(CreateWithdrawDTO $withdraw): array
    {
        $user = $this->userRepository->findById($withdraw->user);

        if (empty($user)) {
            return self::response(404, ['message' => 'Usuário não encontrado']);
        }

        $balance = $this->balanceService->getBalance($user['id']);

        if ($balance < $withdraw->value) {
            return self::response(400, ['message' => 'Saldo insuficiente']);
        }

        if ($this->transactionService->register((array) $withdraw, 'WITHDRAW', 'EXPENSE', true)) {
            return self::response(200, ['message' => 'Saque realizado com sucesso!']);
        }

        $this->transactionService->register((array) $withdraw, 'WITHDRAW', 'EXPENSE', false);

        return self::response(400, ['message' => 'Não foi possível realizar o saque.']);
    }
}
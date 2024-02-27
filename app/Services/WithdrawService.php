<?php

namespace Easy\Wallet\Services;

use Easy\Wallet\Domain\DTO\CreateWithdrawDTO;
use Easy\Wallet\Domain\Enum\TransactionSubtypeEnum;
use Easy\Wallet\Domain\Enum\TransactionTypeEnum;
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
        if ($withdraw->value < 1) {
            return self::response(400, ['message' => 'Valor precisa ser maior que 0 (zero)']);
        }

        $user = $this->userRepository->findById($withdraw->user);

        if (empty($user)) {
            return self::response(404, ['message' => 'Usuário não encontrado']);
        }

        $balance = $this->balanceService->getBalance($withdraw->user);

        if ($balance < $withdraw->value) {
            return self::response(400, ['message' => 'Saldo insuficiente']);
        }

        if ($this->transactionService->register((array) $withdraw, TransactionTypeEnum::WITHDRAW, TransactionSubtypeEnum::EXPENSE, true)) {
            return self::response(200, ['message' => 'Saque realizado com sucesso']);
        }

        $this->transactionService->register((array) $withdraw, TransactionTypeEnum::WITHDRAW, TransactionSubtypeEnum::EXPENSE, false);

        return self::response(400, ['message' => 'Não foi possível realizar o saque']);
    }
}
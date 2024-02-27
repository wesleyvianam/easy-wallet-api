<?php

namespace Easy\Wallet\Services;

use Easy\Wallet\Domain\DTO\CreateDepositDTO;
use Easy\Wallet\Domain\Enum\TransactionSubtypeEnum;
use Easy\Wallet\Domain\Enum\TransactionTypeEnum;
use Easy\Wallet\Repositories\UserRepository;

class DepositService extends AbstractService
{
    public function __construct(
        protected readonly UserRepository $userRepository,
        protected readonly TransactionService $transactionService
    ) {
    }

    public function deposit(CreateDepositDTO $deposit): array
    {
        if ($deposit->value < 1) {
            return self::response(400, ['message' => 'Valor precisa ser maior que 0 (zero)']);
        }

        $user = $this->userRepository->findById($deposit->user);

        if (empty($user)) {
            return self::response(404, ['message' => 'Usuário não encontrado']);
        }

        if ($this->transactionService->register((array) $deposit, TransactionTypeEnum::DEPOSIT, TransactionSubtypeEnum::INCOME, true)) {
            return self::response(200, ['message' => 'Deposito realizado com sucesso']);
        }

        $this->transactionService->register((array) $deposit, TransactionTypeEnum::DEPOSIT, TransactionSubtypeEnum::INCOME, false);

        return self::response(400, ['message' => 'Não foi possível realizar o depósito']);
    }
}
<?php

declare(strict_types=1);

namespace Easy\Wallet\Services;

use Easy\Wallet\Domain\DTO\CreateDepositDTO;
use Easy\Wallet\Http\ResponseHttp;
use Easy\Wallet\Repositories\UserRepository;
use Easy\Wallet\Domain\Enum\TransactionTypeEnum;
use Easy\Wallet\Domain\Enum\TransactionSubtypeEnum;

class DepositService extends AbstractService
{
    public function __construct(
        protected readonly UserRepository $userRepository,
        protected readonly TransactionService $transactionService
    ) {
    }

    public function deposit(CreateDepositDTO $deposit): ResponseHttp
    {
        if ($deposit->value < 1) {
            return ResponseHttp::response(403, ['message' => 'Valor precisa ser maior que 0 (zero)']);
        }

        $user = $this->userRepository->findById($deposit->user);

        if (empty($user)) {
            return ResponseHttp::response(404, ['message' => 'Usuário não encontrado']);
        }

        if ($this->transactionService->register((array) $deposit, 'DEPOSIT', 'INCOME', 1)) {
            return ResponseHttp::response(200, ['message' => 'Deposito realizado com sucesso']);
        }

        $this->transactionService->register((array) $deposit, 'DEPOSIT', 'INCOME', 0);

        return ResponseHttp::response(400, ['message' => 'Não foi possível realizar o depósito']);
    }
}
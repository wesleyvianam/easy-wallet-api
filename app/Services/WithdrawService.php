<?php

declare(strict_types=1);

namespace Easy\Wallet\Services;

use Easy\Wallet\Http\ResponseHttp;
use Easy\Wallet\Repositories\UserRepository;
use Easy\Wallet\Domain\DTO\CreateWithdrawDTO;

class WithdrawService extends AbstractService
{
    public function __construct(
        protected readonly UserRepository $userRepository,
        protected readonly BalanceService $balanceService,
        protected readonly TransactionService $transactionService
    ) {
    }

    public function withdraw(CreateWithdrawDTO $withdraw): ResponseHttp
    {
        if ($withdraw->value < 1) {
            return ResponseHttp::response(403, ['message' => 'Valor precisa ser maior que 0 (zero)']);
        }

        $user = $this->userRepository->findById($withdraw->user);

        if (empty($user)) {
            return ResponseHttp::response(404, ['message' => 'Usuário não encontrado']);
        }

        $balance = $this->balanceService->getBalance($withdraw->user);

        if ($balance < $withdraw->value) {
            return ResponseHttp::response(403, ['message' => 'Saldo insuficiente']);
        }

        if ($this->transactionService->register((array) $withdraw, 'WITHDRAW', 'EXPENSE', 1)) {
            return ResponseHttp::response(200, ['message' => 'Saque realizado com sucesso']);
        }

        $this->transactionService->register((array) $withdraw, 'WITHDRAW', 'EXPENSE', 0);

        return ResponseHttp::response(400, ['message' => 'Não foi possível realizar o saque']);
    }
}
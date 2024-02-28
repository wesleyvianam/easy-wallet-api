<?php

declare(strict_types=1);

namespace Easy\Wallet\Services;

use Easy\Wallet\Http\ResponseHttp;
use Easy\Wallet\Repositories\BalanceRepository;
use Easy\Wallet\Repositories\UserRepository;

class BalanceService extends AbstractService
{
    public function __construct(
        protected readonly BalanceRepository $repository,
        protected readonly UserRepository $userRepository
    ) {
    }

    public function getAmount(int $userId): ResponseHttp
    {
        $hasUser = $this->userRepository->findById($userId);

        if (empty($hasUser)) {
            return ResponseHttp::response(404, ['message' => 'Usuário não encontrado']);
        }

        $balance = $this->repository->findByUserId($userId);

        if ($balance) {
            return ResponseHttp::response(200, ['saldo' => $this->toMonetaryNumber($balance)]);
        }

        return ResponseHttp::response(400, ['message' => 'Não foi possível encontrar saldo']);
    }

    public function getBalance(int $userId): int
    {
        return $this->repository->findByUserId($userId);
    }
}
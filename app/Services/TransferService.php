<?php

namespace Easy\Wallet\Services;

use Easy\Wallet\Domain\DTO\CreateDepositDTO;
use Easy\Wallet\Domain\DTO\CreateTransferDTO;
use Easy\Wallet\Domain\DTO\CreateWithdrawDTO;
use Easy\Wallet\Repositories\BalanceRepository;
use Easy\Wallet\Repositories\UserRepository;

class TransferService extends AbstractService
{
    public function __construct(
        protected readonly UserRepository $userRepository,
        protected readonly BalanceService $balanceService,
        protected readonly TransactionService $transactionService,
        protected readonly AuthorizationService $authorization,
    ) {
    }

    public function transfer(CreateTransferDTO $transfer): array
    {
        if ($transfer->userTo === $transfer->userFrom) {
            return self::response(400, ['message' => 'Não é possível transferir dinheiro para o próprio usuário']);
        }

        $userFrom = $this->userRepository->findById($transfer->userFrom);

        if (empty($userFrom)) {
            return self::response(404, ['message' => 'Usuário não encontrado']);
        }

        if ($userFrom['type'] === 'J') {
            return self::response(400, ['message' => 'Logista não pode transferir dinheiro']);
        }

        $balance = $this->balanceService->getBalance($userFrom['id']);

        if ($balance < $transfer->value) {
            return self::response(400, ['message' => 'Saldo insuficiente']);
        }

        $userTo = $this->userRepository->findById($transfer->userTo);

        if (empty($userTo)) {
            return self::response(
                404,
                ['message' => 'Não foi possível realizar a transferencia, destinatário não existe']
            );
        }

        if ($this->authorization->authorizate()) {
            $this->logRegister(
                userFrom:[
                    'user' => $transfer->userFrom,
                    'value' => $transfer->value,
                ],
                userTo: [
                    'user' => $transfer->userTo,
                    'value' => $transfer->value,
                ],
                success: true
            );

            return self::response(200, ['message' => 'Transferência realizada com successo']);
        }

        $this->logRegister(
            userFrom:[
                'user' => $transfer->userFrom,
                'value' => $transfer->value,
            ],
            userTo: [
                'user' => $transfer->userTo,
                'value' => $transfer->value,
            ],
            success: false
        );

        return self::response(400, ['message' => 'Não foi possível realizar a transferencia!']);
    }

    private function logRegister(array $userFrom, array $userTo, bool $success): void
    {
        $this->transactionService->register(
            $userFrom,
            'TRANSFER',
            'EXPENSE',
            $success
        );

        $this->transactionService->register(
            $userTo,
            'TRANSFER',
            'INCOME',
            $success
        );
    }
}
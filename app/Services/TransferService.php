<?php

declare(strict_types=1);

namespace Easy\Wallet\Services;

use Easy\Wallet\Http\ResponseHttp;
use Easy\Wallet\Repositories\UserRepository;
use Easy\Wallet\Domain\DTO\CreateTransferDTO;

class TransferService extends AbstractService
{
    public function __construct(
        protected readonly UserRepository          $userRepository,
        protected readonly BalanceService          $balanceService,
        protected readonly TransactionService      $transactionService,
        protected readonly AuthorizationAPIService $authorization,
    ) {
    }

    public function transfer(CreateTransferDTO $transfer): ResponseHttp
    {
        if ($transfer->userTo === $transfer->userFrom) {
            return ResponseHttp::response(403, ['message' => 'Não é possível transferir dinheiro para o próprio usuário']);
        }

        if ($transfer->value < 1) {
            return ResponseHttp::response(403, ['message' => 'Valor precisa ser maior que 0 (zero)']);
        }

        $userFrom = $this->userRepository->findById($transfer->userFrom);
        if (empty($userFrom)) {
            return ResponseHttp::response(404, ['message' => 'Usuário não encontrado']);
        }

        if ($userFrom['type'] === 'J') {
            return ResponseHttp::response(400, ['message' => 'Logista não pode transferir dinheiro']);
        }

        $balance = $this->balanceService->getBalance($transfer->userFrom);

        if ($balance < $transfer->value) {
            return ResponseHttp::response(403, ['message' => 'Saldo insuficiente']);
        }

        $userTo = $this->userRepository->findById($transfer->userTo);

        if (empty($userTo)) {
            return ResponseHttp::response(
                404,
                ['message' => 'Não foi possível realizar a transferencia, destinatário não existe']
            );
        }

        if ($this->authorization->authorize()) {
            $this->logRegister(
                userFrom:[
                    'user' => $transfer->userFrom,
                    'value' => $transfer->value,
                    'email' => $userFrom['email'],
                    'phone' => $userFrom['phone'],
                ],
                userTo: [
                    'user' => $transfer->userTo,
                    'value' => $transfer->value,
                    'email' => $userTo['email'],
                    'phone' => $userTo['phone'],
                ],
                success: 1
            );

            return ResponseHttp::response(200, ['message' => 'Transferência autorizada com sucesso']);
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
            success: 0
        );

        return ResponseHttp::response(403, ['message' => 'Transferência não autorizada']);
    }

    private function logRegister(array $userFrom, array $userTo, int $success): void
    {
        if ($this->transactionService->register($userFrom, 'TRANSFER', 'EXPENSE', $success)) {
            if ($success) {
                SendMessageAPIService::email($userFrom['email']);
                SendMessageAPIService::sms($userFrom['phone']);
            }
        }

        if ($this->transactionService->register($userTo, 'TRANSFER', 'INCOME', $success)) {
            if ($success) {
                SendMessageAPIService::email($userTo['email']);
                SendMessageAPIService::sms($userTo['phone']);
            }
        }
    }
}
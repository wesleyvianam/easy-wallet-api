<?php

namespace Unit\Service;

use Easy\Wallet\Domain\DTO\CreateDepositDTO;
use Easy\Wallet\Repositories\UserRepository;
use Easy\Wallet\Services\DepositService;
use Easy\Wallet\Services\TransactionService;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class DepositServiceTest extends TestCase
{
    #[DataProvider('deposit')]
    public function testWithdrawFromAUserNotFound(CreateDepositDTO $deposit)
    {
        $userMock = $this->createMock(UserRepository::class);
        $userMock->method('findById')->willReturn([]);

        $depositService = new DepositService(
            $userMock,
            $this->createMock(TransactionService::class),
        );

        $result = $depositService->deposit($deposit);

        $this->assertSame(404, $result['code']);
        $this->assertSame(['message' => 'Usuário não encontrado'], $result['data']);
    }

    #[DataProvider('negativeDeposit')]
    public function testDepositWithNegativeValue(CreateDepositDTO $deposit)
    {
        $depositService = new DepositService(
            $this->createMock(UserRepository::class),
            $this->createMock(TransactionService::class),
        );

        $result = $depositService->deposit($deposit);

        $this->assertSame(403, $result['code']);
        $this->assertSame(['message' => 'Valor precisa ser maior que 0 (zero)'], $result['data']);
    }

    #[DataProvider('deposit')]
    public function testTransactionFailure(CreateDepositDTO $deposit)
    {
        $userMock = $this->createMock(UserRepository::class);
        $userMock->method('findById')->willReturn(['USER EXIST']);

        $transactionMock = $this->createMock(TransactionService::class);
        $transactionMock->method('register')->willReturn(false);

        $depositService = new DepositService($userMock, $transactionMock);

        $result = $depositService->deposit($deposit);

        $this->assertEquals(400, $result['code']);
        $this->assertEquals(['message' => 'Não foi possível realizar o depósito'], $result['data']);
    }

    #[DataProvider('deposit')]
    public function testTransferAuthorizationSuccess(CreateDepositDTO $deposit)
    {
        $userMock = $this->createMock(UserRepository::class);
        $userMock->method('findById')->willReturn(['USER EXIST']);

        $transactionMock = $this->createMock(TransactionService::class);
        $transactionMock->method('register')->willReturn(true);

        $depositService = new DepositService($userMock, $transactionMock);

        $result = $depositService->deposit($deposit);

        $this->assertEquals(200, $result['code']);
        $this->assertEquals(['message' => 'Deposito realizado com sucesso'], $result['data']);
    }

    public static function deposit(): array
    {
        return [
            [new CreateDepositDTO(
                1,
                100000,
            )]
        ];
    }

    public static function negativeDeposit(): array
    {
        return [
            [new CreateDepositDTO(
                1,
                -100,
            )]
        ];
    }
}
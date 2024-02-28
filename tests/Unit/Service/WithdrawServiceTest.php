<?php

namespace Unit\Service;

use Easy\Wallet\Domain\DTO\CreateWithdrawDTO;
use Easy\Wallet\Repositories\UserRepository;
use Easy\Wallet\Services\BalanceService;
use Easy\Wallet\Services\TransactionService;
use Easy\Wallet\Services\WithdrawService;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class WithdrawServiceTest extends TestCase
{
    #[DataProvider('negativeWithdraw')]
    public function testWithdrawWithNegativeValue(CreateWithdrawDTO $withdraw)
    {
        $withdrawService = new WithdrawService(
            $this->createMock(UserRepository::class),
            $this->createMock(BalanceService::class),
            $this->createMock(TransactionService::class),
        );

        $result = $withdrawService->withdraw($withdraw);

        $this->assertSame(403, $result->code);
        $this->assertJson($result->body);
    }

    #[DataProvider('withdraw')]
    public function testWithdrawFromAUserNotFound(CreateWithdrawDTO $withdraw)
    {
        $userMock = $this->createMock(UserRepository::class);
        $userMock->method('findById')->willReturn([]);

        $withdrawService = new WithdrawService(
            $userMock,
            $this->createMock(BalanceService::class),
            $this->createMock(TransactionService::class),
        );

        $result = $withdrawService->withdraw($withdraw);

        $this->assertSame(404, $result->code);
        $this->assertJson($result->body);
    }

    #[DataProvider('withdraw')]
    public function testUserWithoutBalanceToWithdraw(CreateWithdrawDTO $withdraw)
    {
        $userMock = $this->createMock(UserRepository::class);
        $userMock->method('findById')->willReturn(['NOT EMPTY']);

        $balanceMock = $this->createMock(BalanceService::class);
        $balanceMock->method('getBalance')->willReturn(0);

        $withdrawService = new WithdrawService(
            $userMock,
            $balanceMock,
            $this->createMock(TransactionService::class),
        );

        $result = $withdrawService->withdraw($withdraw);

        $this->assertSame(403, $result->code);
        $this->assertJson($result->body);
    }

    #[DataProvider('withdraw')]
    public function testTransactionFailure(CreateWithdrawDTO $withdraw)
    {
        $userMock = $this->createMock(UserRepository::class);
        $userMock->method('findById')->willReturn(['NOT EMPTY']);

        $balanceMock = $this->createMock(BalanceService::class);
        $balanceMock->method('getBalance')->willReturn(110000); // "1.100,00"

        $transactionMock = $this->createMock(TransactionService::class);
        $transactionMock->method('register')->willReturn(false);

        $withdrawService = new WithdrawService($userMock, $balanceMock, $transactionMock);

        $result = $withdrawService->withdraw($withdraw);

        $this->assertEquals(400, $result->code);
        $this->assertJson($result->body);
    }

    #[DataProvider('withdraw')]
    public function testTransactionSuccessfullyDone(CreateWithdrawDTO $withdraw)
    {
        $userMock = $this->createMock(UserRepository::class);
        $userMock->method('findById')->willReturn(['NOT EMPTY']);

        $balanceMock = $this->createMock(BalanceService::class);
        $balanceMock->method('getBalance')->willReturn(110000);

        $transactionMock = $this->createMock(TransactionService::class);
        $transactionMock->method('register')->willReturn(true);

        $withdrawService = new WithdrawService($userMock, $balanceMock, $transactionMock);

        $result = $withdrawService->withdraw($withdraw);

        $this->assertEquals(200, $result->code);
        $this->assertJson($result->body);
    }

    public static function withdraw(): array
    {
        return [
            [new CreateWithdrawDTO(
                1,
                100000,
            )]
        ];
    }

    public static function negativeWithdraw(): array
    {
        return [
            [new CreateWithdrawDTO(
                1,
                -100,
            )]
        ];
    }
}
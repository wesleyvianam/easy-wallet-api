<?php

namespace Unit\Service;

use Easy\Wallet\Domain\DTO\CreateTransferDTO;
use Easy\Wallet\Repositories\UserRepository;
use Easy\Wallet\Services\AuthorizationAPIService;
use Easy\Wallet\Services\BalanceService;
use Easy\Wallet\Services\TransactionService;
use Easy\Wallet\Services\TransferService;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class TransferServiceTest extends TestCase
{
    #[DataProvider('transferUserFromAndUserToIsEquals')]
    public function testTransferForYourself(CreateTransferDTO $transfer)
    {
        $transferService = new TransferService(
            $this->createMock(UserRepository::class),
            $this->createMock(BalanceService::class),
            $this->createMock(TransactionService::class),
            $this->createMock(AuthorizationAPIService::class)
        );

        $result = $transferService->transfer($transfer);

        $this->assertSame(403, $result->code);
        $this->assertJson($result->body);
    }

    #[DataProvider('negativeTransfer')]
    public function testTransferWithNegativeValue(CreateTransferDTO $transfer)
    {
        $transferService = new TransferService(
            $this->createMock(UserRepository::class),
            $this->createMock(BalanceService::class),
            $this->createMock(TransactionService::class),
            $this->createMock(AuthorizationAPIService::class)
        );

        $result = $transferService->transfer($transfer);

        $this->assertSame(403, $result->code);
        $this->assertJson($result->body);
    }

    #[DataProvider('GenericTransfer')]
    public function testUserFromNotFound(CreateTransferDTO $transfer)
    {
        $userMock = $this->createMock(UserRepository::class);
        $userMock->method('findById')->willReturn([]);

        $transferService = new TransferService(
            $userMock,
            $this->createMock(BalanceService::class),
            $this->createMock(TransactionService::class),
            $this->createMock(AuthorizationAPIService::class)
        );

        $result = $transferService->transfer($transfer);

        $this->assertSame(404, $result->code);
        $this->assertJson($result->body);
    }

    #[DataProvider('GenericTransfer')]
    public function testStoreDoesNotTransfer(CreateTransferDTO $transfer)
    {
        $userMock = $this->createMock(UserRepository::class);
        $userMock->method('findById')->willReturn(['type' => 'J']);

        $transferService = new TransferService(
            $userMock,
            $this->createMock(BalanceService::class),
            $this->createMock(TransactionService::class),
            $this->createMock(AuthorizationAPIService::class)
        );

        $result = $transferService->transfer($transfer);

        $this->assertSame(400, $result->code);
        $this->assertJson($result->body);
    }

    #[DataProvider('GenericTransfer')]
    public function testUserFromWithoutBalanceToTransfer(CreateTransferDTO $transfer)
    {
        $userMock = $this->createMock(UserRepository::class);
        $userMock->method('findById')->willReturn(['type' => 'F']);

        $balanceMock = $this->createMock(BalanceService::class);
        $balanceMock->method('getBalance')->willReturn(0);

        $transferService = new TransferService(
            $userMock,
            $balanceMock,
            $this->createMock(TransactionService::class),
            $this->createMock(AuthorizationAPIService::class)
        );

        $result = $transferService->transfer($transfer);

        $this->assertSame(403, $result->code);
        $this->assertJson($result->body);
    }

    #[DataProvider('GenericTransfer')]
    public function testUserToNotFound(CreateTransferDTO $transfer)
    {
        $userMock = $this->createMock(UserRepository::class);
        $userMock->method('findById')->willReturn(['type' => 'F'], []);

        $balanceMock = $this->createMock(BalanceService::class);
        $balanceMock->method('getBalance')->willReturn(110000); // "1.100,00"

        $transferService = new TransferService(
            $userMock,
            $balanceMock,
            $this->createMock(TransactionService::class),
            $this->createMock(AuthorizationAPIService::class)
        );

        $result = $transferService->transfer($transfer);

        $this->assertSame(404, $result->code);
        $this->assertJson($result->body);
    }

    #[DataProvider('GenericTransfer')]
    public function testTransferAuthorizationFailure(CreateTransferDTO $transfer)
    {
        $userMock = $this->createMock(UserRepository::class);
        $userMock->method('findById')->willReturn(
            ['type' => 'F', 'email' => 'email@gmail.com', 'phone' => '31 9 9999-9999'],
            ['type' => 'J', 'email' => 'email@gmail.com', 'phone' => '31 9 9999-9999']
        );

        $balanceMock = $this->createMock(BalanceService::class);
        $balanceMock->method('getBalance')->willReturn(110000); // "1.100,00"

        $authorizationMock = $this->createMock(AuthorizationAPIService::class);
        $authorizationMock->method('authorize')->willReturn(false);

        $transferService = new TransferService(
            $userMock,
            $balanceMock,
            $this->createMock(TransactionService::class),
            $authorizationMock
        );

        $result = $transferService->transfer($transfer);

        $this->assertEquals(403, $result->code);
        $this->assertJson($result->body);
    }

    #[DataProvider('GenericTransfer')]
    public function testTransferAuthorizationSuccess(CreateTransferDTO $transfer)
    {
        $userMock = $this->createMock(UserRepository::class);
        $userMock->method('findById')->willReturn(
            ['type' => 'F', 'email' => 'email@gmail.com', 'phone' => '31 9 9999-9999'],
            ['type' => 'J', 'email' => 'email@gmail.com', 'phone' => '31 9 9999-9999']
        );

        $balanceMock = $this->createMock(BalanceService::class);
        $balanceMock->method('getBalance')->willReturn(110000); // "1.100,00"

        $authorizationMock = $this->createMock(AuthorizationAPIService::class);
        $authorizationMock->method('authorize')->willReturn(true);

        $transferService = new TransferService(
            $userMock,
            $balanceMock,
            $this->createMock(TransactionService::class),
            $authorizationMock
        );

        $result = $transferService->transfer($transfer);

        $this->assertEquals(200, $result->code);
        $this->assertJson($result->body);
    }

    public static function transferUserFromAndUserToIsEquals(): array
    {
        return [
            [new CreateTransferDTO(
                1,
                1,
                10000
            )]
        ];
    }

    public static function negativeTransfer(): array
    {
        return [
            [new CreateTransferDTO(
                1,
                2,
                -100
            )]
        ];
    }

    public static function GenericTransfer(): array
    {
        return [
            [new CreateTransferDTO(
                1,
                2,
                10000
            )]
        ];
    }
}
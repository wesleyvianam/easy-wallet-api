<?php

namespace Unit\Service;

use Easy\Wallet\Domain\DTO\CreateUserDTO;
use Easy\Wallet\Repositories\UserRepository;
use Easy\Wallet\Services\BalanceService;
use Easy\Wallet\Services\UserService;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    public function testDeletedUserWithPositiveBalance()
    {
        $userMock = $this->createMock(UserRepository::class);
        $userMock->method('findById')->willReturn(['NOT EMPTY']);

        $balanceMock = $this->createMock(BalanceService::class);
        $balanceMock->method('getBalance')->willReturn(100);

        $userService = new UserService($userMock, $balanceMock);

        $result = $userService->delete(1);

        $this->assertSame(400, $result['code']);
        $this->assertSame(['message' => 'Não foi possível deletar, usuário possui saldo'], $result['data']);
    }

    public function testDeletedUserWithoutBalance()
    {
        $userMock = $this->createMock(UserRepository::class);
        $userMock->method('findById')->willReturn(['NOT EMPTY']);
        $userMock->method('delete')->willReturn(true);

        $balanceMock = $this->createMock(BalanceService::class);
        $balanceMock->method('getBalance')->willReturn(0);

        $userService = new UserService($userMock, $balanceMock);

        $result = $userService->delete(1);

        $this->assertSame(200, $result['code']);
        $this->assertSame(['message' => 'Usuário deletado com sucesso'], $result['data']);
    }

    #[DataProvider('user')]
    public function testCreateUserWithExistingEmail(CreateUserDTO $user)
    {
        $userMock = $this->createMock(UserRepository::class);
        $userMock->method('existsData')->willReturn(1);

        $userService = new UserService(
            $userMock,
            $this->createMock(BalanceService::class)
        );

        $result = $userService->register($user);

        $this->assertSame(400, $result['code']);
        $this->assertSame(['message' => 'Não foi possível salvar, email em uso'], $result['data']);
    }

    #[DataProvider('user')]
    public function testCreateUserWithExistingDocument(CreateUserDTO $user)
    {
        $userMock = $this->createMock(UserRepository::class);
        $userMock->method('existsData')->willReturn(0, 1);

        $userService = new UserService(
            $userMock,
            $this->createMock(BalanceService::class)
        );

        $result = $userService->register($user);

        $this->assertSame(400, $result['code']);
        $this->assertSame(['message' => 'Não foi possível salvar, documento em uso'], $result['data']);
    }

    public static function user(): array
    {
        return [
            [new CreateUserDTO(
                "Wesley Viana Martins",
                "wesley@gmail.com",
                "12345678",
                "F",
                "111.111.111-11",
                "(31) 9 1111-2222",
            )]
        ];
    }
}
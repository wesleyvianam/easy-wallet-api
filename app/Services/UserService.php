<?php

declare(strict_types=1);

namespace Easy\Wallet\Services;

use Easy\Wallet\Domain\Entity\User;
use Easy\Wallet\Domain\DTO\CreateUserDTO;
use Easy\Wallet\Repositories\UserRepository;

class UserService extends AbstractService
{
    public function __construct(
        protected readonly UserRepository $repository,
        protected readonly BalanceService $balanceService
    ) {
    }

    public function getUserById(int $userId): array
    {
        $user = $this->repository->findById($userId);
        if ($user) {
            $user['balance'] = $this->balanceService->getAmount($userId);

            return self::response(200, $user);
        }

        return self::response(404, ['message' => 'Usuário não encontrado']);
    }

    public function delete(int $userId): array
    {
        $user = $this->repository->findById($userId);
        if (empty($user)) {
            return self::response(404, ['message' => 'Usuário não encontrado']);
        }

        $balance = $this->balanceService->getBalance($userId);

        if ($balance > 0) {
            return self::response(400, ['message' => 'Não foi possível deletar, usuário possui saldo']);
        }

        if ($this->repository->delete($user)) {
            return self::response(200, ['message' => 'Usuário deletado com sucesso']);
        }

        return self::response(400, ['message' => 'Não foi possível deletar usuário']);
    }

    public function register(CreateUserDTO $user): array
    {
        if ($this->repository->existsData(field: 'email', data: $user->email)) {
            return self::response(400, ['message' => 'Não foi possível salvar, email em uso']);
        }

        if ($this->repository->existsData(field: 'document', data: $user->document)) {
            return self::response(400, ['message' => 'Não foi possível salvar, documento em uso']);
        }

        $userEntity = new User(
            $user->name,
            $user->email,
            $this->hashPassword($user->email),
            $user->type,
            $user->document,
            $user->phone
        );

        if ($this->repository->register((array) $userEntity)) {
            return self::response(200, ['message' => 'Novo usuário criado com sucesso']);
        }

        return self::response(400, ['message' => 'Não foi possível criar novo usuário']);
    }

    public function update(array $user): array
    {
        if ($user['email']) {
            if ($this->repository->existsData(field: 'email', data: $user['email'])) {
                return self::response(400, ['message' => 'Não foi possível salvar, email em uso']);
            }
        }

        if ($user['document']) {
            if ($this->repository->existsData(field: 'email', data: $user['document'])) {
                return self::response(400, ['message' => 'Não foi possível salvar, email em uso']);
            }
        }

        if ($user['password']) {
            $user['password'] = $this->hashPassword($user['password']);
        }

        $possibleUpdate = ['name', 'email', 'document', 'phone', 'password'];
        $update = "";
        foreach ($user as $key => $data) {
            if (in_array($data, $possibleUpdate)) {
                $update .= "{$key} = '{$data}'";
            }
        }

        if ($this->repository->update($update, $user['id'])) {
            return self::response(200, ['message' => 'Usuário atualizado com sucesso']);
        }

        return self::response(400, ['message' => 'Não foi possível atualizar novo usuário']);
    }

    public function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_ARGON2ID);
    }
}
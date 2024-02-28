<?php

declare(strict_types=1);

namespace Easy\Wallet\Services;

use Easy\Wallet\Domain\DTO\ShowUserDTO;
use Easy\Wallet\Domain\Entity\User;
use Easy\Wallet\Domain\DTO\CreateUserDTO;
use Easy\Wallet\Http\ResponseHttp;
use Easy\Wallet\Repositories\UserRepository;

class UserService extends AbstractService
{
    public function __construct(
        protected readonly UserRepository $repository,
        protected readonly BalanceService $balanceService
    ) {
    }

    public function getUserById(int $userId): ShowUserDTO|ResponseHttp
    {
        $user = $this->repository->findById($userId);
        if ($user) {
            $balance = $this->balanceService->getBalance($userId);

            return new ShowUserDTO(
                $user['id'],
                $user['name'],
                $user['email'],
                $user['type'] === 'F' ? "PESSOA" : "LOJISTA",
                $user['document'],
                $user['phone'],
                $this->toMonetaryNumber($balance),
            );
        }

        return ResponseHttp::response(404, ['message' => 'Usuário não encontrado']);
    }

    public function delete(int $userId): ResponseHttp
    {
        $user = $this->repository->findById($userId);
        if (empty($user)) {
            return ResponseHttp::response(404, ['message' => 'Usuário não encontrado']);
        }

        $balance = $this->balanceService->getBalance($userId);

        if ($balance > 0) {
            return ResponseHttp::response(400, ['message' => 'Não foi possível deletar, usuário possui saldo']);
        }

        if ($this->repository->delete($user)) {
            return ResponseHttp::response(200, ['message' => 'Usuário deletado com sucesso']);
        }

        return ResponseHttp::response(400, ['message' => 'Não foi possível deletar usuário']);
    }

    public function register(CreateUserDTO $user): ResponseHttp
    {
        if ($this->repository->existsData(field: 'email', data: $user->email)) {
            return ResponseHttp::response(409, ['message' => 'Não foi possível salvar, email em uso']);
        }

        if ($this->repository->existsData(field: 'document', data: $user->document)) {
            return ResponseHttp::response(409, ['message' => 'Não foi possível salvar, documento em uso']);
        }

        $userEntity = new User(
            $user->name,
            $user->email,
            $this->hashPassword($user->email),
            $user->type,
            $user->document,
            $user->phone
        );

        $res = $this->repository->register((array) $userEntity);

        if ($res) {
            $persistedUser = $this->getUserById((int) $res);

            return ResponseHttp::response(200, ['message' => 'Novo usuário criado com sucesso', 'data' => $persistedUser]);
        }

        return ResponseHttp::response(400, ['message' => 'Não foi possível criar novo usuário']);
    }

    public function update(array $user): ResponseHttp
    {
        if (isset($user['email'])) {
            if ($this->repository->existsData(field: 'email', data: $user['email'])) {
                return ResponseHttp::response(409, ['message' => 'Não foi possível salvar, email em uso']);
            }
        }

        if (isset($user['document'])) {
            if ($this->repository->existsData(field: 'email', data: $user['document'])) {
                return ResponseHttp::response(409, ['message' => 'Não foi possível salvar, email em uso']);
            }
        }

        if (isset($user['password'])) {
            $user['password'] = $this->hashPassword($user['password']);
        }

        $possibleUpdate = ['name', 'email', 'document', 'phone', 'password'];
        $update = [];
        foreach ($user as $key => $data) {
            if (in_array($key, $possibleUpdate)) {
                $update[] = "{$key} = '{$data}'";
            }
        }

        $res = $this->repository->update(implode(',', $update), $user['id']);

        if ($res) {
            $updatedUser = $this->getUserById($user['id']);

            return ResponseHttp::response(200, ['message' => 'Usuário atualizado com sucesso', 'data' => $updatedUser]);
        }

        return ResponseHttp::response(400, ['message' => 'Não foi possível atualizar novo usuário']);
    }

    public function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_ARGON2ID);
    }
}
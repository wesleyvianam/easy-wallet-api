<?php

namespace Easy\Wallet\Services;

use Easy\Wallet\Domain\DTO\CreateUserDTO;
use Easy\Wallet\Repositories\BalanceRepository;
use Easy\Wallet\Repositories\UserRepository;

class UserService extends AbstractService
{
    public function __construct(
        protected readonly UserRepository $repository,
        protected readonly BalanceRepository $balanceRepository
    ) {
    }

    public function getUserById(int $userId): array
    {
        $user = $this->repository->findById($userId);
        if ($user) {
            $balance = $this->balanceRepository->findByUserId($userId)['value'];

            $user['balance'] = $this->toMonetaryNumber((int) $balance);

            return self::response('200', $user);
        }

        return self::response('404', ['message' => 'Usuário não encontrado']);
    }

    public function delete(int $userId): array
    {
        $user = $this->repository->findById($userId);
        if (empty($user)) {
            return self::response('404', ['message' => 'Usuário não encontrado']);
        }

        $balance = $this->balanceRepository->findByUserId($userId)['value'];

        if ($balance != 0) {
            return self::response('400', ['message' => 'Não foi possível deletar, usuário possui saldo']);
        }

        if ($this->repository->delete($user)) {
            return self::response('200', ['message' => 'Usuário deletado com sucesso']);
        }

        return self::response('400', ['message' => 'Não foi possível deletar usuário']);
    }

    public function register(CreateUserDTO $user): array
    {
        if ($this->repository->isUnique(field: 'email', data: $user->email)) {
            return self::response('400', ['message' => 'Não foi possível salvar, email em uso']);
        }

        if ($this->repository->isUnique(field: 'document', data: $user->document)) {
            return self::response('400', ['message' => 'Não foi possível salvar, email em uso']);
        }

        if ($this->repository->register((array) $user)) {
            return self::response('200', ['message' => 'Novo usuário criado com sucesso']);
        }

        return self::response('400', ['message' => 'Não foi possível criar novo usuário']);
    }

    public function update(array $data): array
    {
    }
}
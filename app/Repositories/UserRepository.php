<?php

declare(strict_types=1);

namespace Easy\Wallet\Repositories;

use Easy\Wallet\Domain\DTO\CreateUserDTO;
use Easy\Wallet\Domain\Entity\User;
use PDO;

class UserRepository
{
    public function __construct(
        protected readonly PDO $pdo
    ) {
    }

    public function existsData(string $field, string $data): int
    {
        $sql = "SELECT COUNT({$field}) AS quantity FROM users WHERE {$field} = '{$data}'";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_ASSOC)['quantity'];
    }

    public function findById(int $userId): array
    {
        $sql = "SELECT id, name, email, type, active FROM users WHERE id = ?";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $userId, PDO::PARAM_INT);
        $statement->execute();
        $user = $statement->fetch(\PDO::FETCH_ASSOC);

        if ($user) {
            return $user;
        }

        return [];
    }

    public function delete(array $user): bool
    {
        $sql = "UPDATE users SET active = 0 WHERE id = ?";

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $user['id'], PDO::PARAM_INT);

        return $statement->execute();
    }

    public function register(User $user): bool
    {
        $sql = <<<SQL
            INSERT INTO users
                name, email, password, type, document, active, phone
            VALUES 
                {$user->name},
                {$user->email},
                {$user->password},
                {$user->type},
                {$user->document},
                {$user->active},
                {$user->phone};
        SQL;
        $statement = $this->pdo->prepare($sql);

        return $statement->execute();
    }

    public function update(string $update, int $userId): bool
    {
        $sql = "UPDATE users SET {$update} WHERE id = {$userId}";

        $statement = $this->pdo->prepare($sql);

        return $statement->execute();
    }
}
<?php

declare(strict_types=1);

namespace Easy\Wallet\Repositories;

use PDO;

class UserRepository
{
    public function __construct(
        protected readonly PDO $pdo
    ) {
    }

    public function existsData(string $field, string $data): int
    {
        $sql = <<<SQL
            SELECT COUNT({$field}) AS quantity FROM users WHERE {$field} = '{$data}'
        SQL;

        $statement = $this->pdo->prepare($sql);
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_ASSOC)['quantity'];
    }

    public function findById(int $userId): array
    {
        $sql = <<<SQL
            SELECT id, name, email, type, document, phone FROM users WHERE id = ? 
        SQL;

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
        $sql = <<<SQL
            UPDATE users SET active = 0 WHERE id = ? 
        SQL;

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $user['id'], PDO::PARAM_INT);

        return $statement->execute();
    }

    public function register(array $user): bool|string
    {
        $sql = <<<SQL
            INSERT INTO users (name, email, password, type, document, active, phone)
            VALUES (:name, :email, :password, :type, :document, :active, :phone);
        SQL;

        $statement = $this->pdo->prepare($sql);

        $statement->bindParam(':name', $user['name']);
        $statement->bindParam(':email', $user['email']);
        $statement->bindParam(':password', $user['password']);
        $statement->bindParam(':type', $user['type']);
        $statement->bindParam(':document', $user['document']);
        $statement->bindParam(':active', $user['active']);
        $statement->bindParam(':phone', $user['phone']);

        $result = $statement->execute();

        if ($result) {
            return $this->pdo->lastInsertId();
        }

        return false;
    }

    public function update(string $update, int $userId): bool
    {
        $sql = <<<SQL
            UPDATE users SET {$update} WHERE id = {$userId}
        SQL;

        $statement = $this->pdo->prepare($sql);

        return $statement->execute();
    }
}
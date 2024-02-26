<?php

declare(strict_types=1);

namespace Easy\Wallet\Repositories;

use Easy\Wallet\Domain\DTO\CreateUserDTO;
use PDO;

class UserRepository
{
    public function __construct(
        protected readonly PDO $pdo
    ) {
    }

    public function isUnique(string $field, string $data): int
    {
        $sql = "SELECT COUNT({$field}) FROM users WHERE {$field} = {$data}";

        $statement = $this->pdo->prepare($sql);
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_ASSOC);
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

    public function register(array $user)
    {
        $sql = "
            INSERT INTO users
                (name, email, password, type, document, active = 1)
            VALUES 
                (:name, :email, :password, :type, :document)";

        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':name', $user->type, PDO::PARAM_INT);
        $statement->bindParam(':email', $user['subType']);
        $statement->bindParam(':password', $user['userId'], PDO::PARAM_INT);
        $statement->bindParam(':type', $user['value'], PDO::PARAM_INT);
        $statement->bindParam(':document', $user['status'], PDO::PARAM_INT);

        return $statement->execute();
    }
}
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

    public function findById(int $userId): array
    {
        $sql = "
            SELECT 
                id, 
                name,
                email,
                type,
                active
            FROM 
                users
            WHERE id = ?
        ";

        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $userId, PDO::PARAM_INT);
        $statement->execute();
        $user = $statement->fetch(\PDO::FETCH_ASSOC);

        if ($user) {
            return $user;
        }

        return [];
    }
}
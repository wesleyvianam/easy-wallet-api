<?php

declare(strict_types=1);

namespace Easy\Wallet\Repositories;

use PDO;

readonly class BalanceRepository
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    public function findByUserId(int $userId): array
    {
        $sql = <<<SQL
            SELECT 
                SUM(IF(sub_type = 'I', `value`, 0)) - SUM(IF(sub_type = 'E', `value`, 0)) AS `value` 
            FROM 
                transactions
            WHERE 
                user_id = ?
                AND status = 1
        SQL;
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $userId);
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }
}
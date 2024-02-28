<?php

declare(strict_types=1);

namespace Easy\Wallet\Repositories;

use Easy\Wallet\Domain\DTO\ShowTransactionsDTO;
use PDO;

class TransactionRepository
{
    public function __construct(
        protected readonly PDO $pdo
    ) {
    }

    public function register(array $transaction): bool
    {
        $sql = <<<SQL
            INSERT INTO transactions
                (`type`, sub_type, user_id, `value`, `status`)
            VALUES 
                (:type, :sub_type, :user_id, :value, :status)
        SQL;

        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':type', $transaction['type'], PDO::PARAM_INT);
        $statement->bindParam(':sub_type', $transaction['subType']);
        $statement->bindParam(':user_id', $transaction['userId'], PDO::PARAM_INT);
        $statement->bindParam(':value', $transaction['value'], PDO::PARAM_INT);
        $statement->bindParam(':status', $transaction['status'], PDO::PARAM_INT);

        return $statement->execute();
    }

    public function findAllByUser(int $userId): array
    {
        $sql = <<<SQL
            SELECT 
                t.id,
                t.status,
                t.type,
                t.sub_type,
                t.value,
                u.id AS user_id,
                u.name AS user_name,
                CONVERT_TZ(t.created_at, 'UTC', 'America/Sao_Paulo') AS created_at
            FROM 
                transactions t
                INNER JOIN users u ON u.id = t.user_id
            WHERE
                t.user_id = ?
        SQL;

        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(1, $userId, PDO::PARAM_INT);
        $statement->execute();

        $transactions = $statement->fetchAll(\PDO::FETCH_ASSOC);

        if (empty($transactions)) {
            return [
                'code' => 404,
                'data' => ['message' => 'Usuário não possuí transações.']
            ];
        }

        return [
            'code' => 200,
            'data' => array_map($this->hydrateHistory(...), $transactions)
        ];
    }

    private function hydrateHistory($transaction): ShowTransactionsDTO
    {
        return new ShowTransactionsDTO(
            $transaction['id'],
            $transaction['user_name'],
            $transaction['user_id'],
            $transaction['type'],
            $transaction['sub_type'],
            $transaction['status'],
            $transaction['value'],
            $transaction['created_at'],
        );
    }
}
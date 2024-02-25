<?php

namespace Easy\Wallet\Repositories;

use PDO;

class TransactionRepository
{
    public function __construct(
        protected readonly PDO $pdo
    ) {
    }

    public function register(array $transaction): void
    {
        $sql = "INSERT INTO transactions
        (`type`, sub_type, user_id, wallet_id, reversed_from, `value`, `status`)
        VALUES (:type, :sub_type, :user_id, :wallet_id, :reversed_from, :value, :status)";

        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':type', $transaction['type'], PDO::PARAM_INT);
        $statement->bindParam(':sub_type', $transaction['subType']);
        $statement->bindParam(':user_id', $transaction['userId'], PDO::PARAM_INT);
        $statement->bindParam(':wallet_id', $transaction['walletId'], PDO::PARAM_INT);
        $statement->bindParam(':reversed_from', $transaction['reversedFrom']);
        $statement->bindParam(':value', $transaction['value'], PDO::PARAM_INT);
        $statement->bindParam(':status', $transaction['status'], PDO::PARAM_INT);

        $statement->execute();
    }
}
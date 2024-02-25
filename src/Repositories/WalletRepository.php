<?php

declare(strict_types=1);

namespace Easy\Wallet\Repositories;

use Easy\Wallet\Domain\Wallet\DTO\ShowWalletDTO;
use Easy\Wallet\Domain\Wallet\Entity\Wallet;
use Easy\Wallet\Model\User\DTO\CreateData;
use Easy\Wallet\Model\User\Entity\User;
use PDO;

class WalletRepository
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    public function save(Wallet $user): void
    {
    }

    public function find(int $user_id)
    {
        $sql = "SELECT * FROM wallets WHERE user_id = ?";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $user_id);
        $statement->execute();
        $wallet = $statement->fetch(\PDO::FETCH_ASSOC);

        if ($wallet) {
            return $this->hydrateWallet($wallet);
        }

        return [];
    }

    private function hydrateWallet(array $data): array
    {
        $wallet = new ShowWalletDTO(
            $data['id'],
            $data['balance']
        );
        
        return [
            'id' => $wallet->id,
            'balance' => $wallet->getBalance()
        ];
    }
}
<?php

declare(strict_types=1);

namespace Easy\Wallet\Repositories;

use Easy\Wallet\Domain\Wallet\DTO\CreateDepositDTO;
use Easy\Wallet\Domain\Wallet\DTO\ShowWalletDTO;
use Easy\Wallet\Domain\Wallet\Entity\Wallet;
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

    public function find(int $userId): array
    {
        $sql = "SELECT id, balance FROM wallets WHERE user_id = ?";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $userId);
        $statement->execute();
        $wallet = $statement->fetch(\PDO::FETCH_ASSOC);

        if ($wallet) {
            return $this->hydrateWallet($wallet);
        }

        return [];
    }

    public function deposit(CreateDepositDTO $deposit): bool
    {
        $sql = "UPDATE wallets SET balance = {$deposit->balance} WHERE user_id = {$deposit->user}";
        $statement = $this->pdo->prepare($sql);

        return $statement->execute();
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
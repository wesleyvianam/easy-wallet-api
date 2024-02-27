<?php

declare(strict_types=1);

namespace Easy\Wallet\Domain\Entity;

use Easy\Wallet\Domain\Enum\TransactionSubtypeEnum;
use Easy\Wallet\Domain\Enum\TransactionTypeEnum;

readonly class Transaction
{
    public function __construct(
        public TransactionTypeEnum $type,
        public TransactionSubtypeEnum $subType,
        public int $userId,
        public int $value,
        public int $status,
    ) {
    }
}
<?php

declare(strict_types=1);

namespace Easy\Wallet\Domain\Entity;

readonly class Transaction
{
    public function __construct(
        public int $type,
        public string $subType,
        public int $userId,
        public int $value,
        public int $status,
    ) {
    }
}
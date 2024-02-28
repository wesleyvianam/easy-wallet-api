<?php

declare(strict_types=1);

namespace Easy\Wallet\Domain\DTO;

readonly class  TransactionRegisterDTO
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
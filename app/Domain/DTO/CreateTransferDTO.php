<?php

declare(strict_types=1);

namespace Easy\Wallet\Domain\DTO;

readonly class CreateTransferDTO
{
    public function __construct(
        public int $userFrom,
        public int $userTo,
        public int $value,
    ) {
    }
}
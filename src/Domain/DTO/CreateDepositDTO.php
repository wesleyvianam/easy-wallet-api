<?php

namespace Easy\Wallet\Domain\DTO;

class CreateDepositDTO
{
    public function __construct(
        public readonly int $user,
        public int $value,
        public int $balance,
    ) {
    }
}
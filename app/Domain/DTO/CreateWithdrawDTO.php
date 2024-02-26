<?php

namespace Easy\Wallet\Domain\DTO;

class CreateWithdrawDTO
{
    public function __construct(
        public readonly int $user,
        public int $value,
        public int $balance,
    ) {
    }
}
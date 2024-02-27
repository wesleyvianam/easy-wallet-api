<?php

namespace Easy\Wallet\Domain\DTO;

readonly class CreateDepositDTO
{
    public function __construct(
        public int $user,
        public int $value,
    ) {
    }
}
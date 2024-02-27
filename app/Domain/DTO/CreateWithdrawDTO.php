<?php

namespace Easy\Wallet\Domain\DTO;

readonly class CreateWithdrawDTO
{
    public function __construct(
        public int $user,
        public int $value,
    ) {
    }
}
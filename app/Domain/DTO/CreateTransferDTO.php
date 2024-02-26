<?php

namespace Easy\Wallet\Domain\DTO;

class CreateTransferDTO
{
    public function __construct(
        public readonly int $userFrom,
        public readonly int $userTo,
        public int $value,
    ) {
    }
}
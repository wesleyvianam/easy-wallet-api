<?php

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
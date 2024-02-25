<?php

namespace Easy\Wallet\Domain\Wallet\Entity;

class Wallet
{
    private int $id;

    public function __construct(
        public readonly int $balance,
        public readonly string $user_id,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }
}
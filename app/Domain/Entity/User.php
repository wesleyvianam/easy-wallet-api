<?php

declare(strict_types=1);

namespace Easy\Wallet\Domain\Entity;

class User
{
    private int $userId;

    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
        public readonly string $type,
        public readonly string $active,
        public readonly string $document,
    ) {
    }

    public function getId(): int
    {
        return $this->userId;
    }
}
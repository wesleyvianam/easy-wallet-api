<?php

declare(strict_types=1);

namespace Easy\Wallet\Domain\DTO;

readonly class CreateUserDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public string $type,
        public string $document,
        public ?string $phone = null,
    ) {
    }
}
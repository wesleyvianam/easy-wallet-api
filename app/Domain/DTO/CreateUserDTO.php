<?php

namespace Easy\Wallet\Domain\DTO;

readonly class CreateUserDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public string $type,
        public string $active,
        public string $document,
        public string $phone,
    ) {
    }
}
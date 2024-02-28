<?php

declare(strict_types=1);

namespace Easy\Wallet\Domain\DTO;

readonly class ShowUserDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public string $type,
        public string $document,
        public string $phone,
        public string $balance
    ) {
    }
}

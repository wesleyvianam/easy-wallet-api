<?php

namespace Easy\Wallet\Domain\Transaction\DTO;

class TransactionRegisterDTO
{
    public function __construct(
        public readonly int $type,
        public readonly  string $subType,
        public readonly  int $userId,
        public readonly  int $walletId,
        public readonly  int $value,
        public readonly  int $status,
        public readonly  ?int $reversedFrom = null,
    ) {
    }

    public function getReversedFrom(): ?int
    {
        return $this->reversedFrom;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getSubType(): string
    {
        return $this->subType;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getWalletId(): int
    {
        return $this->walletId;
    }
}
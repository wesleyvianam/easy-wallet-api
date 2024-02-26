<?php

namespace Easy\Wallet\Domain\Enum;

enum TransactionTypeEnum: int
{
    case DEPOSIT = 1;
    case WITHDRAW = 2;
    case TRANSFER = 3;

    public function getType():string
    {
        return match ($this) {
            self::DEPOSIT => 'DEPÓSITO',
            self::WITHDRAW => 'SAQUE',
            self::TRANSFER => 'TRANSFERÊNCIA',
        };
    }
}
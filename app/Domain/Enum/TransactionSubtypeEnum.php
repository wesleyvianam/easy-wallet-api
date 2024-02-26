<?php

namespace Easy\Wallet\Domain\Enum;

enum TransactionSubtypeEnum: string
{
    case INCOME = 'I';
    case EXPENSE = 'E';

    public function getType(): string
    {
        return match ($this) {
            self::INCOME => 'ENTRADA',
            self::EXPENSE => 'SAÍDA',
        };
    }
}
<?php

namespace Easy\Wallet\Domain\Enum;

enum StatusEnum: int
{
    case REFUSED = 0;
    case SUCCESS = 1;

    public function getStatus():string
    {
        return match ($this) {
            self::REFUSED => 'NÃO AUTORIZADO',
            self::SUCCESS => 'SUCESSO',
        };
    }
}

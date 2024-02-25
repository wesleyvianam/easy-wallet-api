<?php

namespace Easy\Wallet\Domain\Wallet\DTO;

class ShowWalletDTO
{
    public function __construct(
        public readonly int $id,
        private string|int $balance
    ){
        $this->balance = $this->convertToBrl($balance);
    }

    private function convertToBrl(int $value): string
    {
        return number_format($value / 100, 2, ',', '.');
    }

    public function getBalance(): string
    {
        return $this->balance;
    }
}
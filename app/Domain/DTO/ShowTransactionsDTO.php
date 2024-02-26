<?php

namespace Easy\Wallet\Domain\DTO;

class ShowTransactionsDTO
{
    public readonly int $transactionId;
    public readonly int $userId;
    public readonly string $userName;
    public readonly string $type;
    public readonly string $subtype;
    public readonly string $status;
    public readonly string $value;
    public readonly string $createdAt;

    public function __construct($transactionId, $userName, $userId, $type, $subtype, $status, $value, $createdAt)
    {
        $this->transactionId = $transactionId;
        $this->userName = $userName;
        $this->userId = $userId;
        $this->type = $this->types($type);
        $this->subtype = $this->subTypes($subtype);
        $this->status = $this->status($status);
        $this->value = $this->monetaryFormat($value);
        $this->createdAt = $createdAt;
    }

    private function types(int $type): string
    {
        $types = [
            1 => 'DEPOSIT',
            2 => 'WITHDRAW',
            3 => 'TRANSFER',
        ];

        return $types[$type];
    }

    private function subTypes(string $subtype): string
    {
        $types = [
            'I' => 'INCOME',
            'E' => 'EXPENSE'
        ];

        return $types[$subtype];
    }

    private function status(int $status): string
    {
        $types = [
            0 => 'REFUSED',
            1 => 'SUCCESS',
        ];

        return $types[$status];
    }

    private function monetaryFormat(int $value): string
    {
        return number_format($value / 100, 2, ',', '.');
    }
}
<?php

namespace Easy\Wallet\Domain\DTO;

class ShowTransactionsDTO
{
    public readonly int $id;
    public readonly int $userId;
    public readonly string $userName;
    public readonly string $type;
    public readonly string $subtype;
    public readonly string $status;
    public readonly string $value;
    public readonly string $created_at;

    public function __construct($id, $userName, $userId, $type, $subtype, $status, $value, $created_at)
    {
        $this->id = $id;
        $this->userName = $userName;
        $this->userId = $userId;
        $this->type = $this->types($type);
        $this->subtype = $this->subTypes($subtype);
        $this->status = $this->status($status);
        $this->value = $this->monetaryFormat($value);
        $this->created_at = $created_at;
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

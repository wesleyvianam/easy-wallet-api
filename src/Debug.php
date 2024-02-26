<?php

namespace Easy\Wallet;
readonly class Debug
{
    public static function dd(string|int|array $data): void
    {
        echo "<pre>";
        print_r($data);
        die;
    }
}
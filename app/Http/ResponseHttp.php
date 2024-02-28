<?php

declare(strict_types=1);

namespace Easy\Wallet\Http;

readonly class ResponseHttp
{
    public function __construct(
        public int $code,
        public array $body,
        public ?array $header = ['Content-Type' => 'application/json'],
    ) {
    }

    public function body(): string
    {
        return json_encode($this->body);
    }
}
<?php

declare(strict_types=1);

namespace Easy\Wallet\Http;

readonly class ResponseHttp
{
    public function __construct(
        public int $code,
        public string $body,
        public ?array $header = ['Content-Type' => 'application/json'],
    ) {
    }

    public static function response(
        int $code,
        array $body,
        $header = ['Content-Type' => 'application/json']
    ): self {
        return new self(
            code: $code,
            body: json_encode($body),
            header: $header
        );
    }
}
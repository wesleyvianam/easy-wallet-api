<?php

declare(strict_types=1);

namespace Easy\Wallet\Services;

use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractService
{
    public static function response(int $code, array $data): array
    {
        return [
            'code' => $code,
            'data' => $data
        ];
    }

    public function hydrateData(ServerRequestInterface $request): array
    {
        $data = json_decode($request->getBody()->getContents(), true);

        if (isset($data['value'])) {
            $data['value'] = $this->monetaryToInt($data['value']);
        }

        return $data;
    }

    public function monetaryToInt(string $value): int
    {
        return (int) str_replace(['.', ','], '', $value);
    }

    public function toMonetaryNumber(int $value): string
    {
        return number_format($value / 100, 2, ',', '.');
    }
}
<?php

declare(strict_types=1);

namespace Easy\Wallet\Services;

use Easy\Wallet\Http\ResponseHttp;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractService
{
    public function hydrateData(ServerRequestInterface $request, array $required = []): array|ResponseHttp
    {
        $data = json_decode($request->getBody()->getContents(), true);

        $sendFields = array_keys($data);
        foreach ($required as $field) {
            if (false === in_array($field, $sendFields)) {
                return ResponseHttp::response(422, ['message' => 'Dados não enviados, consulte a documentação.']);
            }
        }

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
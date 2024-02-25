<?php

namespace Easy\Wallet\Services;

use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractService
{
    public static function exception(int $code, array $data): array
    {
        return [
            'code' => 404,
            'data' => $data
        ];
    }

    public function hydrateData(ServerRequestInterface $request): array
    {
        $data = json_decode($request->getBody()->getContents(), true);

        if (isset($data['value'])) {
            $data['value'] = $this->monetaryFormat($data['value']);
        }

        return $data;
    }

    public function monetaryFormat(string $value): int
    {
        return (int) str_replace(['.', ','], '', $value);
    }
}
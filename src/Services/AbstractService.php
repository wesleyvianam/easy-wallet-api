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
        return json_decode($request->getBody()->getContents(), true);
    }
}
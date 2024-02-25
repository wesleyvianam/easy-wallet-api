<?php

namespace Easy\Wallet\Services;

use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractService
{
    public function hydrateData(ServerRequestInterface $request): array
    {
        return json_decode($request->getBody()->getContents(), true);
    }
}
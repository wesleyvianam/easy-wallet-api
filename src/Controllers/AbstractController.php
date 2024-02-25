<?php

declare(strict_types=1);

namespace Easy\Wallet\Controllers;

use Psr\Http\Server\RequestHandlerInterface;

abstract class AbstractController implements RequestHandlerInterface
{
    protected function getIdUri($uri): int
    {
        preg_match_all(
            '/\d+/',
            $uri,
            $id
        );

        return (int) $id[0][0];
    }
}
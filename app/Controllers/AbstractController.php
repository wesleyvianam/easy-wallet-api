<?php

declare(strict_types=1);

namespace Easy\Wallet\Controllers;

use Psr\Http\Server\RequestHandlerInterface;

abstract class AbstractController implements RequestHandlerInterface
{
    protected function getUserId($uri): int
    {
        preg_match_all(
            '/\d+/',
            $uri,
            $userId
        );

        return (int) $userId[0][0];
    }
}
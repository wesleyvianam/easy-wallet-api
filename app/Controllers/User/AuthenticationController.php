<?php

declare(strict_types=1);

namespace Easy\Wallet\Controllers\User;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Easy\Wallet\Controllers\AbstractController;
use Easy\Wallet\Services\UserService;

class AuthenticationController extends AbstractController
{
    public function __construct(
        protected readonly UserService $service
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new Response(200, []);
    }
}

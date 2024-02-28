<?php

declare(strict_types=1);

namespace Easy\Wallet\Controllers;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class NotFountController extends AbstractController
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new Response(404, body: json_encode(['message' => 'Rota não encontrada']));
    }
}
<?php

namespace Easy\Wallet\Controllers\Transaction;

use Easy\Wallet\Controllers\AbstractController;
use Easy\Wallet\Services\BalanceService;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetBalanceController extends AbstractController
{
    public function __construct(
        protected readonly BalanceService $service
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $userId = $this->getUserId($request->getServerParams()['REQUEST_URI']);

        $res = $this->service->getAmount($userId);

        return new Response($res['code'], body: json_encode($res['data']));
    }
}
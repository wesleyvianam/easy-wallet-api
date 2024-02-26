<?php

namespace Easy\Wallet\Controllers\Transaction;

use Easy\Wallet\Controllers\AbstractController;
use Easy\Wallet\Domain\DTO\CreateWithdrawDTO;
use Easy\Wallet\Services\WithdrawService;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class WithdrawController extends AbstractController
{
    public function __construct(
        protected readonly WithdrawService $service
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $userId = $this->getIdUri($request->getServerParams()['REQUEST_URI']);
        $hydratedData = $this->service->hydrateData($request);

        $withdraw = new CreateWithdrawDTO($userId, $hydratedData['value'], $hydratedData['value']);

        $res = $this->service->withdraw($withdraw);

        return new Response($res['code'], body: json_encode($res['data']));
    }
}
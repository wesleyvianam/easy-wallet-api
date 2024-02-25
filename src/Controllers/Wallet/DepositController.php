<?php

namespace Easy\Wallet\Controllers\Wallet;

use Easy\Wallet\Controllers\AbstractController;
use Easy\Wallet\Domain\Wallet\DTO\CreateDepositDTO;
use Easy\Wallet\Services\DepositService;
use Easy\Wallet\Services\TransactionService;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DepositController extends AbstractController
{
    public function __construct(
        protected readonly DepositService $service
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $userId = $this->getIdUri($request->getServerParams()['REQUEST_URI']);
        $hydratedData = $this->service->hydrateData($request);

        $deposit = new CreateDepositDTO($userId, $hydratedData['value'], $hydratedData['value'], null);

        $res = $this->service->deposit($deposit);

        return new Response($res['code'], body: json_encode(['message' => $res['message']]));
    }
}
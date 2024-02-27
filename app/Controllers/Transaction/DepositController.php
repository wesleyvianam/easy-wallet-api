<?php

declare(strict_types=1);

namespace Easy\Wallet\Controllers\Transaction;

use Easy\Wallet\Controllers\AbstractController;
use Easy\Wallet\Domain\DTO\CreateDepositDTO;
use Easy\Wallet\Services\DepositService;
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
        $userId = $this->getUserId($request->getServerParams()['REQUEST_URI']);
        $hydratedData = $this->service->hydrateData($request);

        $deposit = new CreateDepositDTO($userId, $hydratedData['value']);

        $res = $this->service->deposit($deposit);

        return new Response($res['code'], body: json_encode($res['data']));
    }
}
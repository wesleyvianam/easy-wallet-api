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

        $resData = $this->service->hydrateData($request, ['value']);

        if (is_array($resData)) {
            $deposit = new CreateDepositDTO($userId, $resData['value']);

            $resData = $this->service->deposit($deposit);
        }

        return new Response($resData->code, $resData->header, $resData->body);
    }
}
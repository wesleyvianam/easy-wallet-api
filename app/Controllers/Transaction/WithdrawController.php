<?php

declare(strict_types=1);

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
        $userId = $this->getUserId($request->getServerParams()['REQUEST_URI']);

        $resData = $this->service->hydrateData($request, ['value']);

        if (is_array($resData)) {
            $withdraw = new CreateWithdrawDTO($userId, $resData['value']);

            $resData = $this->service->withdraw($withdraw);
        }

        return new Response($resData->code, $resData->header, $resData->body);
    }
}
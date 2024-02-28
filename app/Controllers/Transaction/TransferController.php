<?php

declare(strict_types=1);

namespace Easy\Wallet\Controllers\Transaction;

use Easy\Wallet\Controllers\AbstractController;
use Easy\Wallet\Domain\DTO\CreateTransferDTO;
use Easy\Wallet\Services\TransferService;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TransferController extends AbstractController
{
    public function __construct(
        protected readonly TransferService $service
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $userId = $this->getUserId($request->getServerParams()['REQUEST_URI']);

        $resData = $this->service->hydrateData($request , ['value', 'user_to']);

        if (is_array($resData)) {
            $transfer = new CreateTransferDTO(
                $userId,
                $resData['user_to'],
                $resData['value']
            );

            $resData = $this->service->transfer($transfer);
        }

        return new Response($resData->code, $resData->header, $resData->body);
    }
}
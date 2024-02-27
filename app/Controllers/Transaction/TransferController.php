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
        $hydratedData = $this->service->hydrateData($request);

        if (
            false === isset($hydratedData['value']) ||
            false === isset($hydratedData['user_to'])
        ) {
            return new Response(
                422,
                body: json_encode(['message' => 'Dados esperados não enviados, consulte a documentação.'])
            );
        }

        $transfer = new CreateTransferDTO(
            $userId,
            $hydratedData['user_to'],
            $hydratedData['value']
        );

        $res = $this->service->transfer($transfer);

        return new Response($res['code'], body: json_encode($res['data']));
    }
}
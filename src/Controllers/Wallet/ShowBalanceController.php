<?php

namespace Easy\Wallet\Controllers\Wallet;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Easy\Wallet\Repositories\WalletRepository;
use Easy\Wallet\Controllers\AbstractController;

class ShowBalanceController extends AbstractController
{
    public function __construct(
        protected readonly WalletRepository $repository
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $userId = $this->getIdUri($request->getServerParams()['REQUEST_URI']);

        $balance = $this->repository->find($userId);

        if (empty($balance)) {
            return new Response(
                404,
                body: json_encode(["message" => "Carteira não encontrada"])
            );
        }

        return new Response(
            200,
            body: json_encode($balance)
        );
    }
}
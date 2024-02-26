<?php

namespace Easy\Wallet\Controllers\Transaction;

use Easy\Wallet\Controllers\AbstractController;
use Easy\Wallet\Repositories\TransactionRepository;
use Easy\Wallet\Repositories\BalanceRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HistoryController extends AbstractController
{
    public function __construct(
        protected readonly TransactionRepository $repository
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $userId = $this->getIdUri($request->getServerParams()['REQUEST_URI']);

        $res = $this->repository->findAllByUser($userId);

        return new Response($res['code'], body: json_encode($res['data']));
    }
}
<?php

declare(strict_types=1);

namespace Easy\Wallet\Controllers\User;

use Easy\Wallet\Services\UserService;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Easy\Wallet\Controllers\AbstractController;

class DeleteController extends AbstractController
{
    public function __construct(
        protected readonly UserService $service
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $userId = $this->getUserId($request->getServerParams()['REQUEST_URI']);

        $res = $this->service->delete($userId);

        return new Response($res['code'], body: json_encode($res['data']));
    }
}
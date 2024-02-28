<?php

declare(strict_types=1);

namespace Easy\Wallet\Controllers\User;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Easy\Wallet\Controllers\AbstractController;
use Easy\Wallet\Services\UserService;

class UpdateController extends AbstractController
{
    public function __construct(
        protected readonly UserService $service
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $userId = $this->getUserId($request->getServerParams()['REQUEST_URI']);
        $resData = $this->service->hydrateData($request);

        if (is_array($resData) && false === empty($resData)) {
            $resData['id'] = $userId;

            $resData = $this->service->update($resData);
        }

        return new Response($resData->code, $resData->header, $resData->body);
    }
}
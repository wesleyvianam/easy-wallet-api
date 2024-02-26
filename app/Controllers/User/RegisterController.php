<?php

declare(strict_types=1);

namespace Easy\Wallet\Controllers\User;

use Easy\Wallet\Domain\DTO\CreateUserDTO;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Easy\Wallet\Controllers\AbstractController;
use Easy\Wallet\Services\UserService;

class RegisterController extends AbstractController
{
    public function __construct(
        protected readonly UserService $service
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $hydratedData = $this->service->hydrateData($request);

        $res = $this->service->register(
            new CreateUserDTO(
                $hydratedData['name'],
                $hydratedData['email'],
                $hydratedData['password'],
                $hydratedData['type'],
                $hydratedData['document']
            )
        );

        return new Response($res['code'], body: json_encode($res['data']));
    }
}
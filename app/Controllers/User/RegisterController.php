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
        $resData = $this->service->hydrateData(
            $request,
            ['name','email','password','type','document','phone']
        );

        if (is_array($resData)) {
            $resData = $this->service->register(new CreateUserDTO(...$resData));
        }

        return new Response($resData->code, $resData->header, $resData->body);
    }
}
<?php

declare(strict_types=1);

use Easy\Wallet\Controllers\Wallet\ShowBalanceController;
use Easy\Wallet\Controllers\User\{
    UpdateController,
    RegisterController,
    AuthenticationController,
    LogoutController,
};

return [
    'POST|/login' => AuthenticationController::class,
    'DELETE|/logout' => LogoutController::class,
    'POST|/users' => RegisterController::class,
    'PUT|/users' => UpdateController::class,

    'GET|/user/{id}/balance' => ShowBalanceController::class
];
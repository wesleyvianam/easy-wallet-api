<?php

declare(strict_types=1);

use Easy\Wallet\Controllers\User\{AuthenticationController, LogoutController, RegisterController, UpdateController,};
use Easy\Wallet\Controllers\Wallet\DepositController;
use Easy\Wallet\Controllers\Wallet\ShowBalanceController;

return [
    // User Management
    'POST|/login' => AuthenticationController::class,
    'DELETE|/logout' => LogoutController::class,
    'POST|/users' => RegisterController::class,
    'PUT|/users' => UpdateController::class,

    // Balance and Transaction
    'GET|/user/{id}/balance' => ShowBalanceController::class,
    'POST|/user/{id}/deposit' => DepositController::class,
];
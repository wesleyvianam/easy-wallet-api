<?php

declare(strict_types=1);

use Easy\Wallet\Controllers\Transaction\{WithdrawController};
use Easy\Wallet\Controllers\Transaction\DepositController;
use Easy\Wallet\Controllers\Transaction\GetBalanceController;
use Easy\Wallet\Controllers\Transaction\HistoryController;
use Easy\Wallet\Controllers\Transaction\TransferController;
use Easy\Wallet\Controllers\User\{AuthenticationController, LogoutController, RegisterController, UpdateController};

return [
    // User Management
    'POST|/login' => AuthenticationController::class,
    'DELETE|/logout' => LogoutController::class,
    'POST|/users' => RegisterController::class,
    'PUT|/users' => UpdateController::class,

    // Balance and Transaction
    'GET|/user/{id}/balance' => GetBalanceController::class,
    'PUT|/user/{id}/deposit' => DepositController::class,
    'PUT|/user/{id}/withdraw' => WithdrawController::class,
    'PUT|/user/{id}/transfer' => TransferController::class,
    'GET|/user/{id}/transactions' => HistoryController::class,
];
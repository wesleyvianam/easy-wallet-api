<?php

declare(strict_types=1);

use Easy\Wallet\Controllers\Transaction\{WithdrawController};
use Easy\Wallet\Controllers\Transaction\DepositController;
use Easy\Wallet\Controllers\Transaction\GetBalanceController;
use Easy\Wallet\Controllers\Transaction\HistoryController;
use Easy\Wallet\Controllers\Transaction\TransferController;
use Easy\Wallet\Controllers\User\{GetUserController, DeleteController, RegisterController, UpdateController};

return [
    // User Management
    'POST|/api/user' => RegisterController::class,
    'GET|/api/user/{id}' => GetUserController::class,
    'PUT|/api/user/{id}' => UpdateController::class,
    'DELETE|/api/user/{id}' => DeleteController::class,

    // Balance and Transaction
    'GET|/api/user/{id}/balance' => GetBalanceController::class,
    'POST|/api/user/{id}/deposit' => DepositController::class,
    'POST|/api/user/{id}/withdraw' => WithdrawController::class,
    'POST|/api/user/{id}/transfer' => TransferController::class,
    'GET|/api/user/{id}/transactions' => HistoryController::class,
];
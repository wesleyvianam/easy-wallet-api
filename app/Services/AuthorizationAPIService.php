<?php

declare(strict_types=1);

namespace Easy\Wallet\Services;

use GuzzleHttp\Client;

class AuthorizationAPIService extends AbstractService
{
    public function authorize(): bool
    {
        $client = new Client();

        $apiUrl = 'https://run.mocky.io/v3/5794d450-d2e2-4412-8131-73d0293ac1cc';

        $res = $client->get($apiUrl);

        if ($res->getStatusCode() == 200) {
            return true;
        }

        return false;
    }
}
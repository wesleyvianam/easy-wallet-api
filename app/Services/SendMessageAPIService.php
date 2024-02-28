<?php

declare(strict_types=1);

namespace Easy\Wallet\Services;

use GuzzleHttp\Client;

class SendMessageAPIService extends AbstractService
{
    public static function sms(string $phone): void
    {
        if ($phone) {
            $client = new Client();

            $apiUrl = 'https://run.mocky.io/v3/54dc2cf1-3add-45b5-b5a9-6bf7e7f1f4a6';

            $res = $client->get($apiUrl);

            $res->getStatusCode();
        }
    }

    public static function email(string $email): void
    {
        if ($email) {
            $client = new Client();

            $apiUrl = 'https://run.mocky.io/v3/54dc2cf1-3add-45b5-b5a9-6bf7e7f1f4a6';

            $res = $client->get($apiUrl);

            $res->getStatusCode();
        }
    }

    private function send(string $data): bool
    {
        if ($data) {
            $client = new Client();

            $apiUrl = 'https://run.mocky.io/v3/54dc2cf1-3add-45b5-b5a9-6bf7e7f1f4a6';

            $res = $client->get($apiUrl);

            if ($res->getStatusCode() == 200) {
                return true;
            }
        }

        return false;
    }
}
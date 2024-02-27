<?php

namespace Integration\AuthorizationAPI;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use PHPUnit\Framework\TestCase;

class AuthorizationAPITest extends TestCase
{
    public function testAuthorizationApiIsAvailable()
    {
        $client = new Client();

        $apiUrl = 'https://run.mocky.io/v3/5794d450-d2e2-4412-8131-73d0293ac1cc';

        try {
            $response = $client->get($apiUrl);

            $this->assertEquals(200, $response->getStatusCode());

        } catch (RequestException $e) {
            $this->fail('Falha ao acessar a API: ' . $e->getMessage());
        }
    }
}
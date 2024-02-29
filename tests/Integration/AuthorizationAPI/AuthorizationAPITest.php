<?php

namespace Integration\AuthorizationAPI;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;

class AuthorizationAPITest extends TestCase
{
    public function testAuthorizationApiIsAvailable()
    {
        $client = new Client();

        $apiUrl = 'https://run.mocky.io/v3/5794d450-d2e2-4412-8131-73d0293ac1cc';

        $response = $client->get($apiUrl);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString('{"message": "Autorizado"}', $response->getBody()->getContents());
    }
}
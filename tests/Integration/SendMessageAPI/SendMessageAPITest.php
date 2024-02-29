<?php

namespace Integration\SendMessageAPI;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use PHPUnit\Framework\TestCase;

class SendMessageAPITest extends TestCase
{
    public function testSendMessageApiIsAvailable()
    {
        $client = new Client();

        $apiUrl = 'https://run.mocky.io/v3/54dc2cf1-3add-45b5-b5a9-6bf7e7f1f4a6';

        $response = $client->get($apiUrl);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString('{"message": true}', $response->getBody()->getContents());
    }
}
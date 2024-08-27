<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\Exception;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AddressTest extends ApiTestCase
{
    /**
     * Test get addresses
     * @return void
     * @throws Exception
     * @throws TransportExceptionInterface
     */
    #[Test]
    public function testGetAddresses(): void
    {
        $mockResponse = new MockResponse(json_encode([
            'features' => [
                [
                    "properties" => [
                        "label" => "Rue des Requis 76000 Rouen",
                        "city" => "Rouen",
                        "street" => "Rue des Requis"
                    ],
                    "geometry" => [
                        "coordinates" => [1.103735, 49.444208]
                    ]
                ]
            ]
        ]), ['http_code' => 200, 'headers' => ['Content-Type' => 'application/json']]);

        $httpClientMock = $this->createMock(HttpClientInterface::class);
        $httpClientMock->method('request')
            ->willReturn($mockResponse);

        self::getContainer()->set('http_client', $httpClientMock);

        $query = "rue des requis";
        $response = static::createClient()->request('GET', '/api/address/'.$query, [
            'headers' => ['Accept' => 'application/json']
        ]);

        $this->assertResponseIsSuccessful();
    }
}
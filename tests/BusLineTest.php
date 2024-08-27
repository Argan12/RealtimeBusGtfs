<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\BusLine;
use App\Tests\Factory\BusLineFactory;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class BusLineTest extends ApiTestCase
{
    use ResetDatabase, Factories;

    /**
     * Test get collection of bus lines
     * @return void
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    #[Test]
    public function testGetCollection(): void
    {
        BusLineFactory::createMany(5);

        $response = static::createClient()->request('GET', '/api/bus_lines');
        $this->assertResponseIsSuccessful();

        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        $this->assertJsonContains([
            '@context' => '/api/contexts/BusLine',
            '@id' => '/api/bus_lines',
            '@type' => 'hydra:Collection',
            'hydra:totalItems' => 5
        ]);

        $this->assertCount(5, $response->toArray()['hydra:member']);

        $this->assertMatchesResourceCollectionJsonSchema(BusLine::class);
    }
}

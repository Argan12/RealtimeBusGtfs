<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\BusStop;
use App\Tests\Factory\BusLineFactory;
use App\Tests\Factory\BusStopFactory;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class BusStopTest extends ApiTestCase
{
    use ResetDatabase, Factories;

    /**
     * Test get collection of bus stops
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
        $busLine = BusLineFactory::createOne();

        BusStopFactory::createMany(5, ['route' => $busLine]);

        $response = static::createClient()->request('GET', '/api/bus_stops');
        $this->assertResponseIsSuccessful();

        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        $this->assertJsonContains([
            '@context' => '/api/contexts/BusStop',
            '@id' => '/api/bus_stops',
            '@type' => 'hydra:Collection',
            'hydra:totalItems' => 5
        ]);

        $this->assertCount(5, $response->toArray()['hydra:member']);

        $this->assertMatchesResourceCollectionJsonSchema(BusStop::class);
    }

    /**
     * Test get bus stops with wrong id
     * @return void
     * @throws TransportExceptionInterface
     */
    #[Test]
    public function testGetNotFound(): void
    {
        BusStopFactory::createOne();
        static::createClient()->request('GET', '/api/bus_stops/0');
        $this->assertResponseStatusCodeSame(404);
    }

    /**
     * Test get bus stop
     * @return void
     * @throws TransportExceptionInterface
     */
    #[Test]
    public function testGet(): void
    {
        $id = BusStopFactory::createOne()->getStopId();

        static::createClient()->request('GET', '/api/bus_stops/'.$id);
        $this->assertResponseIsSuccessful();
    }

    /**
     * Test filter bus stops with name and destination
     * @return void
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    #[Test]
    public function testSearch(): void
    {
        $busLine = BusLineFactory::createOne();
        BusStopFactory::createMany(5, ['route' => $busLine]);
        $busStop = BusStopFactory::createOne([
            'destination' => 'Terminus',
            'name' => 'Fake station',
            'route' => $busLine
        ]);

        $response = static::createClient()->request('GET', "/api/bus_stops?search={$busStop->getName()} {$busStop->getDestination()}");
        $this->assertCount(1, $response->toArray()['hydra:member']);
    }
}

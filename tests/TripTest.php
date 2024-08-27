<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Tests\Factory\BusStopFactory;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class TripTest extends ApiTestCase
{
    use ResetDatabase, Factories;
    
    /**
     * Test if trip is not found, 404 is returned
     * @return void
     * @throws TransportExceptionInterface
     */
    #[Test]
    public function testTripNotFound(): void
    {
        BusStopFactory::createOne([
            'stopId' => '10'
        ])->getStopId();

        $client = static::createClient();
        $client->request('GET', '/api/trips/0');

        $this->assertResponseStatusCodeSame(404);
    }

    /**
     * Test if ok, 200 is returned
     * @return void
     * @throws TransportExceptionInterface
     */
    #[Test]
    public function testTripOk(): void
    {
        $stopId = BusStopFactory::createOne()->getStopId();

        $client = static::createClient();
        $client->request('GET', '/api/trips/'.$stopId);

        $this->assertResponseStatusCodeSame(200);
    }
}

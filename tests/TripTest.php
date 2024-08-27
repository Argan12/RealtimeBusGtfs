<?php

namespace App\Tests;

use App\Service\GtfsService;
use Monolog\Test\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\Exception;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class TripTest extends TestCase
{
    private const GTFS_PATH = __DIR__ . '/Fixtures/Gtfs';

    /**
     * Test get trips
     * @return void
     * @throws Exception
     * @throws InvalidArgumentException
     */
    #[Test]
    public function testGetTrips(): void
    {
        $cache = $this->createMock(CacheInterface::class);
        $cacheItem = $this->createMock(ItemInterface::class);

        $cacheItem->method('get')->willReturn([
            [
                'trip_id' => '1',
                'arrival_time' => $this->mockCurrentTime('+ 10 minutes'),
                'departure_time' => $this->mockCurrentTime('12 minutes'),
                'stop_id' => '12176'
            ]
        ]);

        $cache->method('get')->willReturn($cacheItem->get());

        $gtfsService = new GtfsService(self::GTFS_PATH, $cache);

        $schedules = $gtfsService->getFixedSchedules('12176');
        $this->assertNotEmpty($schedules);
        $this->assertEquals('12176', $schedules[0]['stopId']);
    }

    /**
     * Add n minutes to current time
     * @param string $minutesToAdd '+n minutes'
     * @return string
     */
    private function mockCurrentTime(string $minutesToAdd): string
    {
        $currentDateTime = new \DateTime();
        $currentDateTime->modify($minutesToAdd);

        return $currentDateTime->format('H:i:s');
    }
}

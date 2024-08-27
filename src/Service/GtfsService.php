<?php

namespace App\Service;

use Generator;
use Psr\Cache\InvalidArgumentException;
use RuntimeException;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class GtfsService implements GtfsServiceInterface
{
    private string $gtfsPath;
    private CacheInterface $cache;

    private const STOP_TIMES_FILE = '/stop_times.txt';
    private const TRIPS_FILE = '/trips.txt';

    /**
     * Get gtfs sources path
     * @param string $gtfsPath
     * @param CacheInterface $cache
     */
    public function __construct(string $gtfsPath, CacheInterface $cache)
    {
        $this->gtfsPath = $gtfsPath;
        $this->cache = $cache;
    }

    /**
     * Get fixed schedules from gtfs sources
     * @param string $stopId
     * @return array
     * @throws InvalidArgumentException
     */
    public function getFixedSchedules(string $stopId): array
    {
        $stopTimes = $this->getCachedCsvFile($this->getFilePath(self::STOP_TIMES_FILE));
        $trips = $this->getTripsById();
        $schedules = $this->filterSchedulesByStopId($stopTimes, $trips, $stopId);

        return $this->filterSchedulesByCurrentTime($schedules);
    }

    /**
     * @throws InvalidArgumentException
     */
    private function getCachedCsvFile(string $filePath): Generator
    {
        $cacheKey = 'gtfs_'.md5($filePath);

        $data = $this->cache->get($cacheKey, function(ItemInterface $item) use ($filePath) {
            $item->expiresAfter(3600);
            return iterator_to_array($this->parseCsvFile($filePath));
        });

        foreach ($data as $row) {
            yield $row;
        }
    }

    /**
     * Filter trips by id
     * @return array
     */
    private function getTripsById(): array
    {
        $tripsData = $this->parseCsvFile($this->getFilePath(self::TRIPS_FILE));

        $trips = [];
        foreach ($tripsData as $trip) {
            $trips[$trip['trip_id']] = $trip;
        }
        return $trips;
    }

    /**
     * Get schedules by stop id
     * @param Generator $stopTimes
     * @param array $trips
     * @param string $stopId
     * @return array
     */
    private function filterSchedulesByStopId(Generator $stopTimes, array $trips, string $stopId): array
    {
        $schedules = [];

        foreach ($stopTimes as $stopTime) {
            if ($stopTime['stop_id'] === $stopId && isset($trips[$stopTime['trip_id']])) {
                $schedules[] = [
                    'stopId' => $stopId,
                    'arrival' => strtotime($stopTime['arrival_time']),
                    'departure' => strtotime($stopTime['departure_time']),
                ];
            }
        }

        return $schedules;
    }

    /**
     * Get schedules by current time
     * @param array $schedules
     * @return array
     */
    private function filterSchedulesByCurrentTime(array $schedules): array
    {
        $currentTime = time();

        return array_filter($schedules, function ($schedule) use ($currentTime) {
            return $schedule['arrival'] >= $currentTime || $schedule['departure'] >= $currentTime;
        });
    }

    /**
     * Get csv files path
     * @param string $filename
     * @return string
     */
    private function getFilePath(string $filename): string
    {
        return $this->gtfsPath.$filename;
    }

    /**
     * Get data from csv file
     * @param string $filename
     * @return Generator
     */
    private function parseCsvFile(string $filename): Generator
    {
        if (($handle = fopen($filename, 'r')) !== false) {
            $header = fgetcsv($handle);
            while (($row = fgetcsv($handle)) !== false) {
                yield array_combine($header, $row);
            }
            fclose($handle);
        } else {
            throw new RuntimeException("Unable to open file $filename.");
        }
    }
}
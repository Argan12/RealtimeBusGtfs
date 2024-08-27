<?php

namespace App\Service;

use Generator;
use RuntimeException;

class GtfsService implements GtfsServiceInterface
{
    private string $gtfsPath;

    private const STOP_TIMES_FILE = '/stop_times.txt';
    private const TRIPS_FILE = '/trips.txt';

    /**
     * Get gtfs sources path
     * @param string $gtfsPath
     */
    public function __construct(string $gtfsPath)
    {
        $this->gtfsPath = $gtfsPath;
    }

    /**
     * Get fixed schedules from gtfs sources
     * @param string $stopId
     * @return array
     */
    public function getFixedSchedules(string $stopId): array
    {
        $stopTimes = $this->parseCsvFile($this->getFilePath(self::STOP_TIMES_FILE));
        $trips = $this->getTripsById();
        $schedules = $this->filterSchedulesByStopId($stopTimes, $trips, $stopId);

        return $this->filterSchedulesByCurrentTime($schedules);
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
<?php

namespace App\Service;

interface GtfsServiceInterface
{
    /**
     * Get fixed schedules from gtfs sources
     * @param string $stopId
     * @return array
     */
    public function getFixedSchedules(string $stopId): array;
}
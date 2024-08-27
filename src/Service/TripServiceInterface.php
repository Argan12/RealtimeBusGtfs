<?php

namespace App\Service;

use Exception;

interface TripServiceInterface
{
    /**
     * Map trip (from pb file) into Trip objet
     * @param string $stopId
     * @return array (list of trips)
     * @throws Exception
     */
    public function getTrips(string $stopId): array;
}
<?php

namespace App\Entity;

use ApiPlatform\Metadata\GetCollection;
use App\State\TripProvider;

#[GetCollection(uriTemplate: '/trips/{stopId}', provider: TripProvider::class)]
class Trip
{
    private string $stopId;
    private int $arrival;
    private int $departure;

    public function getStopId(): string
    {
        return $this->stopId;
    }

    public function setStopId(string $stopId): static
    {
        $this->stopId = $stopId;

        return $this;
    }

    public function getArrival(): int
    {
        return $this->arrival;
    }

    public function setArrival(int $arrival): static
    {
        $this->arrival = $arrival;

        return $this;
    }

    public function getDeparture(): int
    {
        return $this->departure;
    }

    public function setDeparture(int $departure): static
    {
        $this->departure = $departure;

        return $this;
    }
}
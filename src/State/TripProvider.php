<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Service\TripServiceInterface;

final class TripProvider implements ProviderInterface
{
    private TripServiceInterface $tripService;

    /**
     * Inject service
     * @param TripServiceInterface $tripService
     */
    public function __construct(TripServiceInterface $tripService)
    {
        $this->tripService = $tripService;
    }

    /**
     * Get trips
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return object|array|null
     * @throws \Exception
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        return $this->tripService->getTrips($uriVariables["stopId"]);
    }
}
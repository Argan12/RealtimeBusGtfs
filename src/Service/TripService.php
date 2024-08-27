<?php

namespace App\Service;

use App\Entity\Trip;
use App\Repository\BusStopRepository;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Transit_realtime\FeedMessage;

class TripService implements TripServiceInterface
{
    private PbFileServiceInterface $pbFileService;
    private GtfsServiceInterface $gtfsService;
    private string $pbFilePath;
    private BusStopRepository $repository;
    private LoggerInterface $logger;

    /**
     * Constructor
     * @param PbFileServiceInterface $pbFileService
     * @param GtfsServiceInterface $gtfsService
     * @param string $pbFilePath
     * @param BusStopRepository $repository
     * @param LoggerInterface $logger
     */
    public function __construct(PbFileServiceInterface $pbFileService, GtfsServiceInterface $gtfsService, string $pbFilePath, BusStopRepository $repository, LoggerInterface $logger)
    {
        $this->pbFileService = $pbFileService;
        $this->gtfsService = $gtfsService;
        $this->pbFilePath = $pbFilePath;
        $this->repository = $repository;
        $this->logger = $logger;
    }

    /**
     * Map trip (from pb file) into Trip objet
     * @param string $stopId
     * @return array (list of trips)
     * @throws Exception
     */
    public function getTrips(string $stopId): array
    {
        $busStop = $this->repository->findOneBy(['stopId' => $stopId]);

        if (!$busStop) {
            throw new NotFoundHttpException("Bus stop does not exist");
        }

        $results = $this->getTripsFromPbFile($stopId);

        if (empty($results)) {
            $this->logger->info("No trips found. Switch to fixed schedules.");
            return $this->gtfsService->getFixedSchedules($stopId);
        }

        $trips = [];
        foreach ($results as $item) {
            $trip = new Trip();
            $trip->setStopId($item->getStopId());
            $trip->setArrival($item->getArrival()->getTime());
            $trip->setDeparture($item->getDeparture()->getTime());
            $trips[] = $trip;
        }

        return array_map(function (Trip $trip) {
            return [
                'stopId' => $trip->getStopId(),
                'arrival' => $trip->getArrival(),
                'departure' => $trip->getDeparture()
            ];
        }, $trips);
    }

    /**
     * Get info from pb file
     * @param string $stopId
     * @return array
     * @throws Exception
     */
    private function getTripsFromPbFile(string $stopId): array
    {
        $fileContent = $this->pbFileService->getFile($this->pbFilePath);
        $stopTimeUpdates = [];

        $feedMessage = new FeedMessage();
        $feedMessage->mergeFromString($fileContent);

        foreach ($feedMessage->getEntity() as $entity) {
            foreach ($entity->getTripUpdate()->getStopTimeUpdate() as $stopTimeUpdate) {
                if ($stopTimeUpdate->getStopId() === $stopId) {
                    $stopTimeUpdates[] = $stopTimeUpdate;
                }
            }
        }
        return $stopTimeUpdates;
    }
}
<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Filter\BusStopFilter;
use App\Repository\BusStopRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: BusStopRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection()
    ],
    normalizationContext: ['groups' => ['stops']]
)]
#[ApiFilter(BusStopFilter::class)]
class BusStop
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[ApiProperty(identifier: false)]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['stops', 'clock'])]
    #[ApiProperty(identifier: true)]
    private ?int $stopId = null;

    #[ORM\Column(length: 255)]
    #[Groups(['stops', 'clock'])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(['stops', 'clock'])]
    private ?float $latitude = null;

    #[ORM\Column]
    #[Groups(['stops', 'clock'])]
    private ?float $longitude = null;

    #[ORM\Column(length: 255)]
    #[Groups(['stops', 'clock'])]
    private ?string $destination = null;

    #[ORM\ManyToOne(targetEntity: BusLine::class, inversedBy: 'busStops')]
    #[Groups(['stops', 'clock'])]
    private BusLine $route;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStopId(): ?int
    {
        return $this->stopId;
    }

    public function setStopId(?int $stopId): static
    {
        $this->stopId = $stopId;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): static
    {
        $this->destination = $destination;

        return $this;
    }

    public function getRoute(): BusLine
    {
        return $this->route;
    }

    public function setRoute(BusLine $route): static
    {
        $this->route = $route;

        return $this;
    }
}

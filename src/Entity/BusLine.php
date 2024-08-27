<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\BusLineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: BusLineRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection()
    ],
    normalizationContext: ['groups' => ['line']],
    order: ['id' => 'asc']
)]
class BusLine
{
    #[ORM\Id]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    #[Groups(['stops', 'line', 'clock'])]
    private ?string $line = null;

    #[ORM\Column(length: 255)]
    #[Groups(['stops', 'line'])]
    private ?string $destination = null;

    #[ORM\Column(length: 10)]
    #[Groups(['stops', 'line', 'clock'])]
    private ?string $color = null;

    #[ORM\OneToMany(targetEntity: BusStop::class, mappedBy: 'route')]
    private Collection $busStops;

    public function __construct()
    {
        $this->busStops = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getLine(): ?string
    {
        return $this->line;
    }

    public function setLine(string $line): static
    {
        $this->line = $line;

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

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getBusStops(): Collection
    {
        return $this->busStops;
    }
}

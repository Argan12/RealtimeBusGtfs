<?php

namespace App\Dto;

use App\Enum\NotificationState;
use DateTimeInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

class NotificationDto
{
    public ?Uuid $id;

    public Uuid $clockId;

    #[Assert\NotBlank]
    public string $title;

    #[Assert\NotBlank]
    public string $content;

    public int $nextDeparture;

    public int $timeToLeave;

    public ?NotificationState $state;

    public ?DateTimeInterface $date;

    public function __construct(?Uuid $id, Uuid $clockId, string $title, string $content, int $nextDeparture, int $timeToLeave, ?NotificationState $state, ?DateTimeInterface $date)
    {
        $this->id = $id;
        $this->clockId = $clockId;
        $this->title = $title;
        $this->content = $content;
        $this->nextDeparture = $nextDeparture;
        $this->timeToLeave = $timeToLeave;
        $this->state = $state;
        $this->date = $date;
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function setId(?Uuid $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function getClockId(): Uuid
    {
        return $this->clockId;
    }

    public function setClockId(Uuid $clockId): static
    {
        $this->clockId = $clockId;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;
        return $this;
    }

    public function getState(): ?NotificationState
    {
        return $this->state;
    }

    public function setState(?NotificationState $state): static
    {
        $this->state = $state;
        return $this;
    }

    public function getNextDeparture(): int
    {
        return $this->nextDeparture;
    }

    public function setNextDeparture(int $nextDeparture): static
    {
        $this->nextDeparture = $nextDeparture;
        return $this;
    }

    public function getTimeToLeave(): int
    {
        return $this->timeToLeave;
    }

    public function setTimeToLeave(int $timeToLeave): static
    {
        $this->timeToLeave = $timeToLeave;
        return $this;
    }

    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }
}
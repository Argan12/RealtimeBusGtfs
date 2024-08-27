<?php

namespace App\Dto;

use App\Enum\NotificationState;
use DateTimeInterface;
use Symfony\Component\Uid\Uuid;

class NotificationDtoBuilder
{
    private Uuid $id;
    private Uuid $clockId;
    private string $title;
    private string $content;
    private int $nextDeparture;
    private int $timeToLeave;
    private NotificationState $state;
    private DateTimeInterface $date;

    /**
     * @param Uuid $id
     * @return NotificationDtoBuilder
     */
    public function setId(Uuid $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param Uuid $clockId
     * @return NotificationDtoBuilder
     */
    public function setClockId(Uuid $clockId): self
    {
        $this->clockId = $clockId;
        return $this;
    }

    /**
     * @param string $title
     * @return NotificationDtoBuilder
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $content
     * @return NotificationDtoBuilder
     */
    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @param NotificationState $state
     * @return NotificationDtoBuilder
     */
    public function setState(NotificationState $state): self
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @param int $nextDeparture
     * @return NotificationDtoBuilder
     */
    public function setNextDeparture(int $nextDeparture): self
    {
        $this->nextDeparture = $nextDeparture;
        return $this;
    }

    /**
     * @param int $timeToLeave
     * @return NotificationDtoBuilder
     */
    public function setTimeToLeave(int $timeToLeave): self
    {
        $this->timeToLeave = $timeToLeave;
        return $this;
    }

    /**
     * @param DateTimeInterface $date
     * @return NotificationDtoBuilder
     */
    public function setDate(DateTimeInterface $date): self
    {
        $this->date = $date;
        return $this;
    }

    public function build(): NotificationDto
    {
        return new NotificationDto($this->id, $this->clockId, $this->title, $this->content, $this->nextDeparture, $this->timeToLeave, $this->state, $this->date);
    }
}
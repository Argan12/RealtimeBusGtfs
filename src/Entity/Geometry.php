<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Geometry
{
    private ArrayCollection $coordinates;

    public function getCoordinates(): ArrayCollection
    {
        return $this->coordinates;
    }

    public function setCoordinates(ArrayCollection $coordinates): static
    {
        $this->coordinates = $coordinates;

        return $this;
    }
}
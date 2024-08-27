<?php

namespace App\Entity;

use ApiPlatform\Metadata\GetCollection;
use App\Dto\AddressDto;
use App\State\AddressProvider;

#[GetCollection(
    uriTemplate: '/address/{query}',
    output: AddressDto::class,
    provider: AddressProvider::class
)]
class Address
{
    private Geometry $geometry;
    private AddressProperty $property;

    public function getGeometry(): Geometry
    {
        return $this->geometry;
    }

    public function setGeometry(Geometry $geometry): static
    {
        $this->geometry = $geometry;

        return $this;
    }

    public function getProperty(): AddressProperty
    {
        return $this->property;
    }

    public function setProperty(AddressProperty $property): static
    {
        $this->property = $property;

        return $this;
    }
}
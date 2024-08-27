<?php

namespace App\Dto;

use App\Entity\AddressCoordinates;

class AddressDto
{
    public string $address;
    public string $street;
    public string $zipCode;
    public string $city;
    public AddressCoordinates $coordinates;

    public function __construct(string $address, string $street, string $zipCode, string $city, AddressCoordinates $coordinates)
    {
        $this->address = $address;
        $this->street = $street;
        $this->zipCode = $zipCode;
        $this->city = $city;
        $this->coordinates = $coordinates;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function setStreet(string $street): static
    {
        $this->street = $street;

        return $this;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): static
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getCoordinates(): AddressCoordinates
    {
        return $this->coordinates;
    }

    public function setCoordinates(AddressCoordinates $coordinates): static
    {
        $this->coordinates = $coordinates;

        return $this;
    }
}
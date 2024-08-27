<?php

namespace App\Factory;

use App\Dto\AddressDto;
use App\Entity\AddressCoordinates;

/**
 * Transform API response to DTO
 */
class AddressDtoFactory
{
    /**
     * Get and filter array response
     * @param array $data
     * @return array
     */
    public function createCollectionFromArray(array $data): array
    {
        return array_map([$this, 'createFromArray'], array_filter($data['features'], function ($item) {
            return is_array($item) && isset($item['properties']) && isset($item['geometry']);
        }));
    }

    /**
     * Set array response to DTO
     * @param array $data
     * @return AddressDto
     */
    public function createFromArray(array $data): AddressDto
    {
        $coordinates = new AddressCoordinates();
        $coordinates->setLatitude($data["geometry"]["coordinates"][1]);
        $coordinates->setLongitude($data["geometry"]["coordinates"][0]);

        return new AddressDto(
            $data["properties"]["label"],
            $data["properties"]["name"],
            $data["properties"]["postcode"],
            $data["properties"]["city"],
            $coordinates
        );
    }
}
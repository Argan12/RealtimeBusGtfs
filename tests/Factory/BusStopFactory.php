<?php

namespace App\Tests\Factory;

use App\Entity\BusStop;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<BusStop>
 */
final class BusStopFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return BusStop::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'destination' => self::faker()->streetName(),
            'latitude' => self::faker()->randomFloat(),
            'longitude' => self::faker()->randomFloat(),
            'name' => self::faker()->streetName(),
            'stopId' => self::faker()->numberBetween(4000, 39999),
            'route' => BusLineFactory::new()
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this;
    }
}

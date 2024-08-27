<?php

namespace App\Tests\Factory;

use App\Entity\BusLine;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<BusLine>
 */
final class BusLineFactory extends PersistentProxyObjectFactory
{
    private static int $increment = 1;

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
        return BusLine::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'id' => self::$increment++,
            'color' => self::faker()->hexColor(),
            'destination' => self::faker()->streetName(),
            'line' => self::faker()->numberBetween(1, 99)
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

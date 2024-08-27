<?php

namespace App\Filter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\PropertyInfo\Type;

final class BusStopFilter extends AbstractFilter
{
    /**
     * Filter bus stops with name and bus line destination
     * @param string $property
     * @param $value
     * @param QueryBuilder $queryBuilder
     * @param QueryNameGeneratorInterface $queryNameGenerator
     * @param string $resourceClass
     * @param Operation|null $operation
     * @param array $context
     * @return void
     */
    protected function filterProperty(string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, ?Operation $operation = null, array $context = []): void
    {
        if ($property != "search") {
            return;
        }

        $keywords = explode(' ', $value);
        $alias = $queryBuilder->getRootAliases()[0];

        foreach ($keywords as $keyword) {
            $parameterName = $queryNameGenerator->generateParameterName('search');
            $queryBuilder
                ->andWhere("$alias.name LIKE :$parameterName OR $alias.destination LIKE :$parameterName")
                ->setParameter($parameterName, '%' . $keyword . '%');
        }
    }

    /**
     * Get filter description
     * @param string $resourceClass
     * @return array|array[]
     */
    public function getDescription(string $resourceClass): array
    {
        if (!$this->properties) {
            return [];
        }

        $description = [];
        foreach ($this->properties as $property => $strategy) {
            $description["search"] = [
                'property' => $property,
                'type' => Type::BUILTIN_TYPE_STRING,
                'required' => false,
                'description' => 'Filter bus stop by name and line destination',
                'openapi' => [
                    'example' => 'Custom example that will be in the documentation and be the default value of the sandbox',
                    'allowReserved' => false,
                    'allowEmptyValue' => true,
                    'explode' => false
                ]
            ];
        }
        return $description;
    }
}
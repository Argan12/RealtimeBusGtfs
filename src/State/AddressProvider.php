<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\AddressDto;
use App\Factory\AddressDtoFactory;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @implements ProviderInterface<AddressDto[]>
 */
class AddressProvider implements ProviderInterface
{
    private HttpClientInterface $client;
    private AddressDtoFactory $dtoFactory;
    private string $addressApiUrl;

    /**
     * Dependency injection
     * @param HttpClientInterface $client
     * @param AddressDtoFactory $dtoFactory
     * @param $addressApiUrl
     */
    public function __construct(HttpClientInterface $client, AddressDtoFactory $dtoFactory, $addressApiUrl)
    {
        $this->client = $client;
        $this->dtoFactory = $dtoFactory;
        $this->addressApiUrl = $addressApiUrl;
    }

    /**
     * Get address
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return object|array|null
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $response = $this->client->request("GET", $this->addressApiUrl . "?q=" . $uriVariables["query"] . "&limit=15");
        return $this->dtoFactory->createCollectionFromArray($response->toArray());
    }
}
<?php

declare(strict_types=1);

namespace App\Infrastructure\HttpClient;

use GuzzleHttp\ClientInterface;

abstract class BaseAdapter implements CurrencyRateProvider
{
    protected $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function load(): array
    {
        return $this->normalize($this->client->request('GET', $this->uri())->getBody()->getContents());
    }

    abstract protected function uri(): string;

    abstract protected function base(): string;

    abstract protected function normalize(string $contents): array;
}

<?php

declare(strict_types=1);

namespace App\Infrastructure\QuotationProvider;

use GuzzleHttp\ClientInterface;

abstract class BaseLoader implements Loader
{
    protected ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function load(): array
    {
        return $this->normalize($this->client->request('GET', $this->uri())->getBody()->getContents());
    }

    abstract protected function uri(): string;

    abstract protected function code(): string;

    abstract protected function normalize(string $contents): array;
}

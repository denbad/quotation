<?php

declare(strict_types=1);

namespace App\Infrastructure\QuotationProvider;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

final class ClientFactory
{
    public function create(): ClientInterface
    {
        return new Client();
    }
}


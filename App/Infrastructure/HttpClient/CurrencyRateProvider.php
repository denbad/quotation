<?php

declare(strict_types=1);

namespace App\Infrastructure\HttpClient;

interface CurrencyRateProvider
{
    public function load(): array;
}

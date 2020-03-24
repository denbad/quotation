<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\CurrencyRateRepository;

final class RefreshHandler
{
    private $rates;

    public function __construct(CurrencyRateRepository $rates)
    {
        $this->rates = $rates;
    }

    public function __invoke(Refresh $command): void
    {
        dump(__METHOD__); die;
    }
}

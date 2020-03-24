<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\Read\CurrencyRateRepository;

final class ConvertHandler
{
    private $rates;

    public function __construct(CurrencyRateRepository $rates)
    {
        $this->rates = $rates;
    }

    public function __invoke(Convert $command): void
    {
        dump(__METHOD__); die;
    }
}

<?php

declare(strict_types=1);

namespace App\Infrastructure\QuotationLoader;

interface Loader
{
    public function load(): array;
}

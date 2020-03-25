<?php

declare(strict_types=1);

namespace App\Infrastructure\QuotationProvider;

interface Loader
{
    public function name(): string;

    public function load(): array;
}

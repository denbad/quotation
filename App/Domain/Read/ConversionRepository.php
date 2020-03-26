<?php

declare(strict_types=1);

namespace App\Domain\Read;

interface ConversionRepository
{
    public function byCode(string $code): ?Conversion;
}

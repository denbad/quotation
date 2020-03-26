<?php

declare(strict_types=1);

namespace App\Domain\Read;

interface QuotationRepository
{
    public function byCode(string $code): ?Quotation;
}

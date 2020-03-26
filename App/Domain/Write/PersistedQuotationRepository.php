<?php

declare(strict_types=1);

namespace App\Domain\Write;

interface PersistedQuotationRepository
{
    public function byCode(string $code): ?PersistedQuotation;

    public function save(PersistedQuotation $quotation): void;
}

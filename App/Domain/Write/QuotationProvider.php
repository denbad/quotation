<?php

declare(strict_types=1);

namespace App\Domain\Write;

interface QuotationProvider
{
    public function name(): string;

    public function quotations(): array;
}

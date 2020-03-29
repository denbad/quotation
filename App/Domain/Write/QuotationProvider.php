<?php

declare(strict_types=1);

namespace App\Domain\Write;

interface QuotationProvider
{
    public const LOADER_DEFAULT = 'default';
    public const LOADER_ECB = 'ecb';
    public const LOADER_CBR = 'cbr';

    public function name(): string;

    public function quotations(string $loader = self::LOADER_DEFAULT): array;
}

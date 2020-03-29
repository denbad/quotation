<?php

declare(strict_types=1);

namespace App\Infrastructure\QuotationProvider;

use RuntimeException;

final class LoaderNotRegistered extends RuntimeException
{
    public function __construct(string $alias)
    {
        parent::__construct(sprintf('Loader "%s" is not registered', $alias));
    }
}

<?php

declare(strict_types=1);

namespace App\Application\Query;

final class Convert
{
    private string $code;
    private string $amount;

    public function __construct(string $code, string $amount)
    {
        $this->code = $code;
        $this->amount = $amount;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function amount(): string
    {
        return $this->amount;
    }
}

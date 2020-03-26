<?php

declare(strict_types=1);

namespace App\Application\Query;

final class Convert
{
    private string $code;
    private string $nominal;

    public function __construct(string $code, string $nominal)
    {
        $this->code = $code;
        $this->nominal = $nominal;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function nominal(): string
    {
        return $this->nominal;
    }
}

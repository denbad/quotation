<?php

declare(strict_types=1);

namespace App\Infrastructure\HttpClient;

final class Entry
{
    public $base;
    public $quote;
    public $bid;
    public $nominal;

    public function __construct($base, $quote, $nominal, $bid)
    {
        $this->base = $base;
        $this->quote = $quote;
        $this->nominal = $nominal;
        $this->bid = $bid;
    }
}

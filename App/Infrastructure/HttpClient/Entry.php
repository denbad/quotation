<?php

declare(strict_types=1);

namespace App\Infrastructure\HttpClient;

final class Entry
{
    /** @var mixed */
    public $base;

    /** @var mixed */
    public $quote;

    /** @var mixed */
    public $bid;

    /** @var mixed */
    public $nominal;

    public function __construct($base, $quote, $nominal, $bid)
    {
        $this->base = $base;
        $this->quote = $quote;
        $this->nominal = $nominal;
        $this->bid = $bid;
    }
}

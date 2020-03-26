<?php

declare(strict_types=1);

namespace App\Application\Query;

use App\Domain\Read\QuotationRepository;

final class ConvertHandler
{
    private QuotationRepository $quotations;

    public function __construct(QuotationRepository $quotations)
    {
        $this->quotations = $quotations;
    }

    public function __invoke(Convert $query): array
    {
        if (!$nominal = $query->nominal()) {
            throw NotValid::emptyNominal();
        }
        if (!preg_match('#^([\d]+([.][\d]*)?|[.][\d]+)$#', $nominal)) {
            throw NotValid::malformedNominal($nominal);
        }
        if (!$conversion = $this->quotations->byCode($query->code())) {
            throw NotFound::notSupported($query->code());
        }

        return $conversion->convert((float) $nominal)->toArray();
    }
}

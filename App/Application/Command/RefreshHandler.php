<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Write\PersistedQuotation;
use App\Domain\Write\PersistedQuotationRepository;

final class RefreshHandler
{
    private PersistedQuotationRepository $quotations;

    public function __construct(PersistedQuotationRepository $quotations)
    {
        $this->quotations = $quotations;
    }

    public function __invoke(Refresh $command): void
    {
        if ($quotation = $this->quotations->byCode($command->code())) {
            $quotation->refresh($command->bid());
        } else {
            $quotation = new PersistedQuotation($command->code(), $command->bid());
        }

        $this->quotations->save($quotation);
    }
}

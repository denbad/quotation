<?php

declare(strict_types=1);

namespace App\Infrastructure\QuotationProvider;

use App\Domain\Write\Quotation;
use App\Domain\Write\QuotationProvider as Provider;

final class QuotationProvider implements Provider
{
    private Loader $loader;

    public function __construct(Loader $loader)
    {
        $this->loader = $loader;
    }

    public function name(): string
    {
        return $this->loader->name();
    }

    public function quotations(): array
    {
        $quotations = [];

        $this->transform($quotations);
        $this->addFlips($quotations);
        $this->addCrosses($quotations);

        return $quotations;
    }

    private function transform(array &$quotations): void
    {
        $entries = $this->loader->load();

        array_walk($entries, static function (array $entry) use (&$quotations) : void {
            $quotation = new Quotation(
                (string) $entry['base'],
                (string) $entry['quote'],
                (float) $entry['bid'],
                (int) $entry['nominal']
            );
            $quotations[$quotation->code()] = $quotation;
        });
    }

    private function addFlips(array &$quotations): void
    {
        array_walk($quotations, static function (Quotation $quotation) use (&$quotations): void {
            if ($quotation->isFlipable()) {
                $flipped = $quotation->flip();
                $quotations[$flipped->code()] = $flipped;
            }
        });
    }

    private function addCrosses(array &$quotations): void
    {
        array_walk($quotations, static function (Quotation $quotationA) use (&$quotations) : void {
            array_walk($quotations, static function (Quotation $quotationB) use (&$quotations, $quotationA) : void {
                if ($quotationA->isCrossable($quotationB)) {
                    $crossed = $quotationA->cross($quotationB);
                    $quotations[$crossed->code()] = $crossed;
                }
            });
        });
    }
}

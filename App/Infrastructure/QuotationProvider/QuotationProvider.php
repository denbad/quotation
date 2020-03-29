<?php

declare(strict_types=1);

namespace App\Infrastructure\QuotationProvider;

use App\Domain\Write\Quotation;
use App\Domain\Write\QuotationProvider as Provider;

final class QuotationProvider implements Provider
{
    private array $loaders;

    public function __construct(array $loaders = [])
    {
        array_walk($loaders, function (Loader $loader, string $alias): void {
            $this->addLoader($alias, $loader);
        });
    }

    public function addLoader(string $alias, Loader $loader)
    {
        $this->loaders[$alias] = $loader;
    }

    public function name(string $loader = self::LOADER_DEFAULT): string
    {
        return $this->loader($loader)->name();
    }

    public function quotations(string $loader = self::LOADER_DEFAULT): array
    {
        $entries = $this->loader($loader)->load();

        $quotations = [];
        $this->transform($entries, $quotations);
        $this->addFlips($quotations);
        $this->addCrosses($quotations);

        return $quotations;
    }

    private function transform(array $entries, array &$quotations): void
    {
        array_walk($entries, static function (array $entry) use (&$quotations): void {
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
        array_walk($quotations, static function (Quotation $quotationA) use (&$quotations): void {
            array_walk($quotations, static function (Quotation $quotationB) use (&$quotations, $quotationA): void {
                if ($quotationA->isCrossable($quotationB)) {
                    $crossed = $quotationA->cross($quotationB);
                    $quotations[$crossed->code()] = $crossed;
                }
            });
        });
    }

    private function loader(string $alias): Loader
    {
        if (!array_key_exists($alias, $this->loaders)) {
            throw new LoaderNotRegistered($alias);
        }

        return $this->loaders[$alias];
    }
}

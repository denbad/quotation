<?php

declare(strict_types=1);

namespace App\Application\Query;

use App\Domain\Read\QuotationRepository;
use App\Symfony\Validator\Constraints\Conversion;
use App\Symfony\Validator\ValidatesAndGetsErrors;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ConvertHandler
{
    use ValidatesAndGetsErrors;

    private QuotationRepository $quotations;

    public function __construct(
        QuotationRepository $quotations,
        ValidatorInterface $validator,
        PropertyAccessorInterface $propertyAccessor
    ) {
        $this->quotations = $quotations;
        $this->validator = $validator;
        $this->propertyAccessor = $propertyAccessor;
    }

    public function __invoke(Convert $query): array
    {
        $nominal = $query->nominal();

        if ($violations = $this->validate(['nominal' => $nominal], [new Conversion()])) {
            throw new NotValid($violations);
        }
        if (!$conversion = $this->quotations->byCode($query->code())) {
            throw new NotFound();
        }

        return $conversion->convert((float) $nominal)->toArray();
    }
}

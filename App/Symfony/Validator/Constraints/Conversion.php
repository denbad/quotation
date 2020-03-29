<?php

declare(strict_types=1);

namespace App\Symfony\Validator\Constraints;

use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\CollectionValidator;
use Symfony\Component\Validator\Constraints\NotBlank;

final class Conversion extends Collection
{
    public function __construct()
    {
        parent::__construct([
            'nominal' => [
                new NotBlank(['message' => 'This value should not be blank']),
                new IsFloatString(),
            ],
        ]);
    }

    public function validatedBy(): string
    {
        return CollectionValidator::class;
    }
}

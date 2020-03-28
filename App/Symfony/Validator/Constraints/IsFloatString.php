<?php

declare(strict_types=1);

namespace App\Symfony\Validator\Constraints;

use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\RegexValidator;

final class IsFloatString extends Regex
{
    public function __construct()
    {
        parent::__construct([
            'message' => 'Float value expected',
            'pattern' => '#^([\d]+([.][\d]*)?|[.][\d]+)$#'
        ]);
    }

    public function validatedBy(): string
    {
        return RegexValidator::class;
    }
}

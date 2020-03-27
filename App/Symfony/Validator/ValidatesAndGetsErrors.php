<?php

declare(strict_types=1);

namespace App\Symfony\Validator;

use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

trait ValidatesAndGetsErrors
{
    private ValidatorInterface $validator;
    private PropertyAccessorInterface $propertyAccessor;

    private function validate(array $input, array $constraints): array
    {
        $errors = [];

        if (count($violations = $this->validator->validate($input, $constraints))) {
            /** @var ConstraintViolationInterface $violation */
            foreach ($violations as $violation) {
                $this->propertyAccessor->setValue($errors, $violation->getPropertyPath(), $violation->getMessage());
            }
        }

        return $errors;
    }
}

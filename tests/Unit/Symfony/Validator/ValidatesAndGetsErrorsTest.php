<?php

declare(strict_types=1);

namespace App\Tests\Unit\Symfony\Validator;

use App\Symfony\Validator\ValidatesAndGetsErrors;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ValidatesAndGetsErrorsTest extends TestCase
{
    private string $notBlankMessage;
    private string $emailNotValidMessage;
    private array $constraints;
    private Sut $sut;

    public function testValidateEmptyEmail(): void
    {
        $errors = $this->sut->doValidate(['email' => ''], $this->constraints);
        $this->assertEquals($errors['email'], $this->notBlankMessage);
    }

    public function testValidateNotValidEmail(): void
    {
        $errors = $this->sut->doValidate(['email' => 'not_valid_email'], $this->constraints);
        $this->assertEquals($errors['email'], $this->emailNotValidMessage);
    }

    public function testValidateNoErrors(): void
    {
        $errors = $this->sut->doValidate(['email' => 'sut@sample.com'], $this->constraints);
        $this->assertEmpty($errors);
    }

    protected function setUp(): void
    {
        $this->notBlankMessage = 'Required';
        $this->emailNotValidMessage = 'Email not valid';

        $this->constraints = [new Collection(['email' => [
            new NotBlank(['message' => $this->notBlankMessage]),
            new Email(['message' => $this->emailNotValidMessage]), ]]),
        ];

        $this->sut = new Sut(Validation::createValidator(), new PropertyAccessor());
    }
}

final class Sut
{
    use ValidatesAndGetsErrors;

    public function __construct(ValidatorInterface $validator, PropertyAccessorInterface $propertyAccessor)
    {
        $this->validator = $validator;
        $this->propertyAccessor = $propertyAccessor;
    }

    public function doValidate(array $input, array $constraint): array
    {
        return $this->validate($input, $constraint);
    }
}

<?php

namespace Mact\Tests\Unit\Validator\Constraint;

use Mact\Validator\Constraints\Password;
use Mact\Validator\Constraints\PasswordValidator;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;
use Webmozart\Assert\InvalidArgumentException;

class PasswordValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator(): ConstraintValidatorInterface
    {
        return new PasswordValidator();
    }

    public function testItShouldBeThrowAnException(): void
    {
        $constraint = new NotNull();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Constraint not be a PasswordContraint');
        $this->validator->validate('myFakeString', $constraint);
    }

    /**
     * @dataProvider invalidPasswordWithDefaultConfiguration
     */
    public function testItShouldBeAnInvalidPasswordWithDefaultConfiguration(string $password, string $violationMessage): void
    {
        $passwordContraint = new Password();

        $this->expectNoValidate();
        $this->validator->validate($password, $passwordContraint);

        $context = $this->context->getValidator()->inContext($this->context);

        $this->assertCount(1, $context->getViolations());
        $this->assertEquals($violationMessage, $context->getViolations()[0]->getMessage());
    }

    public function testItShouldBeAValidPasswordWithDefaultConfiguration(): void
    {
        $passwordContraint = new Password();

        $this->expectNoValidate();
        $this->validator->validate('Passw0rd!', $passwordContraint);

        $context = $this->context->getValidator()->inContext($this->context);

        $this->assertCount(0, $context->getViolations());
    }

    public function invalidPasswordWithDefaultConfiguration(): \Generator
    {
        yield 'expect no lower char' => [
            'PASSW0RD!',
            'mact.form._error.lower',
        ];

        yield 'expect no more than 100 characters' => [
            'ThisismyPASSW0RD!Iwouldhavemorethan25characteresforexpecthaveoneviolation',
            'mact.form._error.maxChar',
        ];
    }
}

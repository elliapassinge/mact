<?php

namespace Tests\Unit\Validator\Constraints;

use Mact\Validator\Constraints\Password;
use Mact\Validator\Constraints\PasswordValidator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;
use Webmozart\Assert\InvalidArgumentException;

#[CoversClass(PasswordValidator::class)]
#[UsesClass(Password::class)]
class PasswordValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator(): ConstraintValidatorInterface
    {
        return new PasswordValidator();
    }

    #[Test]
    public function testItShouldBeThrowAnException(): void
    {
        $constraint = new NotNull();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Constraint not be a PasswordContraint');
        $this->validator->validate('myFakeString', $constraint);
    }

    #[Test]
    #[DataProvider('invalidPasswordWithDefaultConfiguration')]
    public function testItShouldBeAnInvalidPasswordWithDefaultConfiguration(?string $password, string $violationMessage): void
    {
        $passwordContraint = new Password();

        $this->expectNoValidate();
        $this->validator->validate($password, $passwordContraint);

        $context = $this->context->getValidator()->inContext($this->context);

        $this->assertCount(1, $context->getViolations());
        $this->assertEquals($violationMessage, $context->getViolations()[0]->getMessage());
    }

    #[Test]
    public function testItShouldBeAValidPasswordWithDefaultConfiguration(): void
    {
        $passwordContraint = new Password();

        $this->expectNoValidate();
        $this->validator->validate('Passw0rd!', $passwordContraint);

        $context = $this->context->getValidator()->inContext($this->context);

        $this->assertCount(0, $context->getViolations());
    }

    public static function invalidPasswordWithDefaultConfiguration(): \Generator
    {
        yield 'no password' => [null, 'mact.form._error.null'];

        yield 'expect lower char' => [
            'PASSW0RD!',
            'mact.form._error.lower',
        ];

        yield 'expect upper char' => [
            'passw0rd!',
            'mact.form._error.upper',
        ];

        yield 'expect no less than 8 characters' => [
            'L0rem!',
            'mact.form._error.minChar',
        ];

        yield 'expect no more than 100 characters' => [
            'ThisismyPASSW0RD!Iwouldhavemorethan25characteresforexpecthaveoneviolation',
            'mact.form._error.maxChar',
        ];

        yield 'expect one numeric' => ['Password!', 'mact.form._error.nbDigit'];

        yield 'expect no space' => ['My Passw0rd!', 'mact.form._error.space'];

        yield 'expect one special character' => ['MyPassw0rd', 'mact.form._error.special'];
    }
}

<?php

namespace Mact\Tests\Unit\Validator\Constraint;

use Mact\Validator\Constraint\Password;
use Mact\Validator\Constraint\PasswordValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class PasswordValidatorConstraint extends TestCase
{
    /**
     * @test
     */
    public function acceptPassword(): void
    {
        $constaint = new Password(maxChar: 20);
        $validator = new PasswordValidator();

        $validator->validate('Password!', $constaint);

        $context = $this->getMockBuilder(ExecutionContextInterface::class)->getMock();
        $context
            ->expects($this->never())
            ->method('buildViolation');
    }
}

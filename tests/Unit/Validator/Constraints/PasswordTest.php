<?php

declare(strict_types = 1);

namespace Tests\Unit\Validator\Constraints;

use Mact\Exception\MinMaxException;
use Mact\Validator\Constraints\Password;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Password::class)]
class PasswordTest extends TestCase
{
    #[Test]
    public function testValidatePasswordConfiguration(): void
    {
        new Password();

        $this->expectNotToPerformAssertions();
    }

    #[Test]
    public function testExceptThrowException(): void
    {
        $this->expectException(MinMaxException::class);

        new Password(minChar: 25, maxChar: 8);
    }
}

<?php

declare(strict_types = 1);

namespace Functionnal\Repository;

use Mact\Repository\UserRepository;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

#[CoversClass(UserRepository::class)]
class UserRepositoryTest extends KernelTestCase
{
    use Factories;
    use ResetDatabase;

    public function testFindAll(): void
    {
        self::bootKernel();
        $this->assertSame(0, $this->getUserRepository()->count());
    }

    private function getUserRepository(): UserRepository
    {
        return self::getContainer()->get(UserRepository::class);
    }
}

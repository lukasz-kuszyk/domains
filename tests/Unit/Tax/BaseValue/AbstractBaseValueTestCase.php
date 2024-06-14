<?php

declare(strict_types=1);

namespace Nauta\Domain\Tests\Unit\Tax\BaseValue;

use Nauta\Domain\Tax\BaseValue\BaseValue;
use PHPUnit\Framework\TestCase;

abstract class AbstractBaseValueTestCase extends TestCase
{
    abstract protected function createInstance(int $value): BaseValue;

    public function testEqualsTrue(): void
    {
        self::assertTrue(
            $this->createInstance(100)->isEqualTo($this->createInstance(100)),
        );
    }

    public function testEqualsFalse(): void
    {
        self::assertFalse(
            $this->createInstance(100)->isEqualTo($this->createInstance(50)),
        );
    }

    public function testEqualsFalseForOtherInstances(): void
    {
        $otherValue = OtherBaseValue::fromNumeric(100);

        self::assertFalse(
            $this->createInstance(100)->isEqualTo($otherValue),
        );
    }

    public function testToString(): void
    {
        self::assertSame(
            '100',
            $this->createInstance(100)->__toString(),
        );
    }
}

class OtherBaseValue extends BaseValue
{
}

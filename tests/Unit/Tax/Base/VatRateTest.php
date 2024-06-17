<?php

declare(strict_types=1);

namespace Nauta\Domain\Tests\Unit\Tax\Base;

use Nauta\Domain\Tax\Base\VatRate;
use Nauta\Domain\Tax\Exception\NegativeVatRateException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class VatRateTest extends TestCase
{
    public static function provideIsEqual(): \Generator
    {
        yield [.0, 0, true];
        yield [1., 1., true];
        yield [.0, 1., false];
    }

    #[DataProvider('provideIsEqual')]
    public function testIsEqualTo(float $valueA, float $valueB, bool $expectedEqual): void
    {
        $result = VatRate::fromFraction($valueA)->isEqualTo(VatRate::fromFraction($valueB));

        $expectedEqual
            ? self::assertTrue($result)
            : self::assertFalse($result);
    }

    public function testZero(): void
    {
        self::assertTrue(VatRate::zero()->isEqualTo(VatRate::fromFraction(0)));
    }

    public function testThrowExceptionOnNegative(): void
    {
        self::expectException(NegativeVatRateException::class);

        VatRate::fromFraction(-1);
    }

    public function testGetRateAsFraction(): void
    {
        self::assertSame(VatRate::fromFraction(.1)->getRateAsFraction(), .1);
    }

    public function testGetRateAsPercentage(): void
    {
        self::assertSame(VatRate::fromFraction(1.)->getRateAsPercentage(), 100.0);
    }
}

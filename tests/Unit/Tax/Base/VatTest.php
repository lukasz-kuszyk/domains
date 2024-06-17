<?php

declare(strict_types=1);

namespace Nauta\Domain\Tests\Unit\Tax\Base;

use Nauta\Domain\Tax\Base\Gross;
use Nauta\Domain\Tax\Base\Net;
use Nauta\Domain\Tax\Base\Vat;
use Nauta\Domain\Tax\Base\VatRate;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class VatTest extends TestCase
{
    public static function provideIsEqual(): \Generator
    {
        yield [0, 0, true];
        yield [100, 100, true];
        yield [-100, -100, true];
        yield [0, 100, false];
        yield [-100, 100, false];
    }

    #[DataProvider('provideIsEqual')]
    public function testIsEqualTo(int $valueA, int $valueB, bool $expectedEqual): void
    {
        $result = Vat::fromNumeric($valueA)->isEqualTo(Vat::fromNumeric($valueB));

        $expectedEqual
            ? self::assertTrue($result)
            : self::assertFalse($result);
    }

    public static function provideFromNetAndRate(): \Generator
    {
        yield [0, .0, 0];
        yield [100, .0, 0];
        yield [100, .23, 23];
        yield [-100, .0, 0];
        yield [-100, .23, -23];
    }

    #[DataProvider('provideFromNetAndRate')]
    public function testFromNetAndRate(int $net, float $rate, float|int $expectedVat): void
    {
        $net = Net::fromNumeric($net);
        $rate = VatRate::fromFraction($rate);

        $result = Vat::fromNetAndRate($net, $rate);

        self::assertTrue(Vat::fromNumeric($expectedVat)->isEqualTo($result));
    }

    public static function provideFromGrossAndRate(): \Generator
    {
        yield [0, .0, 0];
        yield [123, .0, 0];
        yield [123, .23, 23];
        yield [-123, .0, 0];
        yield [-123, .23, -23];
    }

    #[DataProvider('provideFromGrossAndRate')]
    public function testFromGrossAndRate(int $gross, float $rate, float|int $expectedVat): void
    {
        $gross = Gross::fromNumeric($gross);
        $rate = VatRate::fromFraction($rate);

        $result = Vat::fromGrossAndRate($gross, $rate);

        self::assertTrue(Vat::fromNumeric($expectedVat)->isEqualTo($result));
    }
}

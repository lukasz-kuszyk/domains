<?php

declare(strict_types=1);

namespace Nauta\Domain\Tests\Unit\Tax\Base;

use Nauta\Domain\Tax\Base\Gross;
use Nauta\Domain\Tax\Base\Net;
use Nauta\Domain\Tax\Base\Vat;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class GrossTest extends TestCase
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
        $result = Gross::fromNumeric($valueA)->isEqualTo(Gross::fromNumeric($valueB));

        $expectedEqual
            ? self::assertTrue($result)
            : self::assertFalse($result);
    }

    public static function provideFromNetAndVat(): \Generator
    {
        yield [0, 0, 0];
        yield [100, 0, 100];
        yield [100, 23, 123];
        yield [-100, 0, -100];
        yield [-100, -23, -123];
        yield [-100, 23, -77];
    }

    #[DataProvider('provideFromNetAndVat')]
    public function testFromNetAndVat(int $net, int $vat, int $expectedGross): void
    {
        $net = Net::fromNumeric($net);
        $vat = Vat::fromNumeric($vat);

        $result = Gross::fromNetAndVat($net, $vat);

        self::assertTrue($result->isEqualTo(Gross::fromNumeric($expectedGross)));
    }

    public static function provideSubtract(): \Generator
    {
        yield [0, 0, 0];
        yield [123, 0, 123];
        yield [123, 23, 100];
        yield [-123, 0, -123];
        yield [-100, -23, -77];
        yield [-100, 23, -123];
    }

    #[DataProvider('provideSubtract')]
    public function testSubtract(int $gross, int $vat, int $expectedNet): void
    {
        $gross = Gross::fromNumeric($gross);
        $vat = Vat::fromNumeric($vat);

        $result = $gross->subtract($vat);

        self::assertTrue($result->isEqualTo(Net::fromNumeric($expectedNet)));
    }
}

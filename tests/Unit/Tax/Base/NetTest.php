<?php

declare(strict_types=1);

namespace Nauta\Domain\Tests\Unit\Tax\Base;

use Nauta\Domain\Tax\Base\Gross;
use Nauta\Domain\Tax\Base\Net;
use Nauta\Domain\Tax\Base\Vat;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class NetTest extends TestCase
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
        $result = Net::fromNumeric($valueA)->isEqualTo(Net::fromNumeric($valueB));

        $expectedEqual
            ? self::assertTrue($result)
            : self::assertFalse($result);
    }

    public static function provideFromGrossAndVat(): \Generator
    {
        yield [0, 0, 0];
        yield [123, 0, 123];
        yield [123, 23, 100];
        yield [-123, 0, -123];
        yield [-123, -23, -100];
        yield [-123, 23, -146];
    }

    #[DataProvider('provideFromGrossAndVat')]
    public function testFromGrossAndVat(int $gross, int $vat, int $expectedNet): void
    {
        $net = Gross::fromNumeric($gross);
        $vat = Vat::fromNumeric($vat);

        $result = Net::fromGrossAndVat($net, $vat);

        self::assertTrue($result->isEqualTo(Net::fromNumeric($expectedNet)));
    }

    public static function provideAdd(): \Generator
    {
        yield [0, 0, 0];
        yield [100, 0, 100];
        yield [100, 23, 123];
        yield [-100, 0, -100];
        yield [-100, -23, -123];
        yield [-100, 23, -77];
    }

    #[DataProvider('provideAdd')]
    public function testAdd(int $net, int $vat, int $expectedGross): void
    {
        $net = Net::fromNumeric($net);
        $vat = Vat::fromNumeric($vat);

        $result = $net->add($vat);

        self::assertTrue($result->isEqualTo(Gross::fromNumeric($expectedGross)));
    }
}

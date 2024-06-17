<?php

declare(strict_types=1);

namespace Monetary\Base;

use Nauta\Domain\Monetary\Base\Currency;
use Nauta\Domain\Monetary\Base\Money;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    public static function provideIsEqualTo(): \Generator
    {
        yield [
            new Money(new Currency('A'), 50),
            new Money(new Currency('A'), 50),
            true,
        ];

        yield [
            new Money(new Currency('A'), 50),
            new Money(new Currency('B'), 50),
            false,
        ];

        yield [
            new Money(new Currency('A'), 50),
            new Money(new Currency('A'), 25),
            false,
        ];

        yield [
            new Money(new Currency('A'), 50),
            new Money(new Currency('B'), 25),
            false,
        ];
    }

    #[DataProvider('provideIsEqualTo')]
    public function testIsEqualTo(Money $moneyA, Money $moneyB, bool $expectedEqual): void
    {
        $result = $moneyA->isEqualTo($moneyB);

        $expectedEqual ?
            self::assertTrue($result) :
            self::assertFalse($result);
    }
}
